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
        'VehicleType' => VehicleType::class
    ];
}
