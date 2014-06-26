<?php
namespace InvoiceBundle\Storage;

interface  PdfStorage{
    public function save($invoiceFileNameBase);
    public function readAndRender($invoiceFileNameBase);
    
}