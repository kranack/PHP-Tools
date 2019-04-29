<?php
declare(strict_types=1);

require_once("vendor/autoload.php");

use Tools\Shell\Shell;
use Tools\Shell\Command\ExitCommand;
use PHPUnit\Framework\TestCase;

class ExitCommandTest extends TestCase
{

	public function testCreate()
	{
		$shell = new Shell([]);
		$command = new ExitCommand($shell);

		$this->assertEquals('exit', $command->getName());
		$this->assertNotEquals('', $command->getDescription());
		$this->assertNotEmpty($command->getAlias());
		$this->assertNotNull($command->getBehavior());
	}

	/**
	 * @dataProvider shouldMatchProvider
	 */
	public function testShouldMatch($command, $name)
	{
		$this->assertInstanceOf(ExitCommand::class, $command);
		$this->assertTrue($command->match($name));
	}

	/**
	 * @dataProvider shouldNotMatchProvider
	 */
	public function testShouldNotMatch($command, $name)
	{
		$this->assertInstanceOf(ExitCommand::class, $command);
		$this->assertFalse($command->match($name));
	}

	public function shouldMatchProvider()
    {
		$shell = new Shell([]);

        return [
			'Is the name'   			=> [$shell->getCommands()[1], 'exit'],
			'Is in the aliases'   		=> [$shell->getCommands()[1], 'quit'],
			'Is in the aliases too'   	=> [$shell->getCommands()[1], 'q']
        ];
	}
	
	public function shouldNotMatchProvider()
    {
		$shell = new Shell([]);

        return [
			'Is not the name'   		=> [$shell->getCommands()[1], 'test'],
			'Is not in the aliases'   	=> [$shell->getCommands()[1], 't']
        ];
    }

}