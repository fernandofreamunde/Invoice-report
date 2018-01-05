<?php 

namespace App\AppPacket\Service;

use App\AppPacket\Repository\InvoiceItemRepository;

/**
* 
*/
class InvoiceItemService
{
    private $invoiceItemRepository;

    function __construct(InvoiceItemRepository $invoiceItemRepository)
    {
        $this->invoiceItemRepository = $invoiceItemRepository;
    }

    public function getInvoiceItemsByInvoiceId($id)
    {
        return $this->invoiceItemRepository->getAllByInvoiceId($id);
    }

}