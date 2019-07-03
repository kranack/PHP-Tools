<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream,
	org\bovigo\vfs\vfsStreamDirectory;

use Tools\Console\Writer;
use Tools\Console\ChannelType;

class WriterTest extends TestCase
{

     /**
     * @var vfsStreamDirectory
     */
    private $dir;
    
	public function setUp() : void
	{
        $this->dir = vfsStream::setup('testDir');

        vfsStream::newFile('out', 666)->at($this->dir);
        vfsStream::newFile('err', 666)->at($this->dir);
    }

    public function testWriteStdOut()
    {
        $out = fopen(vfsStream::url('testDir/out'), 'a');
        $err = fopen(vfsStream::url('testDir/err'), 'a');

        $writer = new Writer($out, $err);

        $writer->print('stdOut message');

        fclose($out);
        fclose($err);

        $this->assertNotNull($this->dir->getChild('testDir/out')->getContent());
        $this->assertEquals(
            'stdOut message',
            $this->dir->getChild('testDir/out')->getContent()
        );
        $this->assertNull($this->dir->getChild('testDir/err')->getContent());
    }

    public function testWriteStdErr()
    {
        $out = fopen(vfsStream::url('testDir/out'), 'a');
        $err = fopen(vfsStream::url('testDir/err'), 'a');

        $writer = new Writer($out, $err);

        $writer->print('stdErr message', ChannelType::STDERR);

        fclose($out);
        fclose($err);

        $this->assertNotNull($this->dir->getChild('testDir/err')->getContent());
        $this->assertEquals(
            'stdErr message',
            $this->dir->getChild('testDir/err')->getContent()
        );
        $this->assertNull($this->dir->getChild('testDir/out')->getContent());
    }

    public function testWriteLineStdOut()
    {
        $out = fopen(vfsStream::url('testDir/out'), 'a');
        $err = fopen(vfsStream::url('testDir/err'), 'a');

        $writer = new Writer($out, $err);

        $writer->printLine('stdOut message');

        fclose($out);
        fclose($err);

        $this->assertNotNull($this->dir->getChild('testDir/out')->getContent());
        $this->assertEquals(
            "stdOut message\n",
            $this->dir->getChild('testDir/out')->getContent()
        );
        $this->assertNull($this->dir->getChild('testDir/err')->getContent());
    }

    public function testWriteLineStdErr()
    {
        $out = fopen(vfsStream::url('testDir/out'), 'a');
        $err = fopen(vfsStream::url('testDir/err'), 'a');

        $writer = new Writer($out, $err);

        $writer->printLine('stdErr message', ChannelType::STDERR);

        fclose($out);
        fclose($err);

        $this->assertNotNull($this->dir->getChild('testDir/err')->getContent());
        $this->assertEquals(
            "stdErr message\n",
            $this->dir->getChild('testDir/err')->getContent()
        );
        $this->assertNull($this->dir->getChild('testDir/out')->getContent());
    }

}