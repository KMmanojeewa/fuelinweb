<?php

namespace FuelIn\Controller;


use FuelIn\Model\Customer;
use SilverStripe\Control\HTTPResponse;

class LoginController extends \PageController
{
    private static $allowed_actions = [
        'login',
        'register',
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
                'Name' => $name,
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


}
