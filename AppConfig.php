<?php #AppConfig.php
class AppConfig {
	private $env;
	private $navs;
	private $mode;
	private $debug;
	private static $instance = null;
	
	public static function getInstance($configPath = null){
		if(self::$instance === null){
			self::$instance = new AppConfig($configPath);
		}
		return self::$instance;
	}
	
	private function __construct(&$configPath){
		if(!is_readable($configPath)){
			exit('Application Error occurred - code 505');
		}
		$xml = simplexml_load_file($configPath);
		$mode = (string)$xml->mode;
		$this->mode = $mode;
		$this->env = $xml->$mode;
		$this->debug = (string)strtolower($this->env->debug) === 'true';
		$this->navs = (isset($this->env->web))? self::navsToArray($this->env->web->nav): null;
		return $this->env;
	}
	
	public function getEnv($xpath = null) {
		if($xpath === null)
			return $this->env;
		else if(is_string($xpath) && strlen($xpath))
			return $this->env->xpath($xpath);
	}

	public function getDebug() {
		return $this->debug;
	}

	public function getNavs() {
		return $this->navs;
	}

	private function navsToArray(&$xmlNav){
		$nav = array();
		
		$home = (string)$this->env->home;
		foreach($xmlNav->children() as $role => $navitem){
			$rootlink = $xmlNav->$role->children();
			$roleLinks = array();
			foreach($rootlink as $v => $links){
				$links = $links->attributes();
				$name = (string)$links['name'];
				$path = (string)$links['path'];
				$url = ($links['prepend'])? $home . $path: $path;
				$roleLinks[$name] = $url;
			}
			$roleName = (string)$role;
			$nav[$roleName] = $roleLinks;
		}
		
		if(isset($nav['all'])) {
			foreach($nav as $key => $value){
				if($key !== 'all'){
					$nav[$key] = array_merge($nav['all'], $nav[$key]);
				}
			}
		}
		
		return $nav;
	}
}
?>
