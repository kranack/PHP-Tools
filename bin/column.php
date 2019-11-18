#!/usr/bin/env php
<?php

require_once("require.php");

use Tools\Exec\Executable;
use Tools\Exec\Params;

$callback = function($args, $opts, $console) {
	$column = str_split($args[0]);

	$range = (ord('Z') - ord('A'));
	$length = count($column);

	$r = 0;
	foreach (array_reverse($column) as $k => $col) {
		$pos = ord(strtoupper($col)) - ord('A') + 1;

		$r += ($pos * $k * $range) + $pos;
	}

	$console->print($r);
}; 

$params = new Params([
	"requiredParams" => 1,
	(object) [
		"key"	=> "usage",
		"value"	=> "USAGE : " . __FILE__ . " column"
	],
	(object) [
		"key"	=> "callback",
		"value"	=> $callback
	]
]);

$exec = new Executable($params);
$exec->run($argc, $argv);