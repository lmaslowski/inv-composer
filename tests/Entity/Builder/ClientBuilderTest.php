<?php
use InvoiceBundle\Entity\Builder\ClientBuilder;
class ClientBuilderTest extends PHPUnit_Framework_TestCase{
    private $clientBuilder;
    
    public function setUp(){
        parent::setUp();
    }
    
    private function getClientBuilder(){
        return $this->clientBuilder;
    }

    public function testClientBuilder(){
        //given
        $clientPropeties = $this->getClientProperties();
        $this->clientBuilder = new ClientBuilder($clientPropeties);
        
        //when
        $clientExpected = $this->getClientBuilder()->build();
        
        //then
        $this->assertEquals($clientExpected->getCity(), $clientPropeties['city']);
        $this->assertEquals($clientExpected->getId(), $clientPropeties['id']);
        $this->assertEquals($clientExpected->getFirstName(), $clientPropeties['firstname']);
        $this->assertEquals($clientExpected->getLastName(), $clientPropeties['lastname']);
        $this->assertEquals($clientExpected->getFullName(), $clientPropeties['firstname'] . ' ' .$clientPropeties['lastname']);
        $this->assertEquals($clientExpected->getEmail(), $clientPropeties['email']);
        $this->assertEquals($clientExpected->isFirm(), false);
        $this->assertEquals($clientExpected->getNip(), null);
        $this->assertEquals($clientExpected->getPesel(), $clientPropeties['customfields3']);
    }
    
    
    private function getClientProperties(){
        return $clientProperties = array (
          'result' => 'success',
          'userid' => '5',
          'id' => '5',
          'firstname' => 'Malwina',
          'lastname' => 'Szopa',
          'fullname' => 'Malwina Szopa',
          'companyname' => '',
          'email' => 'malwina.szopa@netart.pl',
          'address1' => 'cystersów 50',
          'address2' => '',
          'city' => 'kraków',
          'fullstate' => '',
          'state' => '',
          'postcode' => '31-536',
          'countrycode' => 'PL',
          'country' => 'PL',
          'statecode' => '',
          'countryname' => 'Poland',
          'phonecc' => 48,
          'phonenumber' => '506022436',
          'phonenumberformatted' => '+48.506022436',
          'billingcid' => '0',
          'notes' => '',
          'password' => '52adf548a75d155bb52f84980a9cd547:)YR)d',
          'twofaenabled' => false,
          'currency' => '1',
          'defaultgateway' => '',
          'cctype' => '',
          'cclastfour' => '',
          'securityqid' => '0',
          'securityqans' => '',
          'groupid' => '0',
          'status' => 'Active',
          'credit' => '0.00',
          'taxexempt' => '',
          'latefeeoveride' => '',
          'overideduenotices' => '',
          'separateinvoices' => '',
          'disableautocc' => '',
          'emailoptout' => '0',
          'overrideautoclose' => '0',
          'language' => 'polski',
          'lastlogin' => 'Date: 18/06/2014 09:41
        IP Address: 85.128.131.1
        Host: aka1.rev.netart.pl',
          'customfields1' => 'on',
          'customfields' => 
          array (
            0 => 
            array (
              'id' => '1',
              'value' => 'on',
            ),
            1 => 
            array (
              'id' => '3',
              'value' => '',
            ),
            2 => 
            array (
              'id' => '5',
              'value' => '85071613827',
            ),
            3 => 
            array (
              'id' => '7',
              'value' => '',
            ),
            4 => 
            array (
              'id' => '9',
              'value' => 'Osoba fizyczna',
            ),
          ),
          'customfields2' => '',
          'customfields3' => '85071613827',
          'customfields4' => '',
          'customfields5' => 'Osoba fizyczna',
          'currency_code' => 'PLN',
        );
    }
}