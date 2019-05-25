<?php

declare(strict_types=1);

namespace MagentoPlus\DataBases\Model;

use Magento\AsynchronousOperations\Api\Data\AsyncResponseInterface;
use Magento\AsynchronousOperations\Api\Data\AsyncResponseInterfaceFactory;
use Magento\AsynchronousOperations\Api\Data\ItemStatusInterface;
use Magento\AsynchronousOperations\Api\Data\ItemStatusInterfaceFactory;
use Magento\AsynchronousOperations\Api\Data\OperationInterface;
use Magento\AsynchronousOperations\Model\ResourceModel\Operation\OperationRepository;
use Magento\Authorization\Model\UserContextInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Bulk\BulkManagementInterface;
use Magento\Framework\DataObject\IdentityGeneratorInterface;
use Magento\Framework\Exception\BulkException;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Magento\AsynchronousOperations\Api\Data\OperationInterfaceFactory;


class ScheduleBulk
{
    /**
     * @var \Magento\Framework\DataObject\IdentityGeneratorInterface
     */
    private $identityService;

    /**
     * @var AsyncResponseInterfaceFactory
     */
    private $asyncResponseFactory;

    /**
     * @var ItemStatusInterfaceFactory
     */
    private $itemStatusInterfaceFactory;

    /**
     * @var \Magento\Framework\Bulk\BulkManagementInterface
     */
    private $bulkManagement;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var OperationRepository
     */
    private $operationRepository;

    /**
     * @var \Magento\Authorization\Model\UserContextInterface
     */
    private $userContext;
    /**
     * @var OperationInterfaceFactory
     */
    private $operationFactory;

    /**
     * Initialize dependencies.
     *
     * @param IdentityGeneratorInterface $identityService
     * @param ItemStatusInterfaceFactory $itemStatusInterfaceFactory
     * @param AsyncResponseInterfaceFactory $asyncResponseFactory
     * @param BulkManagementInterface $bulkManagement
     * @param LoggerInterface $logger
     * @param OperationRepository $operationRepository
     * @param OperationInterfaceFactory $operationFactory
     */
    public function __construct(
        IdentityGeneratorInterface $identityService,
        ItemStatusInterfaceFactory $itemStatusInterfaceFactory,
        AsyncResponseInterfaceFactory $asyncResponseFactory,
        BulkManagementInterface $bulkManagement,
        LoggerInterface $logger,
        OperationRepository $operationRepository,
        OperationInterfaceFactory $operationFactory
    ) {
        $this->identityService = $identityService;
        $this->itemStatusInterfaceFactory = $itemStatusInterfaceFactory;
        $this->asyncResponseFactory = $asyncResponseFactory;
        $this->bulkManagement = $bulkManagement;
        $this->logger = $logger;
        $this->operationRepository = $operationRepository;
        $this->operationFactory = $operationFactory;
    }

    /**
     * Schedule new bulk operation based on the list of entities
     *
     * @param string $topicName
     * @param array $entitiesArray
     * @param string $groupId
     * @param string $userId
     * @return AsyncResponseInterface
     * @throws BulkException
     * @throws LocalizedException
     */
    public function publishMass($topicName = 'test.bulk.save', $userId=1, $groupId = null)
    {
        $bulkDescription = __('Topic %1', $topicName);

        if ($userId == null) {
            $userId = $this->userContext->getUserId();
        }

        if ($groupId == null) {
            $groupId = $this->identityService->generateId();

            /** create new bulk without operations */
            if (!$this->bulkManagement->scheduleBulk($groupId, [], $bulkDescription, $userId)) {
                throw new LocalizedException(
                    __('Something went wrong while processing the request.')
                );
            }
        }

        $requestItems = [];
        $bulkException = new BulkException();
        $operationCount = 100;
        $operations = [];

        for ($index = 0; $index < $operationCount; $index++) {
            /** @var \Magento\AsynchronousOperations\Api\Data\ItemStatusInterface $requestItem */
            $requestItem = $this->itemStatusInterfaceFactory->create();
            /** @var OperationInterface $operation */
            $operation = $this->operationFactory->create();
            $operation->setBulkUuid($groupId);
            $operation->setTopicName($topicName);
            $operation->setSerializedData(json_encode(['entity_id' => $index]));
            /** @var OperationInterface $operation */
            $operations [] = $this->operationRepository->createByTopic($topicName, $operation, $groupId);
            $requestItem->setId($index);
            $requestItem->setStatus(ItemStatusInterface::STATUS_ACCEPTED);
            $requestItems[] = $requestItem;

        }
        if (!$this->bulkManagement->scheduleBulk($groupId, $operations, $bulkDescription, $userId)) {
            throw new LocalizedException(
                __('Something went wrong while processing the request.')
            );
        }

        /** @var AsyncResponseInterface $asyncResponse */
        $asyncResponse = $this->asyncResponseFactory->create();
        $asyncResponse->setBulkUuid($groupId);
        $asyncResponse->setRequestItems($requestItems);

        if ($bulkException->wasErrorAdded()) {
            $asyncResponse->setErrors(true);
            $bulkException->addData($asyncResponse);
            throw $bulkException;
        } else {
            $asyncResponse->setErrors(false);
        }

        return $asyncResponse;
    }
}
