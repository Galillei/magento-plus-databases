<?php

namespace MagentoPlus\DataBases\Model;

use Magento\Framework\Model\AbstractExtensibleModel;

class ExampleAttribute extends AbstractExtensibleModel implements \MagentoPlus\DataBases\Api\Data\ExampleAttributeInterface
{

    /**
     * @param string $example
     * @return $this
     */
    public function setExample(string $example)
    {
        return parent::setData('example', $example);
    }

    /**
     * @return string|null
     */
    public function getExample()
    {
        return parent::getData('example');
    }

    /**
     * @param \MagentoPlus\DataBases\Api\Data\ExampleAttributeExtensionInterface $exampleAttribute
     * @return $this
     */
    public function setExtensionAttributes(\MagentoPlus\DataBases\Api\Data\ExampleAttributeExtensionInterface $exampleAttribute)
    {
        return $this->_setExtensionAttributes($exampleAttribute);
    }

    /**
     * @return \MagentoPlus\DataBases\Api\Data\ExampleAttributeExtensionInterface
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }
}
