<?php

namespace File;

use Exception;

abstract class FileType {
	const FOLDER = 0;
	const FILE = 1;
	const LINK = 2;
}

abstract class AbstractFile {
	
	protected $path;
	protected $_content;
	protected $_type;

	public function __construct($path, $create = false) {
		$this->path = $path;
		$this->_content = null;
		$this->getType();

		if (!$create) {
			$this->exists($path);
		}
	}

	public function getPath() {
		return $this->path;
	}

    public function getType() {
    	if (is_dir($this->path)) $this->_type = FileType::FOLDER;
    	else if (is_link($this->path)) $this->_type = FileType::LINK;
    	else $this->_type = FileType::FILE;

    	return $this->_type;
    }

    public function isFile() { return $this->_type === FileType::FILE; }
    public function isFolder() { return $this->_type === FileType::FOLDER; }
    public function isLink() { return  $this->_type === FileType::LINK; }

    private function exists() {
        if (!file_exists($this->path)) {
            throw new Exception("File not found");
        }
        if (!is_readable($this->path)) {
        	throw new Exception("File not readable");
        }
    }

    abstract public function getContent();
    abstract public function setContent($content);
    
    abstract public function read();
    abstract public function save();

}