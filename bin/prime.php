#!/usr/bin/env php
<?php

require_once("require.php");

use Exec\Executable;
use Exec\Params;

$callback = function($args, $opts) {
	$number = intval($args[0]);

	var_dump(isPrime($number));
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
		"value"	=> "USAGE : " . __FILE__ . " number"
	],
	(object) [
		"key"	=> "callback",
		"value"	=> $callback
	]
]);

$exec = new Executable($params);
$exec->run($argc, $argv);

function isPrime($number) {
	if ($number <= 1)
        return false;
    else if ($number <= 3)
        return true;
    else if ($number % 2 === 0 || $number % 3 === 0)
        return false;
    $i = 5;
    while ($i * $i <= $number)
        if ($number % $i === 0 || $number % ($i + 2) === 0)
            return false;
        $i = $i+6;
    return true;
}
