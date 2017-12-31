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

        ///// this logic needs to be moved to a view class of some sorts
        $text = "Invoice ID,Company Name,Invoice Amount\n";

        foreach ($invoices as $invoice) {
            $text .= $invoice->getId().','.$invoice->getClient().','.$invoice->getAmountWithoutTax()."\n";
        }

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="transactions_report.csv"');
        $handle = fopen('php://output', 'w');
        fwrite($handle, $text);
        // all needed here is to return the data as array. look at fputcsv for reference
        #echo '<pre>',print_r($text),'</pre>';
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

        ///// this logic needs to be moved to a view class of some sorts
        //Company Name | Total Invoiced Amount | Total Amount Paid | Total Amount Outstanding
        $text = "Company Name,Total Invoiced Amount,Total Amount Paid,Total Amount Outstanding\n";

        foreach ($data as $customer => $reportData) {

            /////////////////////////////////////////////////////////////////// FORMAT VALUES TO MONEY
            $text .= $customer.','.$reportData['total'].','.$reportData['paid'].','.$reportData['unpaid']."\n";
        }

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="customer_report.csv"');
        $handle = fopen('php://output', 'w');
        fwrite($handle, $text);
        // all needed here is to return the data as array. look at fputcsv for reference
    }
}