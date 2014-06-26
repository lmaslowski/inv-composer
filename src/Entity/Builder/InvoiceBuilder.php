<?php
namespace InvoiceBundle\Entity\Builder;

use InvoiceBundle\Entity\Invoice;
class InvoiceBuilder{
    
    private $invoiceProperties;

    private function getProperty($value){
        return $this->invoiceProperties[$value] ; 
    }
    
    public function __construct($invoiceProperties){
        $this->invoiceProperties = $invoiceProperties;
    }
    
    /**
     * 
     * @return \InvoiceBundle\Entity\Invoice
     */
    public function build(){
        $invoice = new Invoice();
        
        $invoice->setId($this->getProperty('invoiceid'));
        $invoice->setInvoiceNumber($this->getProperty('invoicenum'));
        $invoice->setUserId($this->getProperty('userid'));
        $invoice->setCreateDate($this->getProperty('date'));
        $invoice->setPaymentTerm($this->getProperty('duedate'));
        $invoice->setPaymetDate($this->getProperty('datepaid'));
        
        $invoice->setNetPrice($this->getProperty('subtotal'));
        $invoice->setGrossPrice($this->getProperty('subtotal'));
        $invoice->setGrossPrice($this->getProperty('total'));
        $invoice->setTaxRate($this->getProperty('taxrate'));
        $invoice->setTax($this->getProperty('tax'));
        $invoice->setStatus($this->getProperty('status'));
        $invoice->setPaymentMethod($this->getProperty('paymentmethod'));
        
        $items = $this->getProperty('items');
        $item = isset($items['item']) ? $items['item'] : array() ;
        $invoice->setInvoiceItems($item);
        
        return $invoice;
    }
}