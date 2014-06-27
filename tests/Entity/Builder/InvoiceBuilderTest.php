<?php
namespace InvoiceBundle\Tests\Entity\Builder;

use InvoiceBundle\Entity\Builder\InvoiceBuilder;
class InvoiceBuilderTest extends \PHPUnit_Framework_TestCase{
    private $invoiceBuilder;
    
    public function setUp(){
        parent::setUp();
    }
    
    private function getInvoiceBuilder(){
        return $this->invoiceBuilder;
    }

    public function testInvoiceBuilder(){
        //given
        $invoiceProperties = $this->getInvoiceProperties();
        $this->invoiceBuilder = new InvoiceBuilder($invoiceProperties);
        
        //when
        $invoiceExpected = $this->getInvoiceBuilder()->build();
        
        //then
        $this->assertEquals($invoiceExpected->getInvoiceNumber(), $invoiceProperties['invoicenum']);
        $this->assertEquals($invoiceExpected->getStatus(), $invoiceProperties['status']);
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