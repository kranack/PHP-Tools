<?php

namespace Tools\File;

use Exception;

class File extends AbstractFile
{

	public function getContent() : ?string
	{
		if ($this->_content === null) {
			$this->_content = file_get_contents($this->path);	
		}

        if ($this->_content === false) { throw new Exception('Cannot get file content'); }

        return $this->_content;
	}

	public function setContent(string $content) : AbstractFile
	{
    	$this->_content = $content;
    	return $this;
    }
	
	public function read()
	{
		$handle = fopen($this->path, 'rb');
		$contents = fread($handle, filesize($this->path));
		fclose($handle);

		return $contents;
	}

	public function save() : AbstractFile
	{
    	file_put_contents($this->path, $this->_content);
    	return $this;
    }

}