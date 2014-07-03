<?php
namespace InvoiceBundle\Storage;

use InvoiceBundle\Storage\Exception\DirNotExistsException;
use InvoiceBundle\Storage\Exception\DirPermissionDenied;
use InvoiceBundle\Storage\Exception\DirPermissionDeniedException;
use InvoiceBundle\Storage\Exception\ResourceExistsException;
use InvoiceBundle\Storage\Exception\ResourceNotExistsException;
class PdfStorageImpl implements PdfStorage{

    private $tcpdf;
    private $storageDirPath;
    
    public function __construct(\TCPDF $tcpdf, $baseStorageDir, $subDir = null){
        if(!is_dir($baseStorageDir)){
            throw new DirNotExistsException();
        }
        
        if(!is_readable($baseStorageDir) || !is_writable($baseStorageDir)){
            throw new DirPermissionDeniedException($baseStorageDir . ' is not readable or not writable');
        }
        
        if($subDir == null){
            $subDir = '';
        }
        
        $storageDir = $baseStorageDir.$subDir;
        
        if(!is_dir($storageDir)){
            mkdir($storageDir);
        }
        
        if(!is_dir($storageDir)){
            throw new DirNotExistsException();
        }
        
        if(!is_readable($storageDir) || !is_writable($storageDir)){
            throw new DirPermissionDeniedException($storageDir . ' is not readable or not writable');
        }
        
        $this->tcpdf = $tcpdf;
        $this->storageDirPath  = $storageDir; 
    }

    private function getPdf(){
        return $this->tcpdf;
    }
    
    private function getStorageDirPath(){
        return $this->storageDirPath;
    }
    
    public function save($invoiceFileNameBase){
        
        $this->_save($invoiceFileNameBase);
    }
    
    public function _save($invoiceFileNameBase){
        $filename = $this->getStorageDirPath() . "/" .$invoiceFileNameBase.".pdf";
        if(!file_exists($filename)){
            $this->getPdf()->output($filename, "F");
            return;
        }
        throw new ResourceExistsException($filename . ' exist now');
    }
    
    public function readAndRender($invoiceNum){
        $this->_read($invoiceNum);
    }
    

    public function _read($invoiceNum){
        $filename = $this->getStorageDirPath() ."/". $invoiceNum.".pdf";
        
        if(!file_exists($filename)){
            throw new ResourceNotExistsException($filename . ' don\'t exists');
        }
        
        if ($fd = fopen ($filename, "r")) {
            $fsize = filesize($filename);
            $path_parts = pathinfo($filename);
            $ext = strtolower($path_parts["extension"]);
            switch ($ext) {
                case "pdf":
                    header("Content-type: application/pdf"); // add here more headers for diff. extensions
                    header("Content-Disposition: attachment; filename=archive-".$invoiceNum.".pdf");
                    break;
                default;
                header("Content-type: application/octet-stream");
                header("Content-Disposition: filename=\"".str_replace("-", "/", $path_parts["basename"])."\"");
            }
        
            header("Content-length: $fsize");
            header("Cache-control: private"); //use this to open files directly
            while(!feof($fd)) {
                $buffer = fread($fd, 2048);
                echo $buffer;
            }
        }
    }
    
}