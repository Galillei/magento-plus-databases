<?php

declare(strict_types=1);

namespace MagentoPlus\DataBases\Model\Consumer;

use Magento\Framework\Bulk\BulkManagementInterface;
use Magento\AsynchronousOperations\Api\Data\OperationInterface;
use Magento\AsynchronousOperations\Api\Data\OperationInterfaceFactory;
use Magento\Framework\DB\Adapter\ConnectionException;
use Magento\Framework\DB\Adapter\DeadlockException;
use Magento\Framework\DB\Adapter\LockWaitException;
use Magento\Framework\Exception\TemporaryStateExceptionInterface;

/**
 * Class Consumer
 */
class TestRpcConsumer
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    private $jsonHelper;


    /**
     * Consumer constructor.
     *
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Serialize\Serializer\Json $jsonHelper
    ) {
        $this->logger = $logger;
        $this->jsonHelper = $jsonHelper;
    }

    /**
     *
     * @param string $data
     * @return void
     */
    public function processOperation(string $data)
    {
        try {
            $this->logger->debug('test.rpc.consumer');
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
        return 'test.rpc.consumer'.$data;

    }
}
