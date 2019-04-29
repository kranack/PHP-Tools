#!/usr/bin/env php
<?php

require_once("require.php");

use Tools\Exec\Executable;
use Tools\Exec\Params;
use Tools\JSON\JSON as JSONParser;

$callback = function($args, $opts) {
    $pretty = true;
    if (key_exists("u", $opts) || key_exists("unpretty", $opts)) {
        $pretty = false;
    }

    $parser = new JSONParser($args[0]);
    if ($pretty) $parser->pretty();
    else $parser->unpretty();
}; 

$params = new Params([
	"requiredParams" => 1,
	(object) [
		"key" 	=> "optsStruct",
		"value"	=> (object) [
			"shortOpts"	=> "u",
			"longOpts"	=> ["unpretty"]
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
