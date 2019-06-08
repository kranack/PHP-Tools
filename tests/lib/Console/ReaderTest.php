<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Tools\Console\Reader;

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