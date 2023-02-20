<?php
namespace FuelIn\Admin;

use FuelIn\Model\Location;
use SilverStripe\Admin\ModelAdmin;

class LocationAdmin extends ModelAdmin
{
    private static $menu_title = 'Locations';

    private static $url_segment = 'locations';

    private static $managed_models = [
        Location::class
    ];
}
