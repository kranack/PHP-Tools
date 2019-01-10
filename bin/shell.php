#!/usr/bin/env php
<?php

require_once("require.php");

use Exec\Executable;
use Exec\Params;
use Shell\Shell;


$shell = new Shell();

$itCallback = function($args, $opts, $console) use ($shell) {
    do {
        $response = $console->ask(">");

        $command = $shell->exec($response);
        if ($command) {
            $command->getBehavior()($console);
        }

    } while ($shell->isRunning());
};

$callback = function($args, $opts, $console) {
    $console->print("GOODBYE");
};

$helpCallback = function($console) use ($shell) {
    $console->print("\tNAME\tALIAS\tDESCRIPTION");
    $console->print("\t--------------------------------");
    foreach ($shell->getCommands() as $command) {
        $aliases = $command->getAlias();
        $aliases = (is_string($aliases) && strlen($aliases)) ? [$aliases] : $aliases;
        $console->print(sprintf("\t%s\t%s\t%s", $command->getName(), implode($aliases, ","), $command->getDescription()));
    }
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
    ],
    (object) [
		"key"	=> "helpCallback",
		"value"	=> $helpCallback
	]
]);

$exec = new Executable($params);
$exec->run($argc, $argv);