<?php

namespace Console;

use Utils\StringUtils;
use File\File;
use Exception;

class Console {

    private $_writer;
    private $_reader;

    private $argc;
    private $argv;

    private $opts;
    private $requiredParams;
    private $isInteractive;
    private $itCallback;
    private $helpCallback;
    private $usage;

    public function __construct($argc, $argv) {
        $this->argc = $argc;
        $this->argv = $argv;
        $this->opts = [];

        $this->requiredParams = 0;
        $this->isInteractive = false;
        $this->itCallback = null;
        $this->usage = null;
        $this->helpCallback = null;
        $this->_writer = new Writer();
        $this->_reader = new Reader();
    }

    public function setUsage($usageStr) { $this->usage = $usageStr; }
    public function setHelp($helpCallback) { $this->helpCallback = $helpCallback; }
    public function setRequiredParams($required) { $this->requiredParams = $required; }
    public function setInteractive($itCallback) { $this->isInteractive = true; $this->itCallback = $itCallback; }
    public function isInteractive() { return $this->isInteractive; }

    public function usage() {
        if ($this->usage) { $this->print($this->usage); }
    }
    public function getOptions($optionsStruct) {
        if (!is_object($optionsStruct) || !isset($optionsStruct->shortOpts) || !isset($optionsStruct->longOpts)) { return $this->opts; }

		if ((strlen($optionsStruct->shortOpts) === 0 || strpos("h", $optionsStruct->shortOpts) === false)
		   	&& !in_array("help", $optionsStruct->longOpts)) {
            $optionsStruct->shortOpts .= "h";
            $optionsStruct->longOpts [] = "help";
        }

        $this->opts = getopt($optionsStruct->shortOpts, $optionsStruct->longOpts);

        return $this->opts;
    }
    public function print($message, $dump = false) {
        $message = htmlspecialchars($message);
        
        if ($dump) {
            ob_start();
            var_dump($message);
            $_message = ob_get_clean();
        } else { $_message = print_r($message, true); }

        $this->_writer->printLine($_message);
    }
    public function ask($message) {
        if (substr($message, -1) !== " ") { $message .= " "; }
        $this->_writer->print($message);
        return $this->_reader->listen();
    }
    public function save($data, $filePath) {
        $file = new File($filePath, true);
        $file->setContent($data)->save();
    }
    public function help() { ($this->helpCallback) ? $this->call($this->helpCallback) : $this->stop(0); }
    public function stop($code = 0) { exit($code); }
    public function exec($optsStruct, $callback) {
        list($args, $opts) = $this->checkArguments($optsStruct);

        try {
            if ($this->isInteractive && $this->itCallback) { $this->call($this->itCallback, [$args, $opts]); }
            
            $this->call($callback, [$args, $opts]);
        } catch(Exception $e) { $this->throwError($e); }
    }

    private function call($callback, $args = []) {
        $args [] = $this;
        call_user_func_array($callback, $args);
    }

    private function throwError(Exception $exception) {
        $this->print($exception->getMessage());
        $this->stop($exception->getCode());
    }

    private function checkArguments($optsStruct) {
        list($args, $opts) = $this->parseArguments();
        $opts = $this->getOptions($optsStruct);
        if (array_key_exists("h", $opts) || array_key_exists("help", $opts)) { $this->usage(); $this->help(); }

        if (count($args) < $this->requiredParams) {
            $this->throwError(new Exception("Parametre incorrect"));
        }

        return [$args, $opts];
    }

    private function parseArguments() {
        $args = [];
        $opts = [];
        for($i=1; $i<$this->argc; $i++) {
            $arg = $this->argv[$i];
            if (StringUtils::startsWith($arg, "-")) { $opts[] = $arg; }
            else { $args[] = $arg; }
        }

        return [$args, $opts];
    }

}
