<?php

require_once("AbstractBot.php");

class PrimitiveBot extends AbstractBot {
	public function makeMove($inState) {
		// win if I can
		#print "\ttrying to win...\n";
		$cMove = TTTility::findFirstWinOpportunity($this->getSide(), $inState);
		if ($cMove) { return $cMove; }

		// Block a loss if I can
		#print "\ttrying to avoid losing...\n";
		$cMove = TTTility::blockFirstLossOpportunity($this->getSide(), $inState);
		if ($cMove) { return $cMove; }

		// center if I can
		#print "\ttrying to play center...\n";
		if ($inState->getMarkerAtPosition(1, 1) == "")
			return ["row" => 1, "col" => 1, $this->getSide()];

		// corner if I can
		#print "\ttrying to play a corner...\n";
		if ($candMove = TTTility::findRandomFreeCorner($this->getSide(), $inState))
			{ return $candMove; }

		// random if I have to
		#print "\ttrying to play random...\n";
		return TTTility::findRandomFree($this->getSide(), $inState);
	}
}
