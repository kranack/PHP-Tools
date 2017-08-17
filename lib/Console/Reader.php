<?php

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

}