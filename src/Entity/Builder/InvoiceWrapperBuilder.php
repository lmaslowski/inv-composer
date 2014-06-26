<?php
namespace InvoiceBundle\Entity\Builder;

use InvoiceBundle\Entity\Wrapper\InvoiceWrapperImpl;
class InvoiceWrapperBuilder{

    /**
     * 
     * @param unknown $invoiceProperties
     * @return \InvoiceBundle\Entity\Wrapper\InvoiceWrapperImpl
     */
    public static /*InvoiceWrapper*/ function build($invoiceProperties){
        $invoiceBuilder = new InvoiceBuilder($invoiceProperties);
        return new InvoiceWrapperImpl($invoiceBuilder->build());
    }
    
    /**
     * 
     * @param unknown $invoiceProperties
     * @param unknown $clientProperties
     * @return \InvoiceBundle\Entity\Wrapper\InvoiceWrapperImpl
     */
    public static /*InvoiceWrapper*/ function buildWithClient($invoiceProperties, $clientProperties){
        $invoiceBuilder = new InvoiceBuilder($invoiceProperties);
        $clientBuilder = new ClientBuilder($clientProperties);
        $invoiceWrapperImpl =  new InvoiceWrapperImpl($invoiceBuilder->build(), $clientBuilder->build());
        return $invoiceWrapperImpl;
    }
}