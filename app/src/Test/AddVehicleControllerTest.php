<?php
namespace FuelIn\Test;

use FuelIn\Controller\FuelController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\SapphireTest;

class AddVehicleControllerTest extends SapphireTest
{

    public function randNumber($digits)
    {
        return rand(pow(10, $digits-1), pow(10, $digits)-1);
    }

    public function testAddVehicle()
    {
        $request = new HTTPRequest('POST', 'fuel/addVehicle', [], [], json_encode([
            'number' => 'GA-'.$this->randNumber(4),
            'chassis' => '223366554499',
            'type' => 'Car',//vehicle type id
            'fuel' => 'Petrol',
            'customer' => 1,//customer id
            'date' => '2023-03-18',
        ]));

        $controller = new FuelController();
        $response = $controller->addVehicle($request);

        $this->assertSame('application/json', $response->getHeader('Content-Type'));
        $json = json_decode($response->getBody(), true);


        //no vehicle or customer test
        $this->assertSame(0, $json['status']);
        $this->assertSame('successfully registered', $json['message']);

    }
}
