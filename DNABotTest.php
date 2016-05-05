<?php

require_once("BotFactory.php");
require_once("DNABot.php");
require_once("TicTacToeState.php");
require_once("TTTility.php");

class DNABotTest extends PHPUnit_Framework_TestCase {

	public function testBase() {
		$myBot = BotFactory::generateBot("DNA", "X");
		for ($i = 0; $i < TTTility::getStratsCount(); $i++) {
			$this->assertTrue(in_array($i, $myBot->getStrand()));
		}
	}

	public function testExtendBase() {
		$myBot = BotFactory::generateBot("DNA", "X");
		$myBot->setBase([0,1,2]);
		$myBot->extendBase();
		$this->assertEquals($myBot->getBase(), [0, 1, 2, 3]);
	}

	public function testgenerateTrial() {
		$myBot = BotFactory::generateBot("DNA", "X");
		$myBot->setBase([0,1,2]);	// implictly creates a trial
		$this->assertEquals($myBot->getTrial(), [3]);

		if (is_callable("TTTility::findRandomFreeCorner")) {
			print "hooray!\n";
		}
	}
}
