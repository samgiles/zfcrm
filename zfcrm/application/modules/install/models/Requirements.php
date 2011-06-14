<?php

class Install_Model_Requirements
{

	protected $_requirements;
	
	public function __construct(){
		$this->_requirements = parse_ini('/../configs/reqs.ini');
	}
	
	private function getPhpVersion(){
		return phpversion();
	}
	
	public function hasCorrectPhpVersion(){
		return $this->getRequiredPhpVersion() == $this->getPhpVersion();
	}
	
	public function getRequiredPhpVersion(){
		return $this->_requirements['php-version'];
	}
	
	public function hasRewriteInstalled(){
		return in_array('mod_rewrite', apache_get_modules());
	}
	
	public function hasZendFrameworkVersion(){
		return (Zend_Version::compareVersion($this->getRequiredZendFrameworkVersion()) >= 1);
	}
	
	public function getRequiredZendFrameworkVersion(){
		return $this->_requirements['zf-version'];
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
		if (requiresJava()){
			return $this->_requirements['java-version'];
		} else {
			return '0';
		}
	}
	
	public function hasJavaBridge(){
		if (requiresJava()){
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
		if (hasJavaBridge()){
			$system = new Java("java.lang.System");
			$version = $system.getProperty("java.version");
			
			return (version_compare($version, $this->getRequiredJavaVersion()) >= 0);
		} else {
			return false;
		}
	}
	
}

