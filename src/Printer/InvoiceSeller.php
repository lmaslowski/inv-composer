<?php
namespace InvoiceBundle\Printer;

class InvoiceSeller {
    
    private $name;
    private $address;
    private $postCode;
    private $city;
    private $nip;
    private $accountNumber;
    
    public function setName($name){
        $this->name = $name;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function setAddress($address){
        $this->address = $address;
    }
    
    public function getAddress(){
        return $this->address;
    }
    
    public function setPostCode($postCode){
        $this->postCode = $postCode;
    }
    
    public function getPostCode(){
        return $this->postCode;
    }
    
    public function setCity($city){
        $this->city = $city;
    }
    
    public function getCity(){
        return $this->city;
    }
    
    public function setNip($nip){
        $this->nip = $nip;
    }
    
    public function getNip(){
        return $this->nip;
    }
    
    public function setAccountNumber($accountNumber){
        $this->accountNumber = $accountNumber;
    }
    
    public function getAccountNumber(){
        return $this->accountNumber;
    }
}