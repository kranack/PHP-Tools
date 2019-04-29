<?php

namespace Tools\Console;

use Exception;

class Reader {
	
	private $_stdin;

	public function __construct() {
		$this->_stdin = STDIN;
	}

	public function get() {
		return fgets($this->_stdin);
	}

	public function getLine() {
		return trim(fgets($this->_stdin));
	}

	public function listen() {
		$line = $this->getLine();
		/*if ($line === "quit" || $line === "q") {
			throw new Exception("User aborted");
		}*/
		return $line;
	}

}
