<?php 

namespace App\AppPacket\Service;

use App\AppPacket\Repository\InvoiceRepository;
use App\AppPacket\Entity\Invoice;

/**
* 
*/
class InvoiceService
{
    private $invoiceRepository;
    
    function __construct(InvoiceRepository $invoiceRepo)
    {
        $this->invoiceRepository = $invoiceRepo;
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

            /////////////////////////////////////////////////////////////////// FORMAT VALUES TO MONEY
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