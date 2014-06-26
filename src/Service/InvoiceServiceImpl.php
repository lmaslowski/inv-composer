<?php
namespace InvoiceBundle\Service;

use InvoiceBundle\Printer\Builder\InvoicePdfBuilder;
use InvoiceBundle\Entity\Builder\InvoiceWrapperBuilder;
use InvoiceBundle\Printer\Builder\InvoicePdfDataConteinerBuilder;

class InvoiceServiceImpl implements InvoiceService{
    private $invoicePdfBuilder;
    private $invoiceWrapper;
    
    public function __construct($invoiceProperties, $clientProperties, $tcpdf, $ammountByWordHelper = null){
        $this->invoiceWrapper = InvoiceWrapperBuilder::buildWithClient($invoiceProperties, $clientProperties);
        $this->invoicePdfBuilder = new InvoicePdfBuilder ($tcpdf, InvoicePdfDataConteinerBuilder::build($this->getInvoiceWrapper(), $ammountByWordHelper));
    }
    
    /**
     * @return InvoicePdfBuilder
     */
    private function getInvoicePdfBuilder(){
        return $this->invoicePdfBuilder;
    }
    
    /**
     * @return InvoiceWrapperImpl
     */
    private function getInvoiceWrapper(){
        return $this->invoiceWrapper;
    }
    
    public function isPaid(){
        return $this->getInvoiceWrapper()->getInvoice()->getStatus() == 'Paid';
    }
    
    public function getYearAndMounthPaidData(){
        $date = new \DateTime($this->getInvoiceWrapper()->getInvoice()->getPaymentDate());
		return $date->format('Ym');
    }
	
	public function getInvoiceNumber(){
        return $this->getInvoiceWrapper()->getInvoice()->getInvoiceNumber();
    }
    
    public function bulidPdfAndRender(){
        $this->getInvoicePdfBuilder()->build()->output();
    }
	
	public function bulidPdf(){
        return $this->getInvoicePdfBuilder()->build();
    }
	
    public function archivePdfInvoicePerYearMouth($baseDir){
        $this->archivePdfInvoice($baseDir, "/".$this->getYearAndMounthPaidData(), $this->getInvoiceNumber());
    }
    
    public function readPdfInvoicePerYearMounthFromArchive($baseDir){
        $this->readPdfInvoiceFromArchive($baseDir, "/".$this->getYearAndMounthPaidData(), $this->getInvoiceNumber());
    }
    
    public function archivePdfInvoice($baseDir, $subDir, $invoiceFileNameBase){
        $pdf = $this->getInvoicePdfBuilder()->build();
        $pdfStorage = new PdfStorageImpl($pdf, $baseDir, $subDir);
        $pdfStorage->save($invoiceFileNameBase);
    }

    public function readPdfInvoiceFromArchive($baseDir, $subDir, $invoiceFileNameBase){
        $pdf = $this->getInvoicePdfBuilder()->build();
        $pdfStorage = new PdfStorageImpl($pdf, $baseDir, $subDir);
        $pdfStorage->readAndRender($invoiceFileNameBase);
    }
} 