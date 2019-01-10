#!/usr/bin/env php
<?php

require_once("require.php");

use Exec\Executable;
use Exec\Params;

$callback = function($args, $opts, $console) {
	if (key_exists("f", $opts) || key_exists("filename", $opts)) {
		$start = intval($args[1]);
		$end = intval($args[2]);

		$console->save(range($start, $end), $args[0]);
	} else {
		$start = intval($args[0]);
		$end = intval($args[1]);

		$console->print(implode(' ', range($start, $end)));
	}
}; 

$params = new Params([
	(object) [
		"key" 	=> "optsStruct",
		"value"	=> (object) [
			"shortOpts"	=> "f",
			"longOpts"	=> ["filename"]
		]
	],
	"requiredParams" => 2,
	(object) [
		"key"	=> "usage",
		"value"	=> "USAGE : " . __FILE__ . " [opts] start end"
	],
	(object) [
		"key"	=> "callback",
		"value"	=> $callback
	]
]);

$exec = new Executable($params);
$exec->run($argc, $argv);