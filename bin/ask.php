#!/usr/bin/env php
<?php

require_once("require.php");

use Exec\Executable;
use Exec\Params;

$itCallback = function($args, $opts, $console) {
    $response = $console->ask("How are you?");
    $console->print(sprintf("Me too, I'm %s !", $response));
};

$callback = function($args, $opts, $console) {
    $console->print("GOODBYE");
};

$params = new Params([
    "usage"         => "USAGE : " . __FILE__,
    "interactive"   => true,
    (object) [
		"key"	=> "itCallback",
		"value"	=> $itCallback
	],
	(object) [
		"key"	=> "callback",
		"value"	=> $callback
	]
]);

$exec = new Executable($params);
$exec->run($argc, $argv);