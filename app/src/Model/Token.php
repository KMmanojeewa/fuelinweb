<?php
namespace FuelIn\Model;


use SilverStripe\ORM\DataObject;

class Token extends DataObject
{
    private static $table_name = 'Token';

    private static $db = [
        'Name' => 'Varchar',
        'TokenDate' => 'Date',
        'TokenTime' => 'Time',
        'Amount' => 'Varchar',
        'Status' => 'Enum("Issued, Pending", "Issued")',
        'IsPaid' => 'Enum("Paid, NotPaid", "NotPaid")',
    ];

    private static $has_one = [
        'Vehicle' => Vehicle::class,
        'ServiceCenter' => ServiceCenter::class,
        'FuelOrder' => FuelOrder::class,
    ];
}
