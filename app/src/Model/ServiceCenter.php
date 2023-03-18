<?php
namespace FuelIn\Model;


use SilverStripe\ORM\DataObject;

class ServiceCenter extends DataObject
{
    private static $table_name = 'ServiceCenter';

    private static $db = [
        'Name' => 'Varchar',
        'TankCapacity' => 'Varchar',
    ];

    private static $has_one = [
        'Location' => Location::class
    ];

    private static $has_many = [
        'FuelOrders' => FuelOrder::class
    ];

    private static $summary_fields = [
        'ID',
        'Name',
        'Location.Name'
    ];
}
