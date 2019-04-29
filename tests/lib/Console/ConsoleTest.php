<?php
declare(strict_types=1);

require_once("vendor/autoload.php");

use Tools\Console\Console;
use PHPUnit\Framework\TestCase;

class ConsoleTest extends TestCase
{

    /**
     * @expectedException Exception
     * @expectedExceptionMessage usage example
     */
    public function testUsage()
    {
        $console = $this->getMockBuilder(Console::class)
                     ->setMockClassName("Console")
                     ->setMethods(['print'])
                     ->setConstructorArgs([0, []])
                     ->getMock();

        $console->expects($this->once())
                ->method('print')
                ->will($this->returnCallback(function($message) {
                    throw new Exception($message);
                }));

        $this->assertFalse($console->isInteractive());
        
        $console->setUsage('usage example');
        $console->usage();
    }

}