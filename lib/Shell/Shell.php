<?php

namespace Tools\Shell;

use Tools\Shell\Command\{ Command, ExitCommand, HelpCommand };

class Shell
{

	/**
	 * Commands
	 *
	 * @var array
	 */
	private $commands;

	/**
	 * Is running
	 *
	 * @var bool
	 */
	private $running;
	
	public function __construct(array $commands = [])
	{
		$this->commands = $commands;
		$this->running = true;

		$this->init();
	}

	public function getCommands() : array { return $this->commands; }

	public function isRunning() : bool { return $this->running; }

	public function stop() : void { $this->running = false; }

	public function exec(string $cmd) : ?Command
	{
		$commands = array_filter($this->commands, function($command) use ($cmd) {
			return $command->match($cmd);
		});

		return (count($commands)) ? reset($commands) : null;
	}

	private function init() : void
	{
		if (count($this->commands) === 0) {
			$this->initDefaultCommands();
		}
	}

	private function initDefaultCommands() : void
	{
		$this->commands = [
			new HelpCommand(),
			new ExitCommand($this)
		];
	}

}