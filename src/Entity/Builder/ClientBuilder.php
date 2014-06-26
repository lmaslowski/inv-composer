<?php
namespace InvoiceBundle\Entity\Builder;

use InvoiceBundle\Entity\Client;
class ClientBuilder{
    
    private $clientProperties;
    
    private function getProperty($value){
        return $this->clientProperties[$value] ;
    }
    
    public function __construct($clientProperties){
        $this->clientProperties = $clientProperties;
    }
    
    /**
     * @return \InvoiceBundle\Entity\Client
     */
    public function build(){
        $client = new Client();
        $client->setId($this->getProperty('userid'));
        $client->setFirstName($this->getProperty('firstname'));
        $client->setLastName($this->getProperty('lastname'));
        $client->setFullName($this->getProperty('fullname'));
        $client->setCompanyName($this->getProperty('companyname'));
        $client->setEmail($this->getProperty('email'));
        $client->setAddress1($this->getProperty('address1'));
        $client->setCity($this->getProperty('city'));
        $client->setState($this->getProperty('state'));
        $client->setFullState($this->getProperty('fullstate'));
        $client->setPostCode($this->getProperty('postcode'));
        $client->setPhoneNumberFull($this->getProperty('phonenumberformatted'));
        $client->setCountryName($this->getProperty('countryname'));
        $client->setStatus('status');
        $client->setPesel($this->getProperty('customfields3'));
        $client->setNip($this->getProperty('customfields4'));
        $client->setClientStatusLaw($this->getProperty('customfields5'));
        return $client;
    }
}