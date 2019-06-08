<?php

namespace Tools\Console;

abstract class ChannelType {
	const STDOUT = 0;
	const STDERR = 1;
}

class Writer
{
	
	private $_stdout;
	private $_stderr;

	public function __construct($stdout = null, $stderr = null)
	{
		$this->_stdout = ($stdout) ? $stdout : STDOUT;
		$this->_stderr = ($stderr) ? $stderr : STDERR;
	}

	public function print(string $message, int $channel = ChannelType::STDOUT) : void
	{
		switch($channel) {
			case ChannelType::STDERR:
				$this->writeStderr($message);
				break;
			case ChannelType::STDOUT:
			default:
				$this->writeStdout($message);
				break;
		}
	}

	public function printLine(string $message, int $channel = ChannelType::STDOUT) : void
	{
		$this->print($message . "\n", $channel);
	}

	private function writeStdout(string $message) : void
	{
		fwrite($this->_stdout, $message);
	}

	private function writeStderr(string $message) : void
	{
		fwrite($this->_stderr, $message);
	}
}