<?php

namespace Tools\File;

use Exception;

abstract class FileType {
	const FOLDER = 0;
	const FILE = 1;
	const LINK = 2;
}

abstract class AbstractFile {
	
	/**
	 * File path
	 *
	 * @var string
	 */
	protected $path;

	/**
	 * File content
	 *
	 * @var string|null
	 */
	protected $_content;

	/**
	 * File type
	 *
	 * @var int|null
	 */
	protected $_type;

	public function __construct(string $path, bool $create = false)
	{
		$this->path = $path;
		$this->_content = null;
		$this->getType();

		if (!$create) {
			$this->exists($path);
		}
	}

	public function getPath() : string
	{
		return $this->path;
	}

	public function getType() : int
	{
    	if (is_dir($this->path)) $this->_type = FileType::FOLDER;
    	else if (is_link($this->path)) $this->_type = FileType::LINK;
    	else $this->_type = FileType::FILE;

    	return $this->_type;
    }

    public function isFile() : bool { return $this->_type === FileType::FILE; }
    public function isFolder() : bool { return $this->_type === FileType::FOLDER; }
    public function isLink() : bool { return  $this->_type === FileType::LINK; }

	private function exists() : void
	{
        if (!file_exists($this->path)) {
            throw new Exception('File not found');
        }
        if (!is_readable($this->path)) {
        	throw new Exception('File not readable');
        }
    }

    abstract public function getContent() : ?string;
    abstract public function setContent(string $content) : AbstractFile;
    
    abstract public function read();
    abstract public function save() : AbstractFile;

}
