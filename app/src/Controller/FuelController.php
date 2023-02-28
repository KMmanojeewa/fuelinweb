<?php

namespace FuelIn\Controller;


use FuelIn\Model\Customer;
use FuelIn\Model\FuelOrder;
use FuelIn\Model\FuelRequest;
use FuelIn\Model\Vehicle;
use FuelIn\Model\VehicleType;
use SilverStripe\ORM\FieldType\DBDatetime;

class FuelController extends \PageController
{
    private static $allowed_actions = [
        'getVehicles',
    ];

    public function getVehicles()
    {
        $data = $this->getPayloadData();
        $userid = $data['id'];
        $cus = Customer::get()->filter('ID', $userid)->first();
        $arr = [];
        foreach ($cus->Vehicles() as $veh) {
            $arr[] = $veh->toJSONData();
        }
        $ret['vehicles'] = $arr;
        return $this->jsonResponse($ret);
    }

    public function fuelRequestAvailability()
    {
        //assume saterday and sunday not deliver fuel

        $data = $this->getPayloadData();
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
                return $this->jsonResponse($ret);
            } else {
                $ret['status'] = 2;
                $ret['message'] = 'No fuel schedules';
                return $this->jsonResponse($ret);+
            }

        } else {
            $ret['status'] = 1;
            $ret['message'] = 'No quota';
            return $this->jsonResponse($ret);
        }


    }

    public function fuelRequest()
    {
        $data = $this->getPayloadData();
        $customerID = $data['customer_id'];
        $orderID = $data['order_id'];
        $requestAmount = $data['amount'];
        $ret = [];

        $order = FuelOrder::get()->filter([
            'ID' => $orderID,
        ])->first();

        $issuedAmount = 0;
        foreach ($order->FuelRequests() as $request) {
            $issuedAmount += $request->Amount;
        }

        if(($order->Amount - $issuedAmount) >= $requestAmount) {
            $fuelRequest = FuelRequest::create([
                'Amount' => $requestAmount,
                'CustomerID' => $customerID,
                'FuelOrderID' => $orderID,
            ]);
            $fuelRequest->write();
            $ret['status'] = 0;
            $ret['message'] = 'fuel request created successfully';
        } else {
            $ret['status'] = 1;
            $ret['message'] = 'fuel request cannot make';
        }
        return $this->jsonResponse($ret);
    }

    public function makeFuelOrder()
     { $data = $this->getPayloadData(); $serviceCenterID = $data['center_id']; $fuelType = $data['fuel_type']; 
        $amount = $data['amount'];
        $date = $data['date']; 
        $vehicle = FuelOrder::create([ 'Amount'=> $amount, 'FuelType'=> $fuelType,'Date'=> $date, 'Status'=> 'Draft', 'ServiceCenterID'=> $serviceCenterID, ]); 
        $vehicle->write(); 
        $orders = FuelOrder::get()->filter('ServiceCenterID', $serviceCenterID); 
        $arr = []; foreach ($orders as $order) { $arr[] = $order->toJSONData(); } $ret['status'] = 0; 
        $ret['message'] = 'order placed successfully'; $ret['orders'] = $arr; return $this->jsonResponse($ret);
    }

    public function addVehicle() 
    { $data = $this->getPayloadData(); $number = $data['number']; $chassisNumber = $data['chassis']; $type = $data['type']; $fuel = $data['fuel']; $cusID = $data['customer']; $ret = []; if($number && $chassisNumber && $type && $fuel) { $vehicle = Vehicle::get()->filterAny([ 'VehicleNumber'=> $number, 'ChassisNumber'=> $chassisNumber ])->first(); if(!$vehicle) { $vType = VehicleType::get()->filter('Name', $type)->first(); $cus = Customer::get()->filter('ID', $cusID)->first(); if($vType && $cus) { $vehicle = Vehicle::create([ 'VehicleNumber'=> $number, 'ChassisNumber'=> $chassisNumber, 'FuelType'=> $fuel, 'VehicleTypeID'=> $vType->ID, 'Customer'=> $cus->ID, ]); $vehicle->write(); $status = 0; $message = 'successfully registered'; $arr = []; foreach ($cus->Vehicles() as $veh) { $arr[] = $veh->toJSONData(); } $vehicles = $arr; } } else { $status = 1; $message = 'These details already used'; $vehicles = []; } $ret['status'] = $status; $ret['message'] = $message; $ret['vehicles'] = $vehicles; } return $this->jsonResponse($ret); 
    }

}
