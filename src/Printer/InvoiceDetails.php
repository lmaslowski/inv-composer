<?php
namespace InvoiceBundle\Printer;

use Dao\InvoiceWrapperImpl;
class InvoiceDetails {
    private $status;
    private $createData;
    private $paymentTerm;
    private $paymentMethod;
    private $paymentDate;
    private $grossPrice;
    private $grossPriceByWord;
    private $invoiceNumber;
    private $invoiceItems;
    private $netPrice;
    private $taxPrice;
    private $invoiceWrapper;
    
    private $statusMap = array(
            'Paid' => 'ZAPŁACONA',
            'Unpaid' => 'NIEOPŁACONA',
            'Cancelled' => 'ANULOWANA',
            'Refunded'  => 'ZWRÓCONA'
    );
    
    private $paymentMethodMap = array(
            'banktransfer' => 'Przelew bankowy',
            'mg_przelewy24' => 'Przelewy24.pl'
    );
    
    public function setInvoiceWrapper(\InvoiceBundle\Entity\Wrapper\InvoiceWrapperImpl $invoiceWrapper){
        $this->invoiceWrapper = $invoiceWrapper;
    }
    /**
     * 
     * @return InvoiceWrapperImpl
     */
    public function getInvoiceWrapper(){
        return $this->invoiceWrapper;
    }
    
    public function setInvoiceItems($invoiceItems){
        $this->invoiceItems = $invoiceItems;
    }
    
    public function getInvoiceItems(){
        return $this->invoiceItems;
    }
    
    public function setPaymentDate($paymentDate){
        $this->paymentDate = $paymentDate;
    }
    
    public function getPaymentDate(){
        return $this->paymentDate;
    }
    
    
    public function setInvoiceNumber($invoiceNumber){
        $this->invoiceNumber = $invoiceNumber;
    }
    
    public function getInvoiceNumber(){
        return $this->invoiceNumber;
    }
    
    public function setCreateData($createData){
        $this->createData = $createData;
    }
    
    public function getCreateData(){
        return $this->createData;
    }
    
    public function setPaymentTerm($paymentTerm){
        $this->paymentTerm = $paymentTerm;
    }
    
    public function getPaymentTerm(){
        return $this->paymentTerm;
    }
    
    public function setStatus($status){
        $this->status = $status;
    }
    
    public function getStatus(){
        return $this->status;
    }
    
    public function getStatusName(){
        if(!isset($this->statusMap[$this->getStatus()])){
            return null;
        }
        return $this->statusMap[$this->getStatus()];
    }
    
    public function setPaymentMethod($paymentMethod){
        $this->paymentMethod = $paymentMethod;
    }
    
    public function getPaymentMethod(){
        return $this->paymentMethod;
    }
    
    public function getPaymentMethodName(){
        return $this->paymentMethodMap[$this->getPaymentMethod()];
    }
    
    public function setInvoicePaymentStatus($invoicePaymentStatus){
        $this->invoicePaymentStatus = $invoicePaymentStatus;
    }
    
    public function getInvoicePaymentStatus(){
        return $this->invoicePaymentStatus;
    }
    
    public function setGrossPriceByWord($grossPrice){
        $this->grossPriceByWord = $grossPrice;
    }
    
    public function getGrossPriceByWord(){
        return $this->grossPriceByWord;
    }
    
    public function setNetPrice($netPrice){
        $this->netPrice = $netPrice;
    }
    
    public function getNetPrice(){
        return $this->netPrice;
    }
    
    public function setGrossPrice($grossPrice){
        $this->grossPrice = $grossPrice; 
    }

    public function getGrossPrice(){
        return $this->grossPrice;
    }

    public function setTaxPrice($taxPrice){
        return $this->taxPrice = $taxPrice;
    }
    
    
    public function getTaxPrice(){
        return $this->taxPrice;
    }

}