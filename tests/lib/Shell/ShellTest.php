<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Tools\Shell\Shell;
use Tools\Shell\Command\HelpCommand;

class ShellTest extends TestCase
{

	public function testCreateWithNoCommands()
	{
		$shell = new Shell();

		$this->assertNotEmpty($shell->getCommands());
		$this->assertCount(2, $shell->getCommands());
		$this->assertTrue($shell->isRunning());
	}

	public function testCreateWithCommands()
	{
		$shell = new Shell([
			new HelpCommand()
		]);

		$this->assertNotEmpty($shell->getCommands());
		$this->assertCount(1, $shell->getCommands());
		$this->assertTrue($shell->isRunning());
	}

	public function testStop()
	{
		$shell = new Shell();

		$shell->stop();

		$this->assertFalse($shell->isRunning());
	}

}