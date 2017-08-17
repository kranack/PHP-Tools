<?php

namespace File;

abstract class FileType {
	const Folder = 0;
	const File = 1;
	const Link = 2;
}

class File {
	
	private $filename;
	private $_content;
	private $_type;

	public function __construct($filename) {
		$this->filename = $filename;
		$this->_content = null;
		$this->getType();

		$this->exists($filename);
	}

	public function getContent() {
		if ($this->_content === null) {
			$this->_content = file_get_contents($this->filename);	
		}

        if ($this->_content === false) { throw new Exception("Recup impossible"); }

        return $this->_content;
    }

    public function getType() {
    	if (is_dir($this->filename)) $this->_type = FileType::Folder;
    	else if (is_link($this->filename)) $this->_type = FileType::Link;
    	else $this->_type = FileType::File;

    	return $this->_type;
    }

    public function isFile() { return $this->_type === FileType::File; }
    public function isFolder() { return $this->_type === FileType::Folder; }
    public function isLink() { return  $this->_type === FileType::Link; }

    public function setContent($content) {
    	$this->_content = $content;
    	return $this;
    }

    public function save() {
    	file_put_contents($this->filename, $this->_content);
    	return $this;
    }

    private function exists() {
        if (!file_exists($this->filename)) {
            throw new Exception("Fichier introuvable");
        }
        if (!is_readable($this->filename)) {
        	throw new Exception("Fichier non lisible");
        }
    }

}