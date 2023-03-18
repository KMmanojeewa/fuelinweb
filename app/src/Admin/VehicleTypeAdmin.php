<?php
namespace FuelIn\Admin;

use FuelIn\Model\Customer;
use FuelIn\Model\VehicleType;
use SilverStripe\Admin\ModelAdmin;

class VehicleTypeAdmin extends ModelAdmin
{
    private static $menu_title = 'Vehicle Type';

    private static $url_segment = 'vehicle-type';

    private static $managed_models = [
        VehicleType::class
    ];
}
