<?php
declare(strict_types=1);

require_once("lib/autoload.php");
require_once("vendor/autoload.php");

use Exec\Params;
use Exec\Executable;
use PHPUnit\Framework\TestCase;

class ExecutableTest extends TestCase
{

    public function testRun()
    {
        $params = new Params([
            (object) [
                "key"   => "callback",
                "value" => function() {}
            ]
        ]);
        $exec = new Executable($params);

        $exec->run(0, []);
    }

}