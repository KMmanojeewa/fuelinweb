<?php
namespace FuelIn\Test;

use FuelIn\Model\Customer;
use SilverStripe\Dev\SapphireTest;

class FuelControllerTest extends SapphireTest
{
    //test run vendor/bin/phpunit app/src/Test/FuelControllerTest.php
    public function testGetVehicles()
    {
        $userid = '1';
        $cus = Customer::get()->filter('ID', $userid)->first();
        $firstVehicle = $cus->Vehicles()->first();
        $this->assertEquals(1, $firstVehicle->ID);
    }
}
