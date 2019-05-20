<?php

namespace MagentoPlus\DataBases\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface ExampleAttributeInterface extends ExtensibleDataInterface
{
    /**
     * @param string $example
     * @return $this
     */
    public function setExample(string  $example);

    /**
     * @return string|null
     */
    public function getExample();

    /**
     * @param \MagentoPlus\DataBases\Api\Data\ExampleAttributeExtensionInterface $exampleAttribute
     * @return $this
     */
    public function setExtensionAttributes(
        \MagentoPlus\DataBases\Api\Data\ExampleAttributeExtensionInterface $exampleAttribute
    );

    /**
     * @return \MagentoPlus\DataBases\Api\Data\ExampleAttributeExtensionInterface
     */
    public function getExtensionAttributes();
}
