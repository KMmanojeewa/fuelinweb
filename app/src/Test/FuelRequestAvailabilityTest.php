<?php
namespace FuelIn\Test;

use FuelIn\Controller\FuelController;
use FuelIn\Model\FuelOrder;
use FuelIn\Model\FuelRequest;
use SilverStripe\Dev\SapphireTest;

class FuelRequestAvailabilityTest extends SapphireTest {

    public function testFuelRequestAvailability() {

        // Mock the payload data
        $data = [
            'customer_id' => 1,
            'service_center_id' => 2
        ];

        // Create some test data
        $lastFuelRequest = FuelRequest::create();
        $lastFuelRequest->CustomerID = 1;
        $lastFuelRequest->Date = '2022-03-10';
        $lastFuelRequest->write();

        $order1 = FuelOrder::create();
        $order1->ServiceCenterID = 2;
        $order1->ExpectedDeliveryDate = '2022-03-14';
        $order1->Status = 'Scheduled';
        $order1->write();

        $order2 = FuelOrder::create();
        $order2->ServiceCenterID = 2;
        $order2->ExpectedDeliveryDate = '2022-03-21';
        $order2->Status = 'Scheduled';
        $order2->write();

        $controller = new FuelControllerTest();

        // Call the function with the mocked data
        $response = $controller->testFuelRequestAvailability($data);

        // Assert that the response has the expected keys and values
        $this->assertArrayHasKey('status', $response);
        $this->assertEquals(0, $response['status']);

        $this->assertArrayHasKey('message', $response);
        $this->assertEquals('order placed successfully', $response['message']);

        $this->assertArrayHasKey('orders', $response);
        $this->assertCount(2, $response['orders']);
    }

}
