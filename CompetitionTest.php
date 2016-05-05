<?php

require_once("BotFactory.php");
require_once("Competition.php");
require_once("TicTacToeState.php");

class CompetitionTest extends PHPUnit_Framework_TestCase {

	// There's not really a ton we can do to test this
	public function testPlausibleResult() {
		$myCompetition = new Competition("Random", "Random");
		$result = $myCompetition->compete(1000);

		$this->assertTrue(array_key_exists("Bot1X", $result));
		$this->assertTrue(array_key_exists("Bot2X", $result));
		$this->assertTrue(array_key_exists("State", $result));

		$this->assertTrue(array_key_exists("Bot1",  $result["Bot1X"]));
		$this->assertTrue(array_key_exists("Bot2",  $result["Bot1X"]));
		$this->assertTrue(array_key_exists("Tie",   $result["Bot1X"]));
		$this->assertTrue(array_key_exists("Error", $result["Bot1X"]));

		$this->assertTrue(array_key_exists("Bot1",  $result["Bot2X"]));
		$this->assertTrue(array_key_exists("Bot2",  $result["Bot2X"]));
		$this->assertTrue(array_key_exists("Tie",   $result["Bot2X"]));
		$this->assertTrue(array_key_exists("Error", $result["Bot2X"]));
	}

}
