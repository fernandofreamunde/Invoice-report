<?php 

namespace App\AppPacket\Repository;

use App\Core\Query;
use App\Core\Database;
use App\AppPacket\Entity\Invoice;

/**
* 
*/
class InvoiceRepository
{
    const ITEMS_PER_PAGE = 5;
    protected $entity;
    private $db;

    public function __construct(Invoice $invoice, Database $db)
    {
        $this->entity = $invoice;
        $this->db = $db;
    }

    public function getAllPaginated(int $page = 1)
    {
        $page = $page < 1 ? 1 : $page;

        $offset = ($page -1) * self::ITEMS_PER_PAGE;

        $query = $this->getQuery();
        $query->select();
        $query->offsetAndLimit($offset, self::ITEMS_PER_PAGE);

        return $this->db->runQuery($query);
    }

    public function getAll()
    {
        $query = $this->getQuery();
        $query->select();

        return $this->db->runQuery($query);
    }

    public function getInvoiceById($id)
    {
        $query = $this->getQuery();
        $query->select();
        $query->filterBy('id', $id);

        return $this->db->runQuery($query);
    }

    private function getQuery()
    {
        return new Query($this->entity);
    }
}