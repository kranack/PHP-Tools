<?php

namespace Tools\Console;

use Tools\Utils\StringUtils;
use Tools\File\File;
use Exception;

class Console {

	/**
	 * Writer
	 *
	 * @var Writer
	 */
	private $_writer;
	
	/**
	 * Reader
	 *
	 * @var Reader
	 */
    private $_reader;

	/**
	 * Arguments count
	 *
	 * @var int
	 */
	private $argc;

	/**
	 * Arguments
	 *
	 * @var array
	 */
    private $argv;

    private $opts;
    private $requiredParams;
    private $isInteractive;
    private $itCallback;
    private $helpCallback;
    private $usage;

	public function __construct(int $argc, array $argv)
	{
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

    public function setUsage(?string $usageStr) : void { $this->usage = $usageStr; }
    public function setHelp(?callable $helpCallback) : void { $this->helpCallback = $helpCallback; }
    public function setRequiredParams($required) : void { $this->requiredParams = $required; }
    public function setInteractive(?callable $itCallback) : void { $this->isInteractive = true; $this->itCallback = $itCallback; }
    public function isInteractive() : bool { return $this->isInteractive; }

	public function usage() : void
	{
        if ($this->usage) { $this->print($this->usage); }
    }
	public function getOptions($optionsStruct)
	{
        if (!is_object($optionsStruct) || !isset($optionsStruct->shortOpts) || !isset($optionsStruct->longOpts)) { return $this->opts; }

		if ((strlen($optionsStruct->shortOpts) === 0 || strpos('h', $optionsStruct->shortOpts) === false)
		   	&& !in_array('help', $optionsStruct->longOpts)) {
            $optionsStruct->shortOpts .= 'h';
            $optionsStruct->longOpts [] = 'help';
        }

        $this->opts = getopt($optionsStruct->shortOpts, $optionsStruct->longOpts);

        return $this->opts;
    }
	public function print(string $message, bool $dump = false) : void
	{
        $message = htmlspecialchars($message);
        
        if ($dump) {
            ob_start();
            var_dump($message);
            $_message = ob_get_clean();
        } else { $_message = print_r($message, true); }

        $this->_writer->printLine($_message);
    }
	public function ask(string $message)
	{
        if (substr($message, -1) !== ' ') { $message .= ' '; }
        $this->_writer->print($message);
        return $this->_reader->listen();
    }
	public function save(string $data, string $filePath) : void
	{
        $file = new File($filePath, true);
        $file->setContent($data)->save();
    }
    public function help() : void { ($this->helpCallback) ? $this->call($this->helpCallback) : $this->stop(0); }
    public function stop(int $code = 0) : void { exit($code); }
	public function exec($optsStruct, callable $callback) : void
	{
        list($args, $opts) = $this->checkArguments($optsStruct);

        try {
            if ($this->isInteractive && $this->itCallback) { $this->call($this->itCallback, [$args, $opts]); }
            
            $this->call($callback, [$args, $opts]);
        } catch(Exception $e) { $this->throwError($e); }
    }

	private function call(callable $callback, array $args = []) : void
	{
        $args [] = $this;
        call_user_func_array($callback, $args);
    }

	private function throwError(Exception $exception) : void
	{
        $this->print($exception->getMessage());
        $this->stop($exception->getCode());
    }

	private function checkArguments($optsStruct) : array
	{
        list($args, $opts) = $this->parseArguments();
        $opts = $this->getOptions($optsStruct);
        if (array_key_exists('h', $opts) || array_key_exists('help', $opts)) { $this->usage(); $this->help(); }

        if (count($args) < $this->requiredParams) {
            $this->throwError(new Exception('Parametre incorrect'));
        }

        return [ $args, $opts ];
    }

	private function parseArguments() : array
	{
        $args = [];
        $opts = [];
        for($i=1; $i<$this->argc; $i++) {
            $arg = $this->argv[$i];
            if (StringUtils::startsWith($arg, '-')) { $opts[] = $arg; }
            else { $args[] = $arg; }
        }

        return [ $args, $opts ];
    }

}
