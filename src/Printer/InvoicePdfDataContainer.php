<?php
namespace InvoiceBundle\Printer;

class InvoicePdfDataContainer{
    
    private $invoiceBuyer;
    private $invoiceSeller;
    private $invoiceInfo;
    private $invoiceDetails;

    public function setInvoiceBuyer(InvoiceBuyer $invoiceBuyer){
        $this->invoiceBuyer = $invoiceBuyer;
    }
    
    /**
     * 
     * @return InvoiceBuyer
     */
    public function getInvoiceBuyer(){
        return $this->invoiceBuyer;
    }
    
    public function setInvoiceSeller(InvoiceSeller $invoiceSeller){
        $this->invoiceSeller = $invoiceSeller;
    }
    
    /**
     * 
     * @return InvoiceSeller
     */
    public function getInvoiceSeller(){
        return $this->invoiceSeller;
    }
    

    /**
     * 
     * @param InvoiceDetails $invoiceDetails
     */
    public function setInvoiceDetails(InvoiceDetails $invoiceDetails){
        $this->invoiceDetails = $invoiceDetails;
    }
    
    /**
     * 
     * @return InvoiceDetails
     */
    public function getInvoiceDetails(){
        return  $this->invoiceDetails;
    }
}