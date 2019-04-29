#!/usr/bin/env php
<?php

require_once("require.php");

use Tools\Exec\Executable;
use Tools\Exec\Params;

use Tools\File\File;
use Tools\UTF8\UTF8;

$callback = function($args, $opts) {
	$content = (new File($args[0]))->read();
	
	$object = unserialize(base64_decode($content));

	var_dump($object);
}; 

$params = new Params([
    "requiredParams" => 1,
    (object) [
		"key" 	=> "optsStruct",
		"value"	=> (object) [
			"shortOpts"	=> "",
			"longOpts"	=> []
		]
	],
	(object) [
		"key"	=> "usage",
		"value"	=> "USAGE : " . __FILE__ . " [opts] serializedObject"
	],
	(object) [
		"key"	=> "callback",
		"value"	=> $callback
	]
]);

$exec = new Executable($params);
$exec->run($argc, $argv);