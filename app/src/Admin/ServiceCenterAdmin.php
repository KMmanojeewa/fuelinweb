<?php
namespace FuelIn\Admin;

use FuelIn\Model\ServiceCenter;
use SilverStripe\Admin\ModelAdmin;

class ServiceCenterAdmin extends ModelAdmin
{
    private static $menu_title = 'Service Centers';

    private static $url_segment = 'service-centers';

    private static $managed_models = [
        ServiceCenter::class
    ];
}
