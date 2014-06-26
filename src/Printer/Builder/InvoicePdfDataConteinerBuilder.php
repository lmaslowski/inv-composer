<?php
namespace InvoiceBundle\Printer\Builder;

use InvoiceBundle\Entity\Wrapper\InvoiceWrapper;
use InvoiceBundle\Printer\InvoiceBuyer;
use InvoiceBundle\Printer\InvoiceSeller;
use InvoiceBundle\Printer\InvoicePdfDataContainer;
use InvoiceBundle\Entity\Wrapper\InvoiceWrapperImpl;
use InvoiceBundle\Printer\InvoiceDetails;

class InvoicePdfDataConteinerBuilder{

    public static function build(InvoiceWrapperImpl $invoiceWrapper, $ammountByWordHelper = null){
        $invoiceSeller = new InvoiceSeller();
        $invoiceSeller->setName('nazwa.pl S.A');
        $invoiceSeller->setAddress('ul. Cystersów 20a');
        $invoiceSeller->setPostCode('31-533');
        $invoiceSeller->setCity('Kraków');
        $invoiceSeller->setNip('675-140-29-20');
        $invoiceSeller->setAccountNumber('67 1060 0076 0000 3310 0021 1458');
        
        $invoiceBuyer = new InvoiceBuyer();
        $client = $invoiceWrapper->getClient();
        
        $invoiceBuyer->setName($client->isFirm() ? $client->getCompanyName() : $client->getFullName());
        $invoiceBuyer->setNip($client->isFirm()  ? $invoiceWrapper->getClient()->getNip() : null);
        $invoiceBuyer->setAddress($client->getAddress1(). ' ' . $client->getAddress2());
        $invoiceBuyer->setCity($client->getCity());
        $invoiceBuyer->setPostCode($client->getPostCode());
        $invoiceBuyer->setCountryName($client->getCountryName());
        
        
        $invoiceDetails = new InvoiceDetails();
        $invoiceDetails->setStatus($invoiceWrapper->getInvoice()->getStatus());
        $invoiceDetails->setInvoiceNumber($invoiceWrapper->getInvoiceNumber());
        $invoiceDetails->setCreateData($invoiceWrapper->getInvoice()->getCreateDate());
        $invoiceDetails->setPaymentTerm($invoiceWrapper->getInvoice()->getPaymentTerm());
        $invoiceDetails->setPaymentDate($invoiceWrapper->getInvoice()->getPaymentDate());
        $invoiceDetails->setInvoiceItems($invoiceWrapper->getInvoiceItems());
        $invoiceDetails->setNetPrice($invoiceWrapper->getNetPrice());
        $invoiceDetails->setTaxPrice($invoiceWrapper->getTaxPrice());
        $invoiceDetails->setGrossPrice($invoiceWrapper->getGrossPrice());
        $invoiceDetails->setPaymentMethod($invoiceWrapper->getPaymentMethod());
        $invoiceDetails->setInvoiceWrapper($invoiceWrapper);
		
		if($ammountByWordHelper !== null){
			$invoiceDetails->setGrossPriceByWord($ammountByWordHelper->slownie($invoiceWrapper->getRawGrossPrice()));
        }
		
        $invoicePdfDataContainer = new InvoicePdfDataContainer();
        $invoicePdfDataContainer->setInvoiceBuyer($invoiceBuyer);
        $invoicePdfDataContainer->setInvoiceSeller($invoiceSeller);
        $invoicePdfDataContainer->setInvoiceDetails($invoiceDetails);
        
        return $invoicePdfDataContainer;
    }
    
    
}