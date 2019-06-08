<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Tools\Console\Console;

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