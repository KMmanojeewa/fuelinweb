<?php

namespace FuelIn\Model;


use SilverStripe\ORM\DataObject;

class VehicleType extends DataObject
{
    private static $table_name = 'VehicleType';

    private static $db = [
        'Name' => 'Varchar',
        'Quota' => 'Varchar',
    ];

}
