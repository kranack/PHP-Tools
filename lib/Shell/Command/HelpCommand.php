<?php

namespace Tools\Shell\Command;

class HelpCommand extends Command
{

	public function __construct()
	{
        return parent::__construct('help', 'h', 'Print this help');
    }

	public function getBehavior() : ?callable
	{
        return function($console) {
            $console->help();
        };
    }

}