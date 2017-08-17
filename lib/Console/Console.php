<?php

namespace Console;

//require_once("lib/Console/Writer.php");
//require_once("lib/Console/Reader.php");
//require_once("lib/Utils/String.php");

use Utils\StringUtils;
use Exception;

class Console {

    private $_writer;
    private $_reader;

    private $argc;
    private $argv;

    private $opts;
    private $requiredParams;
    private $usage;

    public function __construct($argc, $argv) {
        $this->argc = $argc;
        $this->argv = $argv;
        $this->opts = [];

        $this->requiredParams = 0;
        $this->usage = null;
        $this->_writer = new Writer();
        //$this->_reader = new Reader();
    }

    public function setUsage($usageStr) { $this->usage = $usageStr; }
    public function setRequiredParams($required) { $this->requiredParams = $required; }

    public function usage() {
        if ($this->usage) { $this->print($this->usage); }
    }
    public function getOptions($optionsStruct) {
        if (!is_object($optionsStruct) || !isset($optionsStruct->shortOpts) || !isset($optionsStruct->longOpts)) { return $this->opts; }

        if (strpos("h", $optionsStruct->shortOpts) === false && !in_array("help", $optionsStruct->longOpts)) {
            $optionsStruct->shortOpts .= "h";
            $optionsStruct->longOpts [] = "help";
        }

        $this->opts = getopt($optionsStruct->shortOpts, $optionsStruct->longOpts);

        return $this->opts;
    }
    public function print($message, $dump = false) {
        if ($dump) {
            ob_start();
            var_dump($message);
            $_message = ob_get_clean();
        } else { $_message = print_r($message, true); }

        $this->_writer->printLine($_message);
    }
    public function help() { $this->stop(0); }
    public function stop($code = 0) { exit($code); }
    public function exec($optsStruct, $callback) {
        list($args, $opts) = $this->checkArguments($optsStruct);

        try {
            call_user_func_array($callback, [$args, $opts]);
        } catch(Exception $e) { $this->throwError($e); }
    }

    private function throwError(Exception $exception) {
        $this->print($exception->getMessage());
        $this->stop($exception->getCode());
    }

    private function checkArguments($optsStruct) {
        list($args, $opts) = $this->parseArguments();
        $opts = $this->getOptions($optsStruct);

        if (array_key_exists("h", $opts) || array_key_exists("help", $opts)) { $this->usage(); $this->help(); }

        if (count($args) === 0 || ($this->requiredParams && count($args)) < $this->requiredParams) {
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
