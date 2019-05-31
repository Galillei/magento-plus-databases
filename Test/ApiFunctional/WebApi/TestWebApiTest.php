<?php

namespace MagentoPlus\DataBases\Test\ApiFunctional\WebApi;

class TestWebApiTest extends \Magento\TestFramework\TestCase\WebapiAbstract
{
    public function testCustomerData()
    {
        $itemId = 1;
        $serviceInfo = [
            'rest' => [
                'resourcePath' => '/V1/testwebapi/customerdata/' . $itemId,
                'httpMethod' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_GET,
            ]
        ];
        $requestData = ['itemId' => $itemId];
        $item = $this->_webApiCall($serviceInfo, $requestData);
        $this->assertEquals(1, count($item), "Item was retrieved unsuccessfully");
        $this->assertEquals(1, reset($item), "Item was retrieved unsuccessfully");
    }

    public function testSetCustomerData()
    {
        $itemId =1;
        $serviceInfo = [
            'rest' => [
                'resourcePath' => '/V1/testwebapi/setcustomerdata/',
                'httpMethod' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_POST,
            ]
        ];
        $requestData = ['data' => [$itemId]];
        $item = $this->_webApiCall($serviceInfo, $requestData);
        $this->assertEquals(1, count($item), "Item was retrieved unsuccessfully");
        $this->assertEquals(1, reset($item), "Item was retrieved unsuccessfully");
    }

    public function testSetCustomerDataWithParametrInUrl()
    {
        $itemId =1;
        $serviceInfo = [
            'rest' => [
                'resourcePath' => '/V1/testwebapi/setcustomerdata/'.$itemId,
                'httpMethod' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_POST,
            ]
        ];
        $requestData = ['data' => [$itemId]];
        $response = $this->_webApiCall($serviceInfo, $requestData);
        $this->assertEquals( $response, "Add parameter to url, it is mean that it is simple another url");
    }
}
