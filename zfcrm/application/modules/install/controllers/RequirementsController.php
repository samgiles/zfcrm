<?php

class Install_RequirementsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	
    }

    public function indexAction()
    {
        $requirements = new Install_Model_Requirements();
        $this->view->modRewrite = $requirements->hasRewriteInstalled();
        $this->view->hasZFVersion = $requirements->hasZendFrameworkVersion();
        $this->view->hasRequiredPhpVersion = $requirements->hasCorrectPhpVersion();
        $this->view->requiresJava = $requirements->requiresJava();
        
        
        $this->view->minZF = $requirements->getRequiredZendFrameworkVersion();
        $this->view->minPhp = $requirements->getRequiredPhpVersion();
        
        $this->view->actualZFVersion = $requirements->getZendFrameworkVersion();
        $this->view->actualPhpVersion = $requirements->getPhpVersion();
        
        $minimumJava = $requirements->requiresJava() ? 'yes' : 'no';
        
        $this->view->minJava = $minimumJava;
        $this->view->actualJava = $requirements->hasJavaBridge() ? 'yes' : 'no';
        $this->view->meetsMinimum = $minimumJava == $this->view->actualJava;
        
        $this->view->minJavaVersion = $requirements->getRequiredJavaVersion();
        $this->view->actualJavaVersion = $requirements->getJavaVersion();
        $this->view->meetsMinimumJavaVersion = $requirements->hasRequiredJavaVersion();
      	
        $this->view->headLink()->appendStylesheet('/css/install/styles.css');
        
        
    }


}

