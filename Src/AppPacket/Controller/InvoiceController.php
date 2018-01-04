<?php 

namespace App\AppPacket\Controller;

use App\AppPacket\Service\InvoiceService;
use App\Core\Response;
use App\Core\View;

/**
* 
*/
class InvoiceController
{
    private $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }
    
    public function indexAction()
    {
        return new View;
        # paginated resource max 5 per page
    }

    public function payAction()
    {
        # set invoice as paid
    }

    public function unpayAction()
    {
        # set invoice as unpaid
    }

    public function reportAction()
    {
        # Export the transactions as a CSV file. The export should be in the following format:
        # Invoice ID | Company Name | Invoice Amount

        $content = $this->invoiceService->transactionsReport();

        return new Response($content, Response::TYPE_CSV);
    }
}