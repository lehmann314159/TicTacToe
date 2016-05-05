<?php

require_once("AbstractBot.php");

class Primitive2Bot extends AbstractBot {
	public function makeMove($inState) {
		$priorityList = [
			"FirstWinOpportunity",
			"FirstLossBlockOpportunity",
			"PreferredPosition",
			"RandomFreeCorner",
			"RandomFree"
		];

		foreach ($priorityList as $aPriority) {
			if ($cMove = TTTility::executeByName($aPriority, $this->getSide(), $inState)) {
				return $cMove;
			}
		}
	}
}
