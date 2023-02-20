<?php
namespace FuelIn\Admin;

use FuelIn\Model\FuelOrder;
use SilverStripe\Admin\ModelAdmin;

class FuelOrderAdmin extends ModelAdmin
{
    private static $menu_title = 'FuelOrders';

    private static $url_segment = 'fuel-orders';

    private static $managed_models = [
        FuelOrder::class
    ];
}
