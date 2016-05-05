<?php

require_once("BotFactory.php");

class BotFactoryTest extends PHPUnit_Framework_TestCase {

	// Let's make sure we can generate the bots
	public function testGenerateGoodBot() {
		$myBot = BotFactory::generateBot("Random", "X");
		$this->assertEquals(get_class($myBot), "RandomBot");
	}

	public function testGenerateBadBot() {
		$this->setExpectedException('Exception');
		$myBot = BotFactory::generateBot("ThisBotShouldNotExist", "X");
	}
}
