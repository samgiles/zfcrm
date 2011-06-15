<?php

class Install_Bootstrap extends Zend_Application_Module_Bootstrap {
	
	/**
	 * Initializes the Zend_Application_Module_Autoloader.
	 */
	protected function _initAppAutoLoad() {
		
		$autoloader = new Zend_Application_Module_Autoloader(array(
			'namespace' => 'Application',
			'basePath'  => dirname(__FILE__),
		));
		
		return $autoloader;
	}

}