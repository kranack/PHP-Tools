<?php

namespace Tools\JSON;

use Exception;

use Tools\File\File;

class JSON
{

	/**
	 * File
	 *
	 * @var File
	 */
    private $_file;

	public function __construct($file)
	{
        if (!is_a($file, 'File')) {
            $file = new File($file);
		}
		
        $this->_file = $file;
    }

	public function unpretty() : void
	{
        $content = $this->_file->getContent();
		$_json = json_decode($content);
		
		$this->checkJSON($_json);
		
        $json = json_encode($_json);
        $this->_file->setContent($json)->save();
    }

	public function pretty() : void
	{
        $content = $this->_file->getContent();
        $_json = json_decode($content);
		
		$this->checkJSON($_json);
		
        $json = json_encode($_json, JSON_PRETTY_PRINT);
        $this->_file->setContent($json)->save();
    }

	private function checkJSON($json) : void
	{
        if ($json === null) { throw new Exception('JSON incorrect'); }
    }

}
