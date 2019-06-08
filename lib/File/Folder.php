<?php

namespace Tools\File;

class Folder extends AbstractFile
{
	
	public function getContent() : ?string
	{
		// NYI
        return null;
	}

	public function setContent(string $content) : AbstractFile
	{
		// NYI
    	return $this;
    }
	
	public function read() : array
	{
		$files = array_map(function($file) {
			return new File($file);
		}, glob($this->getPath() . DIRECTORY_SEPARATOR . "*"));

		return $files;
	}

	public function save() : AbstractFile
	{
		// NYI
    	return $this;
    }

}