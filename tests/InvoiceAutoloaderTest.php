<?php
// autoload function
function InvoiceAutoloaderTest($class) {
	if(strpos($class, 'InvoiceBundle') == 0 ){
		// convert namespace to full file path
		$class = dirname(__FILE__) . '/../../' . str_replace('\\', '/', $class) . '.php';
		
		require_once($class);
	}
}
spl_autoload_register('InvoiceAutoloaderTest');


