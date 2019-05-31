<?php

namespace MagentoPlus\DataBases\Model\WebApi;

class TestWebApi implements \MagentoPlus\DataBases\Api\TestWebApiInterface
{

    /**
     * @param int $customerId
     * @return string[]
     */
    public function getCustomerData(int $customerId)
    {
        return [$customerId];
    }

    /**
     * @param string[] $data
     * @return string[]
     */
    public function setCustomerData(array $data)
    {
        return $data;
    }

    /**
     * @param int $customerId
     * @param string[] $data
     * @return string
     */
    public function setCustomerDataWithParam(int $customerId, array $data)
    {
        return 'Add parameter to url, it is mean that it is simple another url';
    }
}
