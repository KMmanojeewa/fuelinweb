<?php
namespace FuelIn\Model;


use SilverStripe\ORM\DataObject;

class Customer extends DataObject
{
    private static $table_name = 'Customer';

    private static $db = [
        'Name' => 'Varchar',
        'NIC' => 'Varchar',
        'Email' => 'Varchar',
        'Phone' => 'Varchar',
        'Address' => 'Varchar',
        'Password' => 'Varchar',
    ];

    private static $has_many = [
        'Vehicles' => Vehicle::class
    ];

    public function toJSONData()
    {
        $data = [];
        $data['id'] = $this->ID;
        $data['name'] = $this->Name;
        $data['email'] = $this->Email;
        $data['phone'] = $this->Phone;
        $data['address'] = $this->Address;
        return $data;
    }
}
