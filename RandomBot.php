<?php

require_once("AbstractBot.php");

class RandomBot extends AbstractBot {
	public function makeMove($inState) {
		$myBoard = $inState->getBoard();
		while (1) {
			$myRow = rand(0, 2);
			$myCol = rand(0, 2);
			if ($myBoard[$myRow][$myCol] == "")
			{
				return [
					"row" => $myRow,
					"col" => $myCol,
					"marker" => $this->getSide()
				];
			}
		}
	}
}
