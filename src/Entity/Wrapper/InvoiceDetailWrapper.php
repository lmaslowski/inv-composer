<?php
namespace InvoiceBundle\Entity\Wrapper;

use InvoiceBundle\Entity\InvoiceDetail;
class InvoiceDetailWrapper{
    private $invoiceDetail;

    private $count = 1;
    private $netPrice;
    private $taxPrice;
    private $taxRate;
    private $grossPrice;
    private $description;
    private $unitNettoPrice;
    
    public function __construct(InvoiceDetail $invoiceDetail){
        $this->invoiceDetail = $invoiceDetail;
    }
    
    private function getInvoiceDetail(){
        return $this->invoiceDetail;
    }
    
    public function setCount($count){
        $this->count = $count;
    }
    
    public function getCount(){
        return $this->count;
    }
    
    public function setGrossPrice($grossPrice){
        $this->grossPrice = $grossPrice;
    }
    
    public function getGrossPrice(){
        return $this->grossPrice;
    }
    
    public function setNetPrice($netPrice){
        $this->netPrice = $netPrice;
    }
    
    public function getNetPrice(){
        return $this->netPrice;
    }
    
    public function setTaxPrice($taxPrice){
        $this->taxPrice = $taxPrice;
    }
    
    public function getTaxPrice(){
        return $this->taxPrice;
    }
    
    public function setTaxRate($taxRate){
        $this->taxRate = $taxRate;
    }
    
    public function getTaxRate(){
        return $this->taxRate;
    }
    
    public function setDescription($description){
        $this->description = $description;
    }

    public function getDescription(){
        return $this->description;
    }
    
     
    public function setRawamount($rawamount){
        $this->getInvoiceDetail()->setRawamount($rawamount);
    }
     
     
    public function setAmount($amount){
        $this->getInvoiceDetail()->setAmount($amount);
    }
    
    public function setTaxed($taxed){
        $this->getInvoiceDetail()->setTaxed($taxed);
    }
    
    public function getId(){
        return $this->getInvoiceDetail()->getId();
    }
   
   public function getType(){
       return $this->getInvoiceDetail()->getType();
   }
   
   public function getRelId(){
       return $this->getInvoiceDetail()->getRelId();
   }
   
   public function getRawamount(){
       return $this->getInvoiceDetail()->getRawamount();
   }
   
    public function getAmount(){
        return $this->getInvoiceDetail()->getAmount();
    }

    public function getTaxted(){
        return $this->getInvoiceDetail()->getTaxted();
    }

    public function setUnitNettoPrice($unitNettoPrice){
        $this->unitNettoPrice = $unitNettoPrice;
    }
     
    public function getUnitNettoPrice(){
        return $this->unitNettoPrice;
    }
}