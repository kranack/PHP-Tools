<?php

namespace Tools\Shell;

use Tools\Shell\Command\HelpCommand;
use Tools\Shell\Command\ExitCommand;

class Shell {

	private $commands;

	private $running;
	
	public function __construct(array $commands = []) {
		$this->commands = $commands;
		$this->running = true;

		$this->init();
	}

	public function getCommands() { return $this->commands; }

	public function isRunning() { return $this->running; }

	public function stop() { $this->running = false; }

	public function exec($cmd) {
		$commands = array_filter($this->commands, function($command) use ($cmd) {
			return $command->match($cmd);
		});

		return (count($commands)) ? reset($commands) : null;
	}

	private function init() {
		if (count($this->commands) === 0) {
			$this->initDefaultCommands();
		}
	}

	private function initDefaultCommands() {
		$this->commands = [
			new HelpCommand(),
			new ExitCommand($this)
		];
	}

}