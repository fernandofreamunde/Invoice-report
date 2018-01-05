### Invoice Report System

This is a work done on an assessment, here are the rules:

Without using a PHP framework or third party packages of any sort, build a PHP application that connects to the provided database and allows it's users to perform the following tasks:
- [ ] List the invoices from the database table into an HTML paginated table, having 5 records per page.
- [ ] Export the transactions as a CSV file. The export should be in the following format:
Invoice ID | Company Name | Invoice Amount

- [ ] Export a CSV customer report. The export should be in the following format:
Company Name | Total Invoiced | Total Amount Paid | Total Amount | Amount Outstanding

- [ ] Set the payment status of each invoice via the interface to paid / unpaid

This code depends on a Vagrant box that resides in another repo. and should take care of all the dependencies of the Project.


