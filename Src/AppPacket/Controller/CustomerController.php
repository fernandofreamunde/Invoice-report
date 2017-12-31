<?php

namespace App\AppPacket\Controller;

use App\AppPacket\Service\InvoiceService;

/**
* 
*/
class CustomerController
{
    private $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function reportAction()
    {
        # Export a CSV customer report. The export should be in the following format:
        # Company Name | Total Invoiced Amount | Total Amount Paid | Total Amount Outstanding

        $this->invoiceService->customerReport();
    }
}