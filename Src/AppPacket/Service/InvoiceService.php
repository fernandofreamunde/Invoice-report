<?php 

namespace App\AppPacket\Service;

use App\Core\Query;
use App\Core\Database;
use App\AppPacket\Entity\Invoice;
use App\AppPacket\Repository\InvoiceRepository;

/**
* 
*/
class InvoiceService
{
    private $invoiceRepository;
    private $db;
    
    function __construct(InvoiceRepository $invoiceRepository, Database $db)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->db = $db;
    }

    public function getOneById($id)
    {
        return $this->invoiceRepository->getInvoiceById($id);
    }

    public function setInvoiceStatusById($id, $status)
    {
        $invoice = $this->invoiceRepository->getInvoiceById($id);
        $invoice[0]->setStatus($status);

        $updateQuery = 'UPDATE invoices SET 
        invoice_status = ?
        WHERE id = ?';

        $params = [
        $invoice[0]->getStatus(),
        $invoice[0]->getId(),
        ];

        $query = new Query($invoice[0]);
        $query->customWrightAction($updateQuery, $params);

        $this->db->runWrightQuery($query);

        return $invoice[0];
    }

    public function getInvoicesPaginated($page = 1)
    {
        return $this->invoiceRepository->getAllPaginated($page);
    }

    public function getInvoicePageCount()
    {
        // this could be a query with a count but no time...
        return ceil(count($this->invoiceRepository->getAll())/InvoiceRepository::ITEMS_PER_PAGE);
    }

    public function transactionsReport()
    {
        $invoices = $this->invoiceRepository->getAll();

        $content[] = [
            'Invoice ID', 
            'Company Name', 
            'Invoice Amount',
        ];

        foreach ($invoices as $invoice) {
            $content[] = [
                $invoice->getId(),
                $invoice->getClient(),
                $invoice->getAmountWithoutTax(),
            ];
        }

        return $content;
    }

    public function customerReport()
    {
        $invoices = $this->invoiceRepository->getAll();

        $data = [];
        foreach ($invoices as $invoice) {

            if (isset($data[$invoice->getClient()])) {
                $data[$invoice->getClient()] = [
                    'total'  => $data[$invoice->getClient()]['total'] + $invoice->getAmountWithoutTax(),
                    'unpaid' => $invoice->getStatus() == 'unpaid' ? $data[$invoice->getClient()]['unpaid'] + $invoice->getAmountWithoutTax() : $data[$invoice->getClient()]['unpaid'],
                    'paid'   => $invoice->getStatus() == 'paid' ? $data[$invoice->getClient()]['paid'] + $invoice->getAmountWithoutTax() : $data[$invoice->getClient()]['paid'],
                ];
                continue;
            }

            $data[$invoice->getClient()] = [
                    "total"  => $invoice->getAmountWithoutTax(),
                    "unpaid" => $invoice->getStatus() == 'unpaid' ? $invoice->getAmountWithoutTax() : 0,
                    "paid"   => $invoice->getStatus() == 'paid' ? $invoice->getAmountWithoutTax() : 0,
            ];
        }

        $content[] = [
            'Company Name',
            'Total Invoiced Amount',
            'Total Amount Paid',
            'Total Amount Outstanding',
            ];

        foreach ($data as $customer => $reportData) {

            $content[] = [
                $customer,
                $reportData['total'],
                $reportData['paid'],
                $reportData['unpaid'],
                ];
        }

        return $content;
    }
}