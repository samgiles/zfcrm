<?php
class Application_Plugins_LayoutPlugin extends Zend_Controller_Plugin_Abstract {
	
	protected $_moduleLayouts;
	
	public function registerModuleLayout($module, $layoutPath, $layout = 'layout') {
		
		$this->_moduleLayouts[$module] = array (
			'layoutPath' => $layoutPath,
			'layout'	 => $layout,
		);
	}
	
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		
		if (isset($this->_moduleLayouts[$request->getModuleName()])) {
			$config = $this->_moduleLayouts[$request->getModuleName()];
			
			$layout = Zend_layout::getMvcInstance();
			
			if ($layout->getMvcEnabled()){
				$layout->setLayoutPath($config['layoutPath']);
				
				if (is_null($config['layout'])){
					$layout->setLayout($config['layout']);
				}
			}
		}
	}
}