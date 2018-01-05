<?php

namespace App\AppPacket\Entity;

/**
* 
*/
class InvoiceItem
{
    const TABLE = 'invoice_items';
    public function __construct()
    {}

    private $id;
    private $invoice_id = 'App\\AppPacket\\Entity\\Invoice';
    private $name;
    private $amount; 
    private $created_at;

    public function getId()
    {
        return $this->id;
    }

    public function getInvoiceId()
    {
        return $this->invoice_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }
}