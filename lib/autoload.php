<?php

ini_set("memory_limit", -1);

$ver = (float)phpversion();
if ($ver <= 7.0) {
    die("Script need PHP version 7 or higher\n");
}

set_include_path(get_include_path() . PATH_SEPARATOR . '/Users/damiencalesse/dev/php');


spl_autoload_register(function($class) {
	//if (strtolower(substr($class, 0, 3)) === "lib") {
		if (class_exists($className) || interface_exists($className) || trait_exists($className)) {
			return;
		}
		$path = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . ".php";
		if (file_exists($path)) { 
	   		require_once($path);
		} else {
			throw new Exception("Fichier introuvable [" . $path . "]");
		}
	//} else {
	//	throw new Exception("Impossible de charger la classe [" . $class . "]");
	//}
});
