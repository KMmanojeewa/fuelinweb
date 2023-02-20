<?php

namespace FuelIn\Controller;


use FuelIn\Model\Customer;
use FuelIn\Model\FuelOrder;
use FuelIn\Model\ServiceCenter;
use FuelIn\Model\Vehicle;
use FuelIn\Model\VehicleType;
use SilverStripe\Control\HTTPResponse;

class CustomerController extends \PageController
{
    private static $allowed_actions = [
        'getCustomerData'
    ];


    public function getCustomerData()
    {
        $data = $this->getPayloadData();
        $userid = $data['id'];


    }

}
