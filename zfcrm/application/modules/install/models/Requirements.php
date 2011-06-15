<?php

class Install_Model_Requirements
{

	protected $_requirements;
	
	public function __construct(){
		$this->_requirements = parse_ini_file(APPLICATION_PATH . '/modules/install/configs/reqs.ini');
	}
	
	public function getPhpVersion(){
		return phpversion();
	}
	
	public function hasCorrectPhpVersion(){
		return (version_compare($this->getPhpVersion(), $this->getRequiredPhpVersion()) >= 0);
	}
	
	public function getRequiredPhpVersion(){
		return $this->_requirements['php-version'];
	}
	
	public function hasRewriteInstalled(){
		return in_array('mod_rewrite', apache_get_modules());
	}
	
	public function hasZendFrameworkVersion(){
return (version_compare($this->getZendFrameworkVersion(), $this->getRequiredZendFrameworkVersion()) >= 0);
	}
	
	public function getRequiredZendFrameworkVersion(){
		return $this->_requirements['zf-version'];
	}
	
	public function getZendFrameworkVersion(){
		return Zend_Version::VERSION;
	}
	
	public function hasPDOEnabled(){
		return in_array('PDO', get_loaded_extensions());
	}
	
	public function getAvailablePDODrivers(){
		$array = array();
		
		foreach (get_loaded_extensions() as $key => $value){
			if (strpos($value, 'pdo_') !== false){
				$array[$value] = str_replace('pdo_', '', $value); 
			}
		}
		
		return $array;
		
	}
	
	public function hasMySQLVersion($host, $username, $password) {
		$conn = mysql_pconnect($host, $username, $password);
		$mysqlVersion = preg_replace('#[^0-9\.]#', '', mysql_get_server_info());
		if (version_compare($mysqlVersion, $this->getRequiredMySQLVersion()) >= 0){
			return true;
		}else {
			return false;
		}
	}
	
	public function getRequiredMySQLVersion(){
		return $this->_requirements['mysql-version'];
	}
	
	public function requiresJava(){
		return isset($this->_requirements['java-version']);
	}
	
	public function getRequiredJavaVersion(){
		if ($this->requiresJava()){
			return $this->_requirements['java-version'];
		} else {
			return false;
		}
	}
	
	public function hasJavaBridge(){
		if ($this->requiresJava()){
			try {
				$system = new Java("java.lang.System");
			}catch (Exception $e)
			{
				return false;
			}
			
			return true;
		} else { return false; }
	}
	
	public function hasRequiredJavaVersion(){
		if ($this->hasJavaBridge()){
			$system = new Java("java.lang.System");
			$version = $system.getProperty("java.version");
			
			return (version_compare($version, $this->getRequiredJavaVersion()) >= 0);
		} else {
			return false;
		}
	}
	
	public function getJavaVersion(){
		if ($this->hasJavaBridge()){
			$system = new Java("java.lang.System");
			return $system.getProperty("java.version");
		} else {
			return 0;
		}
	}
	
}

