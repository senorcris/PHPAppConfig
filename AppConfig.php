<?php
class AppConfig 
{
  static private $debug = true;

  static private $env;

	static private $navs;

	static private $mode;

	static public function getEnv() {
		if(!isset(self::$env)) {
			$configPath = dirname(__FILE__).'/../appconfig.xml';
			if (file_exists($configPath)) {
			    $xml = simplexml_load_file($configPath);
			    $mode = (string)$xml->mode;
			    self::$mode = $mode;
			    self::$env = $xml->$mode;
			    self::$debug = (string)self::$env->debug === 'true';
			    if(isset(self::$env->web)) {
			    	self::$navs = self::navsToArray(self::$env->web->nav);
			    }
			} else {
			    exit('Application Error occured - code 505');
			}
		}
		return self::$env;
	}

	static public function getDebug() {
		return self::$debug;
	}

	static public function getNavs() {
		if(!isset(self::$navs))
			self::getEnv();
		return self::$navs;
	}

	static function navsToArray($xmlNav) {
		$nav = array();
		if(isset($xmlNav)){
			foreach ($xmlNav->children() as $role => $navitem) {
				$rootlink = $xmlNav->$role->children();
				$roleLinks = array();
				$roleName = (string) $role;
				foreach ($rootlink as $v => $links) {
					$links = $links->attributes();
					$name = (string)$links["name"];
					$home = (string)self::$env->home;
					$path = (string)$links["path"];
					$url = (string)$links['prepend'] ? ($home).$path :$path;
					$roleLinks[$name] = $url;
				}
				$nav[$roleName] = $roleLinks;
			}
			if(isset($nav['all'])) {
				foreach ($nav as $key => $value) {
					if($key !== 'all') {
						$nav[$key] = array_merge($nav['all'], $nav[$key]);
					}
				}
			}
		}
		return $nav;
	}
}
?>
