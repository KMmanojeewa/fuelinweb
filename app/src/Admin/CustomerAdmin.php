<?php
namespace FuelIn\Admin;

use FuelIn\Model\Customer;
use SilverStripe\Admin\ModelAdmin;

class CustomerAdmin extends ModelAdmin
{
    private static $menu_title = 'Customers';

    private static $url_segment = 'customers';

    private static $managed_models = [
        Customer::class
    ];
}
