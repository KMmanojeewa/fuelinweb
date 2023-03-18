<?php
namespace FuelIn\Model;


use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBDate;
use SilverStripe\ORM\FieldType\DBDatetime;

class FuelOrder extends DataObject
{
    private static $table_name = 'FuelOrder';

    private static $db = [
        'Amount' => 'Varchar',
        'FuelType' => 'Enum("Petrol, Diesel", "Petrol")',
        'OrderDate' => 'Date',
        'ScheduledDate' => 'Date',
        'DispatchedDate' => 'Date',
        'ExpectedDeliveryDate' => 'Date',
        'DeliveredDate' => 'Date',
        'Status' => 'Enum("Draft, Scheduled, Confirmed, Dispatched, Delivered", "Draft")',
    ];

    private static $has_one = [
        'ServiceCenter' => ServiceCenter::class
    ];

    private static $has_many = [
        'FuelRequests' => FuelRequest::class
    ];

    private static $summary_fields = [
        'ID',
        'Amount',
        'OrderDate',
        'ExpectedDeliveryDate',
        'Status',
    ];

    public function toJSONData()
    {
        $data = [];
        $data['id'] = $this->ID;
        $data['amount'] = $this->Amount;
        $data['fuel_type'] = $this->FuelType;
        $data['date'] = $this->OrderDate;
        $data['status'] = $this->Status;
        return $data;
    }

    public function onAfterWrite()
    {
        parent::onAfterWrite();

        if($this->Status === 'Scheduled' && !$this->ScheduledDate) {
            $this->ScheduledDate = DBDatetime::now()->Format('y-MM-dd');
            $this->write();
        }
    }

}
