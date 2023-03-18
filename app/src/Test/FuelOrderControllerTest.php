<?php
namespace FuelIn\Test;

use FuelIn\Controller\FuelController;
use FuelIn\Model\FuelOrder;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Dev\TestSession;
use SilverStripe\ORM\DataObject;

class FuelOrderControllerTest extends SapphireTest
{
    /**
     * @var FuelController
     */
    protected $controller;


    public function testMakeFuelOrder()
    {
        // Create a new HTTP request with the necessary data
        $request = new HTTPRequest('POST', 'fuel/makeFuelOrder', [], [], json_encode([
            'center_id' => 1,
            'fuel_type' => 'Diesel',
            'amount' => '50',
            'date' => '2023-03-18',
        ]));

        // Create a new instance of the controller and call the method
        $controller = new FuelController();
        $response = $controller->makeFuelOrder($request);

        // Check that the response is valid JSON and contains the expected data
        $this->assertSame('application/json', $response->getHeader('Content-Type'));
        $json = json_decode($response->getBody(), true);
        $this->assertSame(0, $json['status']);
        $this->assertSame('order placed successfully', $json['message']);

        // Check that the new fuel order was created
        $order = DataObject::get(FuelOrder::class, ['ServiceCenterID' => 1])->last();
//        $this->assertCount(1, $order);
        $this->assertSame('50', $order->Amount);
        $this->assertSame('Diesel', $order->FuelType);
        $this->assertSame('2023-03-18', $order->OrderDate);

        // Check that the orders array in the response contains the new order
//        $this->assertCount(1, $json['orders']);
        $this->assertSame('50', $json['orders'][0]['amount']);
        $this->assertSame('Diesel', $json['orders'][0]['fuel_type']);
        $this->assertSame('2023-03-18', $json['orders'][0]['date']);
    }


}

