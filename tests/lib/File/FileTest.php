<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream,
	org\bovigo\vfs\vfsStreamDirectory;

use Tools\File\File;

class FileTest extends TestCase
{

    /**
     * @var vfsStreamDirectory
     */
    private $dir;

	public function setUp() : void
	{
        $this->dir = vfsStream::setup('testDir');
    }

    public function testFileExists()
    {
        $file = new File(__FILE__);

        $this->assertTrue($file->isFile());
        $this->assertFalse($file->isFolder());
        $this->assertFalse($file->isLink());
    }
	
    public function testFileNotExists()
    {
		$this->expectException('Exception');
		$this->expectExceptionMessage('File not found');

        new File("file/not/found.pdf");
    }

    public function testFileIsDir()
    {
        $file = new File(vfsStream::url('testDir'));

        $this->assertFalse($file->isFile());
        $this->assertTrue($file->isFolder());
        $this->assertFalse($file->isLink());
    }

    public function testFileCreate()
    {
        $file = new File(vfsStream::url('testDir/test.txt'), true);

        $this->assertTrue($file->isFile());
        $this->assertFalse($file->isFolder());
        $this->assertFalse($file->isLink());

        $file->setContent('TEST')->save();

        $this->assertTrue($this->dir->hasChild('testDir/test.txt'));
        $this->assertEquals(
            'TEST',
            $this->dir->getChild('testDir/test.txt')->getContent()
        );
    }

}