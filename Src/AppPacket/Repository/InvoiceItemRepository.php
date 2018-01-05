<?php 

namespace App\AppPacket\Repository;

use App\Core\Query;
use App\Core\Database;
use App\AppPacket\Entity\InvoiceItem;

/**
* 
*/
class InvoiceItemRepository
{
    protected $entity;
    private $db;

    public function __construct(InvoiceItem $invoice, Database $db)
    {
        $this->entity = $invoice;
        $this->db = $db;
    }

    public function getAllByInvoiceId($id)
    {
        $query = $this->getQuery();
        $query->select();
        $query->filterBy('invoice_id', $id);

        return $this->db->runQuery($query);
    }

    private function getQuery()
    {
        return new Query($this->entity);
    }
}