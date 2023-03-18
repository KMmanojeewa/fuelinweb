<?php

namespace FuelIn\Model;


use SilverStripe\ORM\DataObject;

class Vehicle extends DataObject
{
    private static $table_name = 'Vehicle';

    private static $db = [
        'VehicleNumber' => 'Varchar',
        'ChassisNumber' => 'Varchar',
        'FuelType' => 'Varchar',
    ];

    private static $has_one = [
        'VehicleType' => VehicleType::class,
        'Customer' => Customer::class
    ];


    private static $summary_fields = [
        'ID',
        'VehicleNumber',
        'FuelType'
    ];

    public function toJSONData()
    {
        $data = [];
        $data['id'] = $this->ID;
        $data['vehicle_number'] = $this->VehicleNumber;
        $data['fuel_type'] = $this->FuelType;
        $data['vehicle_type'] = $this->VehicleType()->Name;
        return $data;
    }
}
