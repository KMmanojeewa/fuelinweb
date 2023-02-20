<?php
namespace FuelIn\Model;


use SilverStripe\ORM\DataObject;

class Location extends DataObject
{
    private static $table_name = 'Location';

    private static $db = [
        'Name' => 'Varchar'
    ];
}
