<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Tools\Shell\Command\HelpCommand;

class HelpCommandTest extends TestCase
{

	public function testCreate()
	{
		$command = new HelpCommand();

		$this->assertEquals('help', $command->getName());
		$this->assertNotEquals('', $command->getDescription());
		$this->assertNotEmpty($command->getAlias());
		$this->assertNotNull($command->getBehavior());
	}

	/**
	 * @dataProvider shouldMatchProvider
	 */
	public function testShouldMatch($command, $name)
	{
		$this->assertInstanceOf(HelpCommand::class, $command);
		$this->assertTrue($command->match($name));
	}

	/**
	 * @dataProvider shouldNotMatchProvider
	 */
	public function testShouldNotMatch($command, $name)
	{
		$this->assertInstanceOf(HelpCommand::class, $command);
		$this->assertFalse($command->match($name));
	}

	public function shouldMatchProvider()
    {
        return [
			'Is the name'   		=> [new HelpCommand(), 'help'],
			'Is in the aliases'   	=> [new HelpCommand(), 'h']
        ];
	}
	
	public function shouldNotMatchProvider()
    {
        return [
			'Is not the name'   		=> [new HelpCommand(), 'test'],
			'Is not in the aliases'   	=> [new HelpCommand(), 't']
        ];
    }

}