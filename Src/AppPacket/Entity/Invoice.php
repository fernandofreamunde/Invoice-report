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
        return $this->id;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getAmountWithoutTax()
    {
        return $this->invoice_amount;
    }

    public function getAmountWithTax()
    {
        return $this->invoice_amount_plus_vat;
    }

    public function getTaxRate()
    {
        return $this->vat_rate;
    }

    public function getStatus()
    {
        return $this->invoice_status;
    }

    public function getDate()
    {
        return $this->invoice_date;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setStatus()
    {
        $this->status = $invoice_status;
    }
}