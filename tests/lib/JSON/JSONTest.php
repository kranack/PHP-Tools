<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Tools\File\File;
use Tools\JSON\JSON;

class JSONTest extends TestCase
{

    public function testUnpretty() {
        $file = $this->getMockBuilder(File::class)
                     ->setMockClassName("File")
                     ->setMethods(['getContent', 'save'])
                     ->disableOriginalConstructor()
                     ->setConstructorArgs(['test'])
                     ->getMock();

        $file->expects($this->once())
             ->method('getContent')
             ->willReturn('{}');
        
        $file->expects($this->once())
             ->method('save')
             ->willReturn($file);

        $json = new JSON($file);
        $json->unpretty();
    }

    public function testPretty() {
        $file = $this->getMockBuilder(File::class)
                     ->setMockClassName("File")
                     ->setMethods(['getContent', 'save'])
                     ->disableOriginalConstructor()
                     ->setConstructorArgs(['test'])
                     ->getMock();

        $file->expects($this->once())
             ->method('getContent')
             ->willReturn('{}');
        
        $file->expects($this->once())
             ->method('save')
             ->willReturn($file);

        $json = new JSON($file);
        $json->pretty();
    }

}