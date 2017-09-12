<?php

namespace Exec;

use Console\Console;

class Executable {

	private $console;

	private $params;

	public function __construct(Params $params) {
		$this->params = $params;

		$this->console = null;
	}

	private function init($argc, $argv) {
		$requiredParams = ($this->params->requiredParams) ? $this->params->requiredParams : 1;
		$this->console = new Console($argc, $argv);
		$this->console->setUsage($this->params->usage);
		$this->console->setRequiredParams($requiredParams);
	}

	public function run($argc, $argv) {
		if ($this->console === null) {
			$this->init($argc, $argv);
		}

		$this->console->exec($this->params->optsStruct, $this->params->callback);
	}

}
