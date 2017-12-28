<?php

namespace App\AppPacket\Entity;

/**
* 
*/
class Invoice 
{
    const TABLE = 'invoices';
    public function __construct()
    {}

    private $id;
    private $client;
    private $invoice_amount;
    private $invoice_amount_plus_vat;
    private $vat_rate;
    private $invoice_status;
    private $invoice_date;
    private $created_at;

    public function getId()
    {
        return $id;
    }

    public function getClient()
    {
        return $client;
    }

    public function getAmountWithoutTax()
    {
        return $invoice_amount;
    }

    public function getAmountWithTax()
    {
        return $invoice_amount_plus_vat;
    }

    public function getTaxRate()
    {
        return $vat_rate;
    }

    public function getStatus()
    {
        return $invoice_status;
    }

    public function getDate()
    {
        return $invoice_date;
    }

    public function getCreatedAt()
    {
        return $created_at;
    }

    public function setStatus()
    {
        $this->status = $invoice_status;
    }
}