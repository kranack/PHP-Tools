<?php

namespace Tools\Exec;

class Params
{

	/**
	 * Internal data
	 *
	 * @var object|null
	 */
	private $data;

	public function __construct()
	{
		$this->data = (object) [];

		if (func_num_args() > 0) {
			$this->parseArgs(func_get_args());
		}
	}

	public function __set($name, $value) : void { $this->data->{$name} = $value; }

	public function __get($name) { return isset($this->data->{$name}) ? $this->data->{$name} : null; }

	private function parseArgs($args) : void
	{
		foreach ($args as $key => $arg) {
			if (is_array($arg)) { $this->parseArgs($arg); }
			else if (is_object($arg) && $arg->key && $arg->value) { $this->data->{$arg->key} = $arg->value; }
			else { $this->data->{$key} = $arg; }
		}
	}

}
