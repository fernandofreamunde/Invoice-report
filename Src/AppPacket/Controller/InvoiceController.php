<?php 

namespace App\AppPacket\Controller;

/**
* 
*/
class InvoiceController
{
    public function indexAction()
    {
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
    }
}