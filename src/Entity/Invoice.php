<?php
namespace InvoiceBundle\Entity;

class Invoice{
    
    private $invoiceId;
    private $status;
    private $invoiceNumber;
    private $userId;
    private $createDate;
    private $paymentTerm;
    private $paymentDate;
    private $netPrice;
    private $grossPrice;
    private $tax;
    private $taxRate;
    private $paymentmethod;
    private $invoiceItems;
    
    public function setUserId($userId){
        $this->userId = $userId;
    }

    public function getUserId(){
        return $this->userId;
    }
    
    public function setId($id){
        $this->invoiceId = $id;
    }
    
    public function getId(){
        return $this->invoiceId;
    }
    
    public function setStatus($status){
        $this->status = $status;
    }
    public function getStatus(){
        return  $this->status;
    }

    public function setInvoiceNumber($invoiceNumber){
        $this->invoiceNumber = $invoiceNumber;
    }
    
    public function getInvoiceNumber(){
        return $this->invoiceNumber;
    }
    
    public function setCreateDate($createDate){
        $this->createDate =  $createDate;
    }

    public function getCreateDate(){
        return $this->createDate;
    }
    
    public function setPaymentTerm($paymentTerm){
        $this->paymentTerm = $paymentTerm;
    }

    public function getPaymentTerm(){
        return $this->paymentTerm;
    }
    
    public function setPaymetDate($paymentDate){
        $this->paymentDate =  $paymentDate;
    }
    
    public function getPaymentDate(){
        return $this->paymentDate;
    }
    
    public function getPaymentDateFormat($format){
        $date = new \DateTime($this->paymentDate);
        return $date->format($format);
    }
    
    public function setNetPrice($netPrice){
        $this->netPrice =  $netPrice;
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
    
    public function setTax($tax){
        $this->tax = $tax;
    }
    
    public function getTax(){
        return $this->tax;
    }
    
    public function setTaxRate($taxRate){
        $this->taxRate = $taxRate;
    }
    
    public function getTaxRate(){
        return ceil($this->taxRate);
    }
    
    public function setPaymentMethod($paymentMethod){
        $this->paymentMethod = $paymentMethod;
    }
    
    public function getPaymentMethod(){
        return $this->paymentMethod;
    }
    
    public function setInvoiceItems(Array $invoiceItems){
        foreach($invoiceItems as $item){
            if($invoiceItems instanceof InvoiceDetail){
                $this->invoiceItems[] = $item;
            }else{
                $this->invoiceItems[] = $this->buildInvoiceFromArray($item);
            }
        }
    }
    
    public function addInvoiceItem(InvoiceDetail $invoiceItem){
        $this->invoiceItems[] = $invoiceItem;
    }
    
    public function mergeInvoiceItems(Array $invoiceItemsToMerge){
        $this->invoiceItems[] = array_merge($this->invoiceItems, $invoiceItemsToMerge);
    }
    
    public function getInvoiceItems(){
        return  $this->invoiceItems;
    }
    

    private function buildInvoiceFromArray($item){
        $invoiceDetail = new InvoiceDetail();
        return $invoiceDetail->exchangeFromArray($item);
    }
    
    
    
}