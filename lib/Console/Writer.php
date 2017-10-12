<?php

namespace Console;

abstract class ChannelType {
	const Stdout = 0;
	const Stderr = 1;
}

class Writer {
	
	private $_stdout;
	private $_stderr;

	public function __construct($stdout = null, $stderr = null) {
		$this->_stdout = $stdout;
		$this->_stderr = $stderr;
	}

	public function print($message, $channel = ChannelType::Stdout) {
		switch($channel) {
			case ChannelType::Stderr:
				$this->writeStderr($message);
				break;
			case ChannelType::Stdout:
			default:
				$this->writeStdout($message);
				break;
		}
	}

	public function printLine($message, $channel = ChannelType::Stdout) {
		$this->print($message . "\n", $channel);
	}

	private function writeStdout($message) {
		fwrite($this->_stdout, $message);
	}

	private function writeStderr($message) {
		fwrite($this->_stderr, $message);
	}
}