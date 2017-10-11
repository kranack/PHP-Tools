<?php
declare(strict_types=1);

require_once("lib/autoload.php");
require_once("vendor/autoload.php");

use File\File;
use JSON\JSON;
use PHPUnit\Framework\TestCase;

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
             ->willReturn(true);

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