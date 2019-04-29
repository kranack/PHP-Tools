<?php

namespace Tools\Shell\Command;

class Command {

    private $name;

    private $aliases;

    private $description;

    private $behavior;

    public function __construct(string $name, $aliases = [], string $description = "", callable $behavior = null) {
        $this->name = $name;
        $this->aliases = $aliases;
        $this->description = $description;
        $this->behavior = $behavior;
    }

    public function getName() : string { return $this->name; }

    public function getAlias() { return $this->aliases; }

    public function getDescription() : string { return $this->description; }

    public function getBehavior() : ?callable { return $this->behavior; }

    public function match($command) {
        if ($this->name === $command) return true;

        if (is_array($this->aliases) && in_array($command, $this->aliases)) return true;
        else if (is_string($this->aliases) && $this->aliases === $command) return true;

        return false;
    }

}