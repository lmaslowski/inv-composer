<?php
namespace InvoiceBundle\Tests\Storage;

use InvoiceBundle\Storage\PdfStorageImpl;
class PdfStorageImplTest extends \PHPUnit_Framework_TestCase{
    
    private $pdfStorageImpl;
    
    public function setUp(){
        parent::setUp();
        $this->pdfStorageImpl = new PdfStorageImpl(new \TCPDF(), dirname(__FILE__).'/pdfStorageDir');
    }
    
    public function tearDown(){
        $this->pdfStorageImpl = null;
    }

    /**
     * 
     * @return \InvoiceBundle\Storage\PdfStorageImpl
     */
    private function getPdfStorageImpl(){
        return $this->pdfStorageImpl;
    }
    
    /**
     * @test
     */
    public function savePdfToStorageDir(){
        $this->getPdfStorageImpl()->save('invoiceFileName-1');
        $this->assertTrue(file_exists(dirname(__FILE__).'/pdfStorageDir/invoiceFileName-1.pdf'));
        unlink(dirname(__FILE__).'/pdfStorageDir/invoiceFileName-1.pdf');
    }
}