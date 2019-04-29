<?php

namespace Tools\Console;

abstract class ChannelType {
	const STDOUT = 0;
	const STDERR = 1;
}

class Writer {
	
	private $_stdout;
	private $_stderr;

	public function __construct($stdout = null, $stderr = null) {
		$this->_stdout = ($stdout) ? $stdout : STDOUT;
		$this->_stderr = ($stderr) ? $stderr : STDERR;
	}

	public function print($message, $channel = ChannelType::STDOUT) {
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

	public function printLine($message, $channel = ChannelType::STDOUT) {
		$this->print($message . "\n", $channel);
	}

	private function writeStdout($message) {
		fwrite($this->_stdout, $message);
	}

	private function writeStderr($message) {
		fwrite($this->_stderr, $message);
	}
}