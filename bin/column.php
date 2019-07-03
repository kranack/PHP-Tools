#!/usr/bin/env php
<?php

require_once("require.php");

use Tools\Exec\Executable;
use Tools\Exec\Params;

$callback = function($args, $opts, $console) {
	$column = str_split($args[0]);

	$values = array_map(function($column, $index) { return ($index * (ord('Z') - ord('A'))) + ord(strtoupper($column)) - ord('A') + 1; }, $column, array_keys($column));

	$console->print(array_reduce($values, function($carry, $item) { return $carry += $item; }, 0));
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