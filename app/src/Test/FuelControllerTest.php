<?php
namespace FuelIn\Test;

use FuelIn\Controller\FuelController;
use FuelIn\Controller\LoginController;
use FuelIn\Model\Customer;
use FuelIn\Model\FuelOrder;
use FuelIn\Model\FuelRequest;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\SapphireTest;

class FuelControllerTest extends SapphireTest
{
    //test run vendor/bin/phpunit app/src/Test/FuelControllerTest.php
//    public function testGetVehicles()
//    {
//        $userid = '1';
//        $cus = Customer::get()->filter('ID', $userid)->first();
//        $firstVehicle = $cus->Vehicles()->first();
//        $this->assertEquals(1, $firstVehicle->ID);
//    }



    public function testFuelRequestAvailability($data)
    {
        //assume saterday and sunday not deliver fuel

        $customerID = $data['customer_id'];
        $serviceCenterID = $data['service_center_id'];

        $lastFuelRequest = FuelRequest::get()->filter([
            'CustomerID' => $customerID
        ])->last();

        $lastFuelRequestWeek = '';
        if($lastFuelRequest) {
            $lastFuelRequestDate = new \DateTime($lastFuelRequest->Date);
            $lastFuelRequestWeek = $lastFuelRequestDate->format("W");
        }

        $orders = FuelOrder::get()->filter([
            'ServiceCenterID' => $serviceCenterID,
            'Status' => 'Scheduled',
        ]);

        $noQuota = false;


        foreach ($orders as $order) {
            $deliver = new \DateTime($order->ExpectedDeliveryDate);
            $deliverWeek = $deliver->format("W");

            if($lastFuelRequestWeek && ($lastFuelRequestWeek == $deliverWeek)) {
                $noQuota = true;
            }

        }

        $arr = [];
        if(!$noQuota) {
            if($orders->count()) {
                foreach ($orders as $order) {
                    $arr[] = $order->toJSONData();
                }
                $ret['status'] = 0;
                $ret['message'] = 'order placed successfully';
                $ret['orders'] = $arr;
                return $ret;
            } else {
                $ret['status'] = 2;
                $ret['message'] = 'No fuel schedules';
                return $ret;
            }

        } else {
            $ret['status'] = 1;
            $ret['message'] = 'No quota';
            return $ret;
        }


    }

}
