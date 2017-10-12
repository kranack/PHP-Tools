<?php
declare(strict_types=1);

require_once("lib/autoload.php");
require_once("vendor/autoload.php");

use Console\Reader;
use PHPUnit\Framework\TestCase;

class ReaderTest extends TestCase
{

    public function testGetLine()
    {
        $reader = $this->getMockBuilder(Reader::class)
                    ->setMockClassName("Reader")
                    ->setMethods(['getLine'])
                    ->disableOriginalConstructor()
                    ->getMock();

        $reader->expects($this->once())
            ->method('getLine')
            ->willReturn('inputData');

        $input = $reader->listen();

        $this->assertNotNull($input);
        $this->assertEquals($input, 'inputData');
    }

    public function testGetLineFail()
    {
        $reader = $this->getMockBuilder(Reader::class)
                    ->setMockClassName("Reader")
                    ->setMethods(['getLine'])
                    ->disableOriginalConstructor()
                    ->getMock();

        $reader->expects($this->once())
            ->method('getLine')
            ->willReturn(' ');

        $input = $reader->listen();

        $this->assertNotNull($input);
        $this->assertNotEquals($input, 'inputData');
    }

}