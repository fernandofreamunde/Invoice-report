<?php 

namespace App\AppPacket\Controller;

use App\AppPacket\Service\InvoiceService;
use App\AppPacket\Service\InvoiceItemService;
use App\Core\Response;
use App\Core\View;

/**
* 
*/
class InvoiceController
{
    private $invoiceService;

    public function __construct(InvoiceService $invoiceService, InvoiceItemService $invoiceItemService)
    {
        $this->invoiceService     = $invoiceService;
        $this->invoiceItemService = $invoiceItemService;
    }
    
    public function indexAction()
    {
        $page = (isset($_GET['page']) && $_GET['page'] > 1) ? $_GET['page'] : 1;

        $maxPage = $this->invoiceService->getInvoicePageCount();

        $page = $page > $maxPage ? $maxPage : $page;

        $data = [
            'invoices'   => $this->invoiceService->getInvoicesPaginated($page),
            // would not use Camel case if I had some Twig or Blade at disposal
            'totalPages' => $maxPage,
        ];

        return new View('invoice/index', $data);
    }
    
    public function detailAction(int $id)
    {
        $data = [
            'items'   => $this->invoiceItemService->getInvoiceItemsByInvoiceId($id),
            'invoice' => $this->invoiceService->getOneById($id)[0]
        ];

        return new View('invoice/details', $data);
    }

    public function statusAction($id)
    {
        # set invoice as paid
        $content = file_get_contents("php://input");
        $content = json_decode($content);

        $this->invoiceService->setInvoiceStatusById($id, $content->value);
        
        return new Response(['value' => 'true'], Response::TYPE_JSON);
    }

    public function reportAction()
    {
        # Export the transactions as a CSV file. The export should be in the following format:
        # Invoice ID | Company Name | Invoice Amount

        $content = $this->invoiceService->transactionsReport();

        return new Response($content, Response::TYPE_CSV);
    }
}