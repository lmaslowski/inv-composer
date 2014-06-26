<?php
namespace InvoiceBundle\Entity;

class Client{

    private $id;

    private $status;
    
    private $firstname;
    private $lastname;
    private $fullname;
    private $companyName;
    private $address1;
    private $address2;
    private $city;
    private $state;
    private $fullstate;
    private $postcode;
    
    private $country;
    private $countrycode;
    private $countryname;
    
    private $phonecc;
    private $phonenumber;
    private $phonenumberfull;
    
    private $email;
    
    private $lastlogin;
    
    private $currency_code;
    
    private $clientFirm;
    private $clientStatusLaw;
    
    
    private $pesel;
    private $nip;
    
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function setStatus($status){
        $this->status = $status;
    }
    
    public function getStatus(){
        return $this->status;
    }
    
    public function setFirstName($firstname){
        $this->firstname  = $firstname;
    }
    
    public function getFirstName(){
       return $this->firstname;
    }
    
    public function setLastName($lastname){
        $this->lastname = $lastname;
    }
    
    public function getLastName(){
        return $this->lastname;
    }
    
    public function setFullName($fullname){
        $this->fullname  = $fullname;
    }
    
    public function getFullName(){
        return $this->fullname;
    }
    
    public function setAddress1($address1){
        $this->address1 = $address1;
    }
    
    public function getAddress1(){
        return $this->address1;
    }
    
    public function setAddress2($address2){
        $this->address2 = $address2;
    }
    
    public function getAddress2(){
        return $this->address2;
    }
    
    public function setCity($city){
        $this->city = $city;
    }
    
    public function getCity(){
        return $this->city;
    }
    
    public function setState($state){
        $this->state =  $state;
    }
    
    public function getState(){
        return $this->state;
    }
    
    public function setFullState($fullstate){
        $this->fullstate = $fullstate;
    }
    
    public function getFullState(){
        return $this->fullstate;
    }
    
    public function setPostCode($postCode){
        $this->postcode = $postCode;
    }
    
    public function getPostCode(){
        return $this->postcode;
    }
    
    /**
     * 'country' => 'PL',
     */
    public function setCountry($country){
        $this->country = $country;
    }
    
    public function getCountry(){
        return $this->country;
    }
    
    /**
     * 'countrycode' => 'PL',
     */
    public function setCountryCode($countryCode){
        $this->countrycode  = $countryCode;
    }
    
    public function getCountryCode(){
        return $this->countrycode;
    }
    
    /**
     *  'countryname' => 'Poland',
     */
    public function setCountryName($countryname){
        $this->countryname = $countryname;
    }
    
    public function getCountryName(){
        return $this->countryname;
    }
    
    /**
     * 'phonenumberformatted' => '+48.513427373', 
     */
    public function setPhoneNumberFull($phonenumberfull){
        $this->phonenumberfull = $phonenumberfull;
    }
    
    public function getPhoneNumberFull(){
        return $this->phonenumberfull;
    }
    
    public function setEmail($email){
        $this->email = $email;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function setLastlogin($lastLogin){
        $this->lastlogin = $lastlogin;
    }
    
    public function getLastLogin(){
        return $this->lastlogin;
    }
    
    /**
     *  companyname' => '',,
     */
    public function setCompanyName($companyName){
        $this->companyName = $companyName;
    }
    
    public function getCompanyName(){
        return $this->companyName;
    }
    
    
    public function setPesel($pesel){
        $this->pesel = $pesel;
    }
    
    public function getPesel(){
        return $this->pesel;
    }

    public function setNip($nip){
        $this->nip = $nip;
    }
    
    public function getNip(){
        return $this->nip;
    }
    
    public function isFirm(){
        if(($this->getCompanyName() == null || $this->getCompanyName() == '') && ($this->getNip() == null || $this->getNip() == '')){
            return false;
        }
        return true;
    }
    
    public function setClientStatusLaw($clientStatusLaw){
        $this->clientStatusLaw = $clientStatusLaw;
    }
    
    public function getClientStatusLaw(){
        return $this->clientStatusLaw;
    }
}