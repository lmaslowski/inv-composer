<?php
namespace InvoiceBundle\Service;
 
interface InvoiceService{
    public function isPaid();
    public function bulidPdfAndRender();
    public function archivePdfInvoice($baseDir, $subDir, $invoiceFileNameBase);
    public function readPdfInvoiceFromArchive($baseDir, $subDir, $invoiceFileNameBase);
}