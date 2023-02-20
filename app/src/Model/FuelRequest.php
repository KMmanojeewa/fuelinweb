<?php
namespace FuelIn\Model;


use SilverStripe\ORM\DataObject;

class FuelRequest extends DataObject
{
    private static $table_name = 'FuelRequest';

    private static $db = [
        'Amount' => 'Varchar',
        'Date' => 'Varchar',
    ];

    private static $has_one = [
        'FuelOrder' => FuelOrder::class,
        'Customer' => Customer::class,
    ];

    public function toJSONData()
    {
        $data = [];
        $data['id'] = $this->ID;
        $data['name'] = $this->Name;
        return $data;
    }
}
