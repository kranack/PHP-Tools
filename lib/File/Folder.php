<?php

namespace File;

class Folder extends AbstractFile {
	
	public function getContent() {
		// NYI
        return null;
	}

	public function setContent($content) {
		// NYI
    	return $this;
    }
	
	public function read() {
		$files = array_map(function($file) {
			return new File($file);
		}, glob($this->getPath() . DIRECTORY_SEPARATOR . "*"));

		return $files;
	}

    public function save() {
		// NYI
    	return $this;
    }

}