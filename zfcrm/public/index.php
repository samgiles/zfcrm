<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';
require 'zfcrm/write_ini.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);


// Set up a default layout.
Zend_Layout::startMvc(array(
			'layoutPath' => '../application/layouts/scripts/',
			'layout'	 => 'layout',
));

/** Application_Plugins_LayoutPlugin */
require_once ('../application/plugins/LayoutPlugin.php');
		
// register modules and their respective layouts.
$layoutModulePlugin = new Application_Plugins_LayoutPlugin();
$layoutModulePlugin->registerModuleLayout('default', '../application/layouts/scripts/');	
$layoutModulePlugin->registerModuleLayout('install', '../application/modules/install/layouts/scripts/');
		
// Add the layout module to the front controller.		
$controller = Zend_Controller_Front::getInstance();
$controller->registerPlugin($layoutModulePlugin);


$application->bootstrap()
            ->run();