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
        return $id;
    }

    public function getInvoiceId()
    {
        return $invoice_id;
    }

    public function getName()
    {
        return $name;
    }

    public function getAmount()
    {
        return $amount;
    }

    public function getCreatedAt()
    {
        return $created_at;
    }
}