<?php

class Install_Form_Database extends Zend_Form
{

    public function init()
    {
        // get the available PDO's
        $requires = new Install_Model_Requirements();
        $pdos = $requires->getAvailablePDODrivers();
  
        $this->setName("database");
        $this->setMethod('post');
        
        $this->addElement('select', 'adapter', array(
        	'label' => 'Select PDO driver: ',
        	'multiOptions' => $pdos,
        	'validator' => array(),
        ));
        
        $this->addElement('text', 'host', array(
        	'label' => 'Database host: ',
        	'required' => true,
        	'filters' => array('StringTrim'),
        ));
        
        $this->addElement('text', 'username', array(
        	'label' => 'Database username: ',
        	'required' => true,
        	'filters' => array('StringTrim'),
        ));
        
        $this->addElement('password', 'password', array(
        	'label' => 'Database password: ',
        	'required' => false,
        	'filters' => array('StringTrim'),
        ));
        
        $this->addElement('text', 'dbname', array(
        	'label' => 'Database name: ',
        	'required' => true,
        	'filters' => array('StringTrim'),
        ));
        
        $this->addElement('text', 'dbprefix', array(
        	'label' => 'Table prefix: ',
        	'required' => false,
        	'filters' => array('StringTrim'),
        ));
        
        $this->addElement('submit', 'submit', array(
        	'ignore' => true,
        	'label'  => 'Update',
        ));
    }


}

