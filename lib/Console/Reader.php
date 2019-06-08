<?php

namespace Tools\Console;

use Exception;

class Reader
{
	/**
	 * STDIN data
	 *
	 * @var string
	 */
	private $_stdin;

	public function __construct()
	{
		$this->_stdin = STDIN;
	}

	public function get() : string
	{
		return fgets($this->_stdin);
	}

	public function getLine() : string
	{
		return trim(fgets($this->_stdin));
	}

	public function listen() : string
	{
		$line = $this->getLine();
		/*if ($line === "quit" || $line === "q") {
			throw new Exception("User aborted");
		}*/
		return $line;
	}

}
