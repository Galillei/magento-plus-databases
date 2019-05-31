<?php


namespace MagentoPlus\DataBases\Api;


interface TestWebApiInterface
{
    /**
     * @param int $customerId
     * @return string[]
     */
    public function getCustomerData(int $customerId);


    /**
     * @param string[] $data
     * @return string[]
     */
    public function setCustomerData(array $data);


    /**
     * @param int $customerId
     * @param string[] $data
     * @return string
     */
    public function setCustomerDataWithParam(int $customerId, array $data);
}