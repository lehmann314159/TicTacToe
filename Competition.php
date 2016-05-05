<?php

// This class handles Tic Tac Toe matches between two bots
// and then returns the results

require_once("TicTacToeState.php");
require_once("BotFactory.php");

class Competition {
	// Bot 1
	private $_Bot1;
	public function getBot1()       { return $this->_Bot1; }
	public function setBot1($inBot) { $this->_Bot1 = $inBot; }

	// Bot 2
	private $_Bot2;
	public function getBot2()       { return $this->_Bot2; }
	public function setBot2($inBot) { $this->_Bot2 = $inBot; }

	// Result
	private $_Result;

	// constructor
	public function __construct($inBot1, $inBot2) {
		$this->setBot1($inBot1);
		$this->setBot2($inBot2);

		$this->_Result = [
			"Bot1X" => ["Bot1" => 0, "Bot2" => 0, "Tie"  => 0, "Error" => 0],
			"Bot2X" => ["Bot1" => 0, "Bot2" => 0, "Tie"  => 0, "Error" => 0],
			"State" => "not started",
		];
	}

	public function compete($inGameCount = 10000) {
		try {
			for ($i = 1; $i <= $inGameCount; $i += 2) {
				switch ($this->playGame(
					BotFactory::generateBot($this->getBot1(), "X"),
					BotFactory::generateBot($this->getBot2(), "O")
				)) {
					case "X": $this->_Result["Bot1X"]["Bot1"]++;  break;
					case "O": $this->_Result["Bot1X"]["Bot2"]++;  break;
					case "T": $this->_Result["Bot1X"]["Tie"]++;   break;
					case "E": $this->_Result["Bot1X"]["Error"]++; break;
				}
				switch ($this->playGame(
					BotFactory::generateBot($this->getBot2(), "X"),
					BotFactory::generateBot($this->getBot1(), "O")
				)) {
					case "X": $this->_Result["Bot2X"]["Bot2"]++;  break;
					case "O": $this->_Result["Bot2X"]["Bot1"]++;  break;
					case "T": $this->_Result["Bot2X"]["Tie"]++;   break;
					case "E": $this->_Result["Bot1X"]["Error"]++; break;
				}
			}
			$this->_Result["State"] = "success";
		} catch (Exception $e) {
			$this->_Result["State"] = "error - " . $e->message();
		}
		return $this->_Result;
	}

	private function playGame($inX, $inO) {
		try {
			$myGame = new TicTacToeState();
			while ($myGame->getResult() == "I") {
				if ($myGame->getTurnToMove() == "X") {
					$move = $inX->makeMove($myGame);
					$myGame->setMarkerAtPosition("X", $move['row'], $move['col']);
				}
				else
				{
					$move = $inO->makeMove($myGame);
					$myGame->setMarkerAtPosition("O", $move['row'], $move['col']);
				}
			}
		} catch (Exception $e) {
			return "E";
		}
		return $myGame->getResult();
	}
}
