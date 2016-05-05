<?php

require_once("TicTacToeState.php");
require_once("BotFactory.php");

$myGame = new TicTacToeState();
$myX    = BotFactory::generateBot("DNA", "X");
$myO    = BotFactory::generateBot("DNA", "O");

$returnedMove = [];
$results["X"] = 0;
$results["O"] = 0;
$results["T"] = 0;

try {
	for ($gameCount = 1; $gameCount <= 1000; $gameCount++) {
		$myGame = new TicTacToeState();
		while ($myGame->getResult() == "I") {
			if ($myGame->getTurnToMove() == "X") {
				$returnedMove = $myX->makeMove($myGame);
				$myGame->setMarkerAtPosition("X", $returnedMove['row'], $returnedMove['col']);
			}
			else
			{
				$returnedMove = $myO->makeMove($myGame);
				$myGame->setMarkerAtPosition("O", $returnedMove['row'], $returnedMove['col']);
			}
			#$myGame->display();
			#print "\n";
		}
		$results[$myGame->getResult()]++;
	}

	print "Results...\n";
	print "\tX: " . $results["X"] . "\n";
	print "\tO: " . $results["O"] . "\n";
	print "\tT: " . $results["T"] . "\n";
} catch (Exception $e) {
	var_dump($e);
}
