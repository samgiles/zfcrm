<?php

class Install_DatabaseController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {   
    	
    	$form = new Install_Form_Database();
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()){
    		if ($form->isValid($request->getPost())) {
                $values = $form->getValues();
                if ($this->verifyDatabase($values)){
                	// Next.	
                	
                }
            }
    	}
    	
        
        $this->view->form = $form;
    }
	
    protected function verifyDatabase($values){
    	try {
    	$db = Zend_Db::factory($values['adapter'], array(
    		'host'	=> $values['host'],
    		'username' => $values['username'],
    		'password' => $values['password'],
    		'dbname'   => $values['dbname'],
    	));
    	$db->getConnection();
    	} catch (Zend_Db_Adapter_Exception $e) {
    		throw new Exception($e->getMessage()); // Something was wrong with the user input.
    		return false;
    	}
    	
    	if (!isset($db)) return false;
    	
    	// Write to application config.ini
    	
    	
    	
    	
    	return $this->writeDatabaseConfigs($values);
    	
    }
    
    protected function writeDatabaseConfigs($values){
    	
    	$array = array();
    	
    	foreach ($values as $key => $value){
    		$array['database.' . $key] = $value;
    	}
    	
		append_to_application_config('production', $array);
    	return true;
    }

}

