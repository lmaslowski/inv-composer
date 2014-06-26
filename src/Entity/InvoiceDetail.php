<?php
namespace InvoiceBundle\Entity;

class InvoiceDetail{
    private $id;
    private $type;
    private $relid;
    private $description;
    private $rawamount;
    private $amount;
    private $taxed;
    
   public function setId($id){
       $this->id = $id;
   }
   
   public function getId(){
       return $this->id;
   }

   public function setType($type){
       $this->type = $type;
   }
   
   public function getType(){
       return $this->type;
   }
   
   public function setRelId($relid){
       return $this->relid = $relid;
   }
   
   public function getRelId(){
       return $this->relid;
   }
   
   public function setDescription($description){
       $this->description = $description;
   } 
   
   public function getDescription(){
       return $this->description;
   }
   
   public function setRawamount($rawamount){
       $this->rawamount = $rawamount;
   }
   
   public function getRawamount(){
       return $this->rawamount;
   }
   
   public function setAmount($amount){
       $this->amount = $amount;
   }
   
    public function getAmount(){
        return $this->amount;
    }
    
    public function setTaxed($taxed){
        $this->taxed = $taxed;
    }
   
    public function getTaxted(){
        return $this->taxed;
    }
    
    public function exchangeFromArray(Array $item){
        isset($item['id']) && $this->setId($item['id']);
        isset($item['type']) &&  $this->setType($item['type']);
        isset($item['relid']) && $this->setRelid($item['relid']);
        isset($item['description']) && $this->setDescription($item['description']);
        isset($item['rawamount']) && $this->setRawAmount($item['rawamount']);
        isset($item['amount']) && $this->setAmount($item['amount']);
        isset($item['taxed']) && $this->setTaxed($item['taxed']);
        return $this;
    }
}