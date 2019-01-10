<?php

    $AUTOLOAD_PATH = "../lib/autoload.php";

    function require_autoload($path) {
        $path = str_replace("/", DIRECTORY_SEPARATOR, $path);

        require_once($path);
    };

    require_autoload(__DIR__ . DIRECTORY_SEPARATOR . $AUTOLOAD_PATH);