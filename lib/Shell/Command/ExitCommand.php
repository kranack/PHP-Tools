<?php

namespace Shell\Command;

use Shell\Shell;

class ExitCommand extends Command {

    private $shell;

    public function __construct(Shell $shell) {
        $this->shell = $shell;
        return parent::__construct("exit", ["quit", "q"], "Exit the shell");
    }

    public function getBehavior() : ?callable {
        return function() {
            $this->shell->stop();
        };
    }

}