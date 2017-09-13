<?php

require_once("lib/autoload.php");

use Exec\Executable;
use Exec\Params;

$commands = [
    (object) [ "name" => "help", "alias" => "h", "desc" => "Print this help"],
    (object) [ "name" => "exit", "alias" => ["quit", "q"], "desc" => "Exit the shell"]
];

$itCallback = function($args, $opts, $console) {
    do {
        $response = $console->ask(">");

        switch ($response) {
            case "help":
            case "h":
                $console->help();
                break;
            default:
                break;
        }
    } while ($response !== "quit" && $response !== "q" && $response !== "exit");
};

$callback = function($args, $opts, $console) {
    $console->print("GOODBYE");
};

$helpCallback = function($console) use ($commands) {
    $console->print("\tNAME\tALIAS\tDESCRIPTION");
    $console->print("\t--------------------------------");
    foreach ($commands as $command) {
        if (!is_object($command)) continue;

        $aliases = ($command->alias) ? $command->alias : [];
        $aliases = (is_string($aliases) && strlen($aliases)) ? [$aliases] : $aliases;
        $console->print(sprintf("\t%s\t%s\t%s", $command->name, implode($aliases, ","), $command->desc));
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