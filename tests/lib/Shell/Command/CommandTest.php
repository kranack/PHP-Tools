<?php
declare(strict_types=1);

require_once("vendor/autoload.php");

use Tools\Shell\Command\Command;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{

	public function testCreate()
	{
		$command = new Command('test');

		$this->assertEquals('test', $command->getName());
		$this->assertEquals('', $command->getDescription());
		$this->assertEmpty($command->getAlias());
		$this->assertNull($command->getBehavior());
	}

	public function testCreateWithArgs()
	{
		$callable = function() { return 'This is callable function return'; };
		$command = new Command('test', [ 't' ], 'This is a test command', $callable);

		$this->assertEquals('test', $command->getName());
		$this->assertEquals('This is a test command', $command->getDescription());
		$this->assertNotEmpty($command->getAlias());
		$this->assertCount(1, $command->getAlias());
		$this->assertNotNull($command->getBehavior());
	}

	/**
	 * @dataProvider shouldMatchProvider
	 */
	public function testShouldMatch($command, $name)
	{
		$this->assertInstanceOf(Command::class, $command);
		$this->assertTrue($command->match($name));
	}

	/**
	 * @dataProvider shouldNotMatchProvider
	 */
	public function testShouldNotMatch($command, $name)
	{
		$this->assertInstanceOf(Command::class, $command);
		$this->assertFalse($command->match($name));
	}

	public function shouldMatchProvider()
    {
        return [
			'Is the name'   		=> [new Command('test'), 'test'],
			'Is in the aliases'   	=> [new Command('test', [ 't' ]), 't']
        ];
	}
	
	public function shouldNotMatchProvider()
    {
        return [
			'Is not the name'   		=> [new Command('test'), 'TEST'],
			'Is not in the aliases'   	=> [new Command('test', [ 't' ]), 'T']
        ];
    }

}