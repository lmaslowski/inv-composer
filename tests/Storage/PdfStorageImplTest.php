<?php
namespace InvoiceBundle\Tests\Storage;

use InvoiceBundle\Storage\PdfStorageImpl;
use InvoiceBundle\Storage\Exception\DirNotExistsException;
use InvoiceBundle\Storage\Exception\ResourceNotExistsException;
use InvoiceBundle\Storage\Exception\ResourceExistsException;
class PdfStorageImplTest extends \PHPUnit_Framework_TestCase{
    
    private $pdfStorageImpl;
    
    public function setUp(){
        parent::setUp();
        $this->pdfStorageImpl = new PdfStorageImpl(new \TCPDF(), dirname(__FILE__).'/_pdfStorageDir');
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
     * 
     */
    public function savePdfToStorageDir(){
        $this->getPdfStorageImpl()->save('invoiceFileName-2');
        $this->assertTrue(file_exists(dirname(__FILE__).'/_pdfStorageDir/invoiceFileName-2.pdf'));
        unlink(dirname(__FILE__).'/_pdfStorageDir/invoiceFileName-2.pdf');
    }

    /**
     * @test
     * @expectedException InvoiceBundle\Storage\Exception\ResourceNotExistsException
     */
    public function readUnExistResource(){
        $this->getPdfStorageImpl()->readAndRender('noExistResource');
    }
    
    /**
     * @test
     * @expectedException InvoiceBundle\Storage\Exception\ResourceExistsException
     */
    public function saveExistResource(){
        $this->getPdfStorageImpl()->save('invoiceFileName-1');
    }

    /**
     * @test
     * @expectedException InvoiceBundle\Storage\Exception\DirNotExistsException
     */
    public function storageDirNotExists(){
        new PdfStorageImpl(new \TCPDF(), dirname(__FILE__).'/_pdfStorageDirAAAAAAAAAA');
    }
}