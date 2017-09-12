<?php

namespace JSON;

use File\File;
use Exception;

class JSON {

    private $_file;

    public function __construct($filename) {
        $this->_file = new File($filename);
    }

    public function unpretty() {
        $content = $this->_file->getContent();
        $_json = json_decode($content);
        $this->checkJSON($_json);
        $json = json_encode($_json);
        $this->_file->setContent($json)->save();
    }

    public function pretty() {
        $content = $this->_file->getContent();
        $_json = json_decode($content);
        $this->checkJSON($_json);
        $json = json_encode($_json, JSON_PRETTY_PRINT);
        $this->_file->setContent($json)->save();
    }

    private function checkJSON($json) {
        if ($json === null) { throw new Exception("JSON incorrect"); }
    }

}
