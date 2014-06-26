<?php
namespace InvoiceBundle\Entity\Wrapper;

use InvoiceBundle\Entity\Invoice;
use InvoiceBundle\Entity\Client;
use InvoiceBundle\Entity\InvoiceDetail;
interface InvoiceWrapper{
}

class InvoiceWrapperImpl implements InvoiceWrapper
{
    private $invoice;
    private $invoiceItems;
    private $client;
    
    private $invoiceItemdDesciptionExplodeRegex = '/^(\d+)\s+x\s+(.*)/';
    
    private $prepaidOrderRegex = '/Punkty rozliczeniowe\nPunkty:\s+(\d+)\s+x\s+(.+)/'; 
    private $prepaidLoadRegex = '/(\d+)\s+Points\s+-\s+Punkty rozliczeniowe/';
    
    public function __construct(Invoice $invoice, Client $client = null){
        $this->invoice = $invoice;
        $this->client = $client;
    }
    
    public function setClient(Client $client){
        $this->client = $client;
    }
    
    /**
     * @return Invoice
     */
    public function getInvoice(){
        return $this->invoice;
    }
    
    /**
     * @return Client
     */
    public function getClient(){
        return $this->client;
    }
    
    public function /*void*/ addInvoiceItem(InvoiceDetailWrapper $invoiceDatail){
        $this->invoiceItems[] = $invoiceDatail;
    }

    public function /*List<InvoiceDetailWrapper>*/ getInvoiceItems(){
        foreach($this->invoice->getInvoiceItems() as /*InvoiceDetail*/ $invoiceDetail){
            if($this->shouldExplodeItem($invoiceDetail->getDescription())){
                $explodePartNumber = $this->getItemCount($invoiceDetail->getDescription());
                for($i=0;$i<$explodePartNumber;$i++){
                      $this->addInvoiceItem($this->adaptInvoiceExplodedDetail($invoiceDetail, $explodePartNumber));
                } 
            }elseif($this->isOrderPrepaid($invoiceDetail->getDescription())){
                $count = $this->getCountOrderPoint($invoiceDetail->getDescription());
                $description = $this->getCountOrderPointDecrtiption($invoiceDetail->getDescription());
                $this->addInvoiceItem($this->adaptPrepaidInvoiceDetail($invoiceDetail, $count, $description));
            }elseif($this->isLoadPrepaid($invoiceDetail->getDescription())){
                $count = $this->getCountLoadPoint($invoiceDetail->getDescription());
                $this->addInvoiceItem($this->adaptPrepaidInvoiceDetail($invoiceDetail, $count, $invoiceDetail->getDescription()));
            }else{
                 $this->addInvoiceItem($this->adaptInvoiceDetail($invoiceDetail));
            }
        }
        return $this->invoiceItems;
    }

    /**
     * 
     * @param InvoiceDetail $invoiceDetail
     * @return \InvoiceBundle\Entity\Wrapper\InvoiceDetailWrapper
     */
    private function /*InvoiceDetailWrapper*/ adaptInvoiceDetail(InvoiceDetail $invoiceDetail){
        
        $invoiceDetailsNew = new InvoiceDetailWrapper($invoiceDetail);
        $invoiceDetailsNew->setDescription($invoiceDetail->getDescription());
        $invoiceDetailsNew->setNetPrice($this->calculateNetPrice($invoiceDetail, $this->getTaxRate()));
        $invoiceDetailsNew->setGrossPrice($this->calculateGrossPrice($invoiceDetail, $this->getTaxRate()));
        $invoiceDetailsNew->setTaxPrice($this->calculateTaxPrice($invoiceDetail, $this->getTaxRate()));
        $invoiceDetailsNew->setUnitNettoPrice($this->calculateNetPrice($invoiceDetail, $this->getTaxRate()));
        $invoiceDetailsNew->setTaxRate($this->getTaxRate());
        return $invoiceDetailsNew;
    }
    
    /**
     * 
     * @param InvoiceDetail $invoiceDetail
     * @param unknown $explodePartNumber
     * @return \InvoiceBundle\Entity\Wrapper\InvoiceDetailWrapper
     */
    private function /*InvoiceDetailWrapper*/ adaptInvoiceExplodedDetail(InvoiceDetail $invoiceDetail, $explodePartNumber){
        $invoiceDetailsNew = new InvoiceDetailWrapper($invoiceDetail);
        $invoiceDetailsNew->setDescription($this->getItemDesc($invoiceDetail->getDescription()));
        $invoiceDetailsNew->setNetPrice($this->calculateNetPrice($invoiceDetail, $this->getTaxRate(), $explodePartNumber));
        $invoiceDetailsNew->setGrossPrice($this->calculateGrossPrice($invoiceDetail, $this->getTaxRate(), $explodePartNumber));
        $invoiceDetailsNew->setTaxPrice($this->calculateTaxPrice($invoiceDetail, $this->getTaxRate(), $explodePartNumber));
        $invoiceDetailsNew->setTaxRate($this->getTaxRate());
        $invoiceDetailsNew->setUnitNettoPrice($this->calculateNetPrice($invoiceDetail, $this->getTaxRate(), $explodePartNumber));
        return $invoiceDetailsNew;
    }
    
    /**
     * 
     * @param InvoiceDetail $invoiceDetail
     * @param unknown $count
     * @param unknown $desciption
     * @return \InvoiceBundle\Entity\Wrapper\InvoiceDetailWrapper
     */
    private function /*InvoiceDetailWrapper*/ adaptPrepaidInvoiceDetail(InvoiceDetail $invoiceDetail, $count, $desciption){
        $invoiceDetailsNew = new InvoiceDetailWrapper($invoiceDetail);
        $invoiceDetailsNew->setDescription($desciption);
        $invoiceDetailsNew->setCount($count);
        $invoiceDetailsNew->setNetPrice($this->calculateNetPrice($invoiceDetail, $this->getTaxRate()));
        $invoiceDetailsNew->setGrossPrice($this->calculateGrossPrice($invoiceDetail, $this->getTaxRate()));
        $invoiceDetailsNew->setTaxPrice($this->calculateTaxPrice($invoiceDetail, $this->getTaxRate()));
        $invoiceDetailsNew->setTaxRate($this->getTaxRate());
        $invoiceDetailsNew->setUnitNettoPrice($this->priceFormat(1));
        return $invoiceDetailsNew;
    }

    /**
     * 
     * @param InvoiceDetail $invoiceDetails
     * @param unknown $taxRate
     * @param string $explodePartNumber
     * @return string
     */
    private  function /*string*/ calculateNetPrice(InvoiceDetail $invoiceDetails, $taxRate, $explodePartNumber = null){
        $price = $invoiceDetails->getAmount();
        $price = ($explodePartNumber == null) ? $price : $price/$explodePartNumber;
        $price = (double) $price;
        return $this->priceFormat($price);
    }

    /**
     * 
     * @param InvoiceDetail $invoiceDetails
     * @param unknown $taxRate
     * @param string $explodePartNumber
     * @return string
     */
    private function /*string*/ calculateGrossPrice(InvoiceDetail $invoiceDetails, $taxRate, $explodePartNumber = null){
        $price = $invoiceDetails->getAmount() * (1 + $taxRate/100);
        $price = $explodePartNumber == null ? $price : $price/$explodePartNumber;
        $price = (double) $price;
        return $this->priceFormat($price);
    }
    
    /**
     * 
     * @param InvoiceDetail $invoiceDetails
     * @param unknown $taxRate
     * @param string $explodePartNumber
     * @return string
     */
    private function /*string*/ calculateTaxPrice(InvoiceDetail $invoiceDetails, $taxRate, $explodePartNumber = null){
        $price = $invoiceDetails->getAmount() * ($taxRate/100);
        $price = $explodePartNumber == null ? $price : $price/$explodePartNumber;
        $price = (double) $price;
        return $this->priceFormat($price);
    }
    
    /**
     * 
     * @param unknown $description
     * @return boolean
     */
    private function /*boolean*/ shouldExplodeItem($description){
        preg_match($this->invoiceItemdDesciptionExplodeRegex, $description, $m);
        return !empty($m);
    }
    
    /**
     * 
     * @param unknown $description
     * @return unknown
     */
    private function /*string*/ getItemDesc($description){
        preg_match($this->invoiceItemdDesciptionExplodeRegex, $description, $m);
        return  $m[2];
    }
    
    /**
     * 
     * @param unknown $description
     * @return unknown
     */
    private function /*int*/ getItemCount($description){
        preg_match($this->invoiceItemdDesciptionExplodeRegex, $description, $m);
        return $m[1];
    }

    /**
     * 
     * @param unknown $description
     * @return boolean
     */
    private function isLoadPrepaid($description){
        preg_match($this->prepaidLoadRegex, $description, $m);
        return (count($m) == 2);
    }
    
    /**
     * 
     * @param unknown $description
     * @return unknown
     */
    private function getCountLoadPoint($description){
        preg_match($this->prepaidLoadRegex, $description, $m);
        return $m[1];
    }

    /**
     * 
     * @param unknown $description
     * @return boolean
     */
    private function isOrderPrepaid($description){
        preg_match($this->prepaidOrderRegex, $description, $m);
        return (count($m) == 3);
    }
    
    /**
     * 
     * @param unknown $description
     * @return unknown
     */
    private function getCountOrderPoint($description){
        preg_match($this->prepaidOrderRegex, $description, $m);
        return $m[1];
    }
    
    /**
     * 
     * @param unknown $description
     * @return unknown
     */
    private function getCountOrderPointDecrtiption($description){
        preg_match($this->prepaidOrderRegex, $description, $m);
        return $m[2];
    }
    
    /**
     * 
     * @param unknown $price
     * @param string $sep
     * @param number $precision
     * @param string $skipDecimals
     * @return string
     */
    private function /*string*/ priceFormat($price, $sep = ',', $precision = 2, $skipDecimals = FALSE)
    {
        if ($skipDecimals && ($price - floor($price) == 0)){
            $precision = 0;
        }
        return number_format($price, $precision, $sep, ' ');
    }
    
    public function getNetPrice(){
        return $this->priceFormat($this->getInvoice()->getNetPrice());
    }
    
    public function getGrossPrice(){
        return $this->priceFormat($this->getInvoice()->getGrossPrice());
    }
	
	 public function getRawGrossPrice(){
        return $this->getInvoice()->getGrossPrice();
    }
    
    public function getTaxPrice(){
        return $this->priceFormat($this->getInvoice()->getTax());
    }
    
    public function getTaxRate(){
        return $this->getInvoice()->getTaxRate();
    }
    
    public function getInvoiceNumber(){
        if($this->getInvoice()->getStatus() == 'Paid'){
            return $this->getInvoice()->getInvoiceNumber();
        }
        return $this->getInvoice()->getId();
    }
    
    public function __call($method, $parms){
        return $this->getInvoice()->$method($parms);
    }
}
