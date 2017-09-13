<?php

namespace Exec;

class Params {

	private $datas = null;

	public function __construct() {
		$this->datas = (object) [];

		if (func_num_args() > 0) {
			$this->parseArgs(func_get_args());
		}
	}

	public function __set($name, $value) { $this->datas->{$name} = $value; }

	public function __get($name) { return isset($this->datas->{$name}) ? $this->datas->{$name} : null; }

	private function parseArgs($args) {
		foreach ($args as $key => $arg) {
			if (is_array($arg)) { $this->parseArgs($arg); }
			else if (is_object($arg) && $arg->key && $arg->value) { $this->datas->{$arg->key} = $arg->value; }
			else { $this->datas->{$key} = $arg; }
		}
	}

}
