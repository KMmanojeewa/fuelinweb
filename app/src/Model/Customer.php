<?php
namespace FuelIn\Model;


use SilverStripe\ORM\DataObject;

class Customer extends DataObject
{
    private static $table_name = 'Customer';

    private static $db = [
        'Name' => 'Varchar',
        'Email' => 'Varchar',
        'NIC' => 'Varchar',
        'Phone' => 'Varchar',
        'Address' => 'Varchar',
        'Password' => 'Varchar',
    ];

    private static $has_many = [
        'Vehicles' => Vehicle::class
    ];
}
