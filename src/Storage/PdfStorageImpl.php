<?php
namespace InvoiceBundle\Storage;

class PdfStorageImpl implements PdfStorage{

    private $tcpdf;
    private $storageDirPath;
    
    public function __construct(\TCPDF $tcpdf, $baseStorageDir, $subDir = null){
        $this->tcpdf = $tcpdf;

        if(!is_readable($baseStorageDir) || !is_writable($baseStorageDir)){
            throw new \Exception($baseStorageDir . ' is not readable or not writable');
        }
        
        if($subDir == null){
            $subDir = '';
        }
        
        $storageDir = $baseStorageDir.$subDir;
        
        if(!is_dir($storageDir)){
            mkdir($storageDir);
        }
        
        if(!is_readable($storageDir) || !is_writable($storageDir)){
            throw new \Exception($storageDir . ' is not readable or not writable');
        }
        
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
        throw new \Exception($filename . ' exist now');
    }
    
    public function readAndRender($invoiceNum){
        $this->_read($invoiceNum);
    }
    

    public function _read($invoiceNum){
        $filename = $this->getStorageDirPath() ."/". $invoiceNum.".pdf";
        
        if(!file_exists($filename)){
            throw new \Exception($filename . ' don\'t exists');
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