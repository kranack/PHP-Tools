<?php

require_once("require.php");

use Exec\Executable;
use Exec\Params;

use File\File;
use UTF8\UTF8;

$callback = function($args, $opts) {
    UTF8::sanitize(new File($args[0]));
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
		"value"	=> "USAGE : " . __FILE__ . " [opts] filename"
	],
	(object) [
		"key"	=> "callback",
		"value"	=> $callback
	]
]);

$exec = new Executable($params);
$exec->run($argc, $argv);