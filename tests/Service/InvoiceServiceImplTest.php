<?php
namespace InvoiceBundle\Tests\Service;

class InvoiceServiceImplTest extends \PHPUnit_Framework_TestCase{
    private $invoiceServiceImpl;
    
    public function setUp(){
        parent::setUp();
    }
    
    
    private function getInvoiceServiceImpl(){
        return $this->invoiceServiceImpl;
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
    
    private function getInvoiceProperties(){
        return $invoiceProperties = array (
                'result' => 'success',
                'invoiceid' => '741',
                'invoicenum' => 'SRV-2014-06-244',
                'userid' => '5',
                'date' => '2014-06-18',
                'duedate' => '2014-07-02',
                'datepaid' => '2014-06-18 13:36:22',
                'subtotal' => '354.00',
                'credit' => '0.00',
                'tax' => '81.42',
                'tax2' => '0.00',
                'total' => '435.42',
                'balance' => '0.00',
                'taxrate' => '23.00',
                'taxrate2' => '0.00',
                'status' => 'Paid',
                'paymentmethod' => 'mg_przelewy24',
                'notes' => '',
                'ccgateway' => false,
                'items' =>
                array (
                        'item' =>
                        array (
                                0 =>
                                array (
                                        'id' => '1189',
                                        'type' => 'Hosting',
                                        'relid' => '487',
                                        'description' => 'Punkty rozliczeniowe
Punkty: 50 x punkty rozliczeniowe 1.00zł',
                                        'amount' => '50.00',
                                        'taxed' => '1',
                                ),
                                1 =>
                                array (
                                        'id' => '1191',
                                        'type' => 'Hosting',
                                        'relid' => '489',
                                        'description' => 'Certyfikat RapidSSL (18/06/2014 - 17/06/2015)',
                                        'amount' => '99.00',
                                        'taxed' => '1',
                                ),
                                2 =>
                                array (
                                        'id' => '1193',
                                        'type' => 'DomainRegister',
                                        'relid' => '551',
                                        'description' => 'Rejestracja domeny - jakistest.com - 1 rok (18/06/2014 - 17/06/2015)',
                                        'amount' => '29.00',
                                        'taxed' => '1',
                                ),
                                3 =>
                                array (
                                        'id' => '1195',
                                        'type' => 'DomainRegister',
                                        'relid' => '549',
                                        'description' => 'Rejestracja domeny - jakistest.org - 3 rok (18/06/2014 - 17/06/2017)',
                                        'amount' => '176.00',
                                        'taxed' => '1',
                                ),
                        ),
                ),
                'transactions' =>
                array (
                        'transaction' =>
                        array (
                                0 =>
                                array (
                                        'id' => '505',
                                        'userid' => '5',
                                        'currency' => '0',
                                        'gateway' => 'mg_przelewy24',
                                        'date' => '2014-06-18 13:36:22',
                                        'description' => 'Invoice Payment',
                                        'amountin' => '435.42',
                                        'fees' => '0.00',
                                        'amountout' => '0.00',
                                        'rate' => '1.00000',
                                        'transid' => '18336333',
                                        'invoiceid' => '741',
                                        'refundid' => '0',
                                ),
                        ),
                ),
        );
    }
}