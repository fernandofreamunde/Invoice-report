<?php 

namespace App\AppPacket\Repository;

use App\Core\Repository;
use App\Core\Database;
use App\AppPacket\Entity\InvoiceItem;
use App\AppPacket\Entity\Invoice;
/**
* 
*/
class PathRepository extends Repository
{
    protected $entity;

    public function __construct(Invoice $invoice, Database $db)
    {
        $this->entity = $invoice;
        parent::__construct($db);
        # code...
    }
        
}