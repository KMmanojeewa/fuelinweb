<?php

namespace FuelIn\Controller;


use FuelIn\Model\Customer;
use SilverStripe\Control\HTTPResponse;

class LoginController extends \PageController
{
    private static $allowed_actions = [
        'login',
        'register',
        'makeFuelOrder',
    ];



    public function register()
    {
        $data = $this->getPayloadData();
        $name = $data['name'];
        $nic = $data['nic'];
        $email = $data['email'];
        $phone = $data['phone'];
        $address = $data['address'];
        $password = $data['password'];
        $ret = [];

        if($name && $nic && $email && $phone && $address && $password) {

            $customer = Customer::get()->filterAny([
                'NIC' => $nic,
                'Email' => $email,
                'Name' => $nic,
            ])->first();

            if (!$customer) {
                $customer = Customer::create([
                    'Email' => $email,
                    'Password' => $password,
                    'NIC' => $nic,
                    'Phone' => $phone,
                    'Address' => $address,
                    'Name' => $name,
                ]);
                $customer->write();
                $status = 0;
                $message = 'successfully created';
                $customer = [
                    'id' => $customer->ID,
                    'name' => $customer->Name,
                ];
            } else {
                $status = 1;
                $message = 'Incorrect data, please check again and try';
                $customer = [];
            }

            $ret['status'] = $status;
            $ret['message'] = $message;
            $ret['customer'] = $customer;

        }

        return $this->jsonResponse($ret);
    }

    public function login()
    {
        $data = $this->getPayloadData();
        $email = $data['email'];
        $password = $data['password'];
        $ret = [];

        if($email && $password) {

            $customer = Customer::get()->filter([
                'Email' => $email,
                'Password' => $password,
            ])->first();

            if($customer) {
                $status = 0;
                $message = 'successfully logged';
                $customer = [
                    'id' => $customer->ID,
                    'name' => $customer->Name,
                ];
            } else {
                $status = 1;
                $message = 'Incorrect data, please check again and try';
                $customer = [];
            }

            $ret['status'] = $status;
            $ret['message'] = $message;
            $ret['customer'] = $customer;
        }
        return $this->jsonResponse($ret);
    }

    public function makeFuelOrder()
    {
        $data = $this->getPayloadData();
        $serviceCenterID = $data['center_id'];
        $fuelType = $data['fuel_type']; $amount = $data['amount'];
        $date = $data['date'];
        $vehicle = FuelOrder::create([ 
            'Amount'=> $amount, 
            'FuelType'=> $fuelType, 
            'Date'=> $date, 'Status'=> 'Draft',
            'ServiceCenterID'=> $serviceCenterID,
             ]);
        $vehicle->write();
        $orders = FuelOrder::get()->filter('ServiceCenterID', $serviceCenterID);
        $arr = [];
        foreach ($orders as $order) {
            $arr[] = $order->toJSONData();
         }
         $ret['status'] = 0;
         $ret['message'] = 'order placed successfully';
         $ret['orders'] = $arr;
          return $this->jsonResponse($ret);
    }


}
