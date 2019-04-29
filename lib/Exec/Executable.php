<?php

namespace Tools\Exec;

use Tools\Console\Console;

class Executable {

	private $console;

	private $params;

	public function __construct(Params $params) {
		$this->params = $params;

		$this->console = null;
	}

	private function init($argc, $argv) {
		$requiredParams = ($this->params->requiredParams) ? $this->params->requiredParams : 0;
		$isInteractive = !!$this->params->interactive;

		$this->console = new Console($argc, $argv);
		$this->console->setUsage($this->params->usage);
		$this->console->setRequiredParams($requiredParams);

		if ($isInteractive && $this->params->itCallback) {
			$this->console->setInteractive($this->params->itCallback);
		}
		
		if ($this->params->helpCallback) {
			$this->console->setHelp($this->params->helpCallback);
		}
	}

	public function run($argc, $argv) {
		if ($this->console === null) {
			$this->init($argc, $argv);
		}

		$this->console->exec($this->params->optsStruct, $this->params->callback);
	}

}