<?php

/* This is a utility class for the TicTacToeState class
 * While these functions could easily be part of the class itself, we've
 * created this grab bag to support the semantic idea that these functions
 * can be used to simplify bot creation.
 */

class TTTility {
	///////////////////////////////////////////////////////////
	// Helper Functions That Play No Role In Decision Making //
	///////////////////////////////////////////////////////////
	static public function hasEmptyBoard($inState) {
		for ($r = 0; $r < 3; $r++) {
			for ($c = 0; $c < 3; $c++) {
				if ($inState->getBoard()[$r][$c] != "")
					{ return false; }
			}
		}
		return true;
	}

	static public function hasFullBoard($inState) {
		for ($r = 0; $r < 3; $r++) {
			for ($c = 0; $c < 3; $c++) {
				if ($inState->getBoard()[$r][$c] == "")
					{ return false; }
			}
		}
		return true;
	}

	static public function hasHorizontalWin($inMarker, $inRow, $inState) {
		for ($col = 0; $col < 3; $col++) {
			if ($inState->getBoard()[$inRow][$col] != $inMarker)
				{ return false; }
		}
		return true;
	}

	static public function hasVerticalWin($inMarker, $inCol, $inState) {
		for ($row = 0; $row < 3; $row++) {
			if ($inState->getBoard()[$row][$inCol] != $inMarker)
				{ return false; }
		}
		return true;
	}

	static public function hasDiagonalWin($inMarker, $inState) {
		if (
			($inState->getBoard()[0][0] == $inMarker) &&
			($inState->getBoard()[1][1] == $inMarker) &&
			($inState->getBoard()[2][2] == $inMarker)
		)
			{ return true; }

		if (
			($inState->getBoard()[0][2] == $inMarker) &&
			($inState->getBoard()[1][1] == $inMarker) &&
			($inState->getBoard()[2][0] == $inMarker)
		)
			{ return true; }

		return false;
	}

	// Isolates the method by which we get the strats
	static public function getStrats() {
		$class = new ReflectionClass('TTTility');
		$functionList = $class->getMethods();
		$return = [];
		foreach ($functionList as $function) {
			if (preg_match('/find/', $function->getName())) {
				$return[] = str_replace("'", "", $function->getName());
			}
		}
		return $return;
	}

	// The number of strats is also useful
	static public function getStratsCount() { return count(self::getStrats()); }

	// Run the function from the bingo ball
	static public function executeByNumber($inNumber, $inMarker, $inState, $inGuidance = null) {
		$stratList = self::getStrats();
		if ($inNumber >= count($stratList)) { return false; }
		return $stratList[$inNumber]($inMarker, $inState, $inGuidance);
	}

	static public function executeByName($inName, $inMarker, $inState, $inGuidance = null) {
		$funcName = "self::find" . $inName;
		if (is_callable($funcName)) {
			return $funcName($inName, $inMarker, $inState, $inGuidance);
		}
	}

	// This is the section for strategies
	// They are ordered by definition, so if you switch the order you will
	// break any existing encoded bots.
	//
	// To add to this list, just create a function and make sure it starts
	// with "find".
	static public function findRandomFree($inMarker, $inState, $inGuidance = null) {
		if (self::hasFullBoard($inState)) { return null; }

		while (1) {
			$myRow = rand(0, 2);
			$myCol = rand(0, 2);
			if ($inState->getBoard()[$myRow][$myCol] == "")
			{
				return [
					"row" => $myRow,
					"col" => $myCol,
					"marker" => $inMarker
				];
			}
		}
	}

	static public function findRandomFreeCorner($inMarker, $inState, $inGuidance = null) {
		$validSquareList = [];
		foreach ([0,2] as $aRow) {
			foreach ([0,2] as $aCol) {
				if ($inState->getMarkerAtPosition($aRow,$aCol) == "") {
					$validSquareList[] = [
						"row" => $aRow,
						"col" => $aCol,
						"marker" => $inMarker
					];
				}
			}
		}
		if (!$validSquareList) { return null; }
		return $validSquareList[rand(0, sizeof($validSquareList) - 1)];
	}

	static public function findFirstLossBlockOpportunity($inMarker, $inState, $inGuidance = null) {
		$oppMarker = ($inMarker == "X") ? "O" : "X";
		foreach ([0, 1, 2] as $aRow) {
			foreach ([0, 1, 2] as $aCol) {
				if ($inState->getMarkerAtPosition($aRow, $aCol) == "") {
					$newState = clone($inState);
					$newState->setMarkerAtPosition($inMarker, $aRow, $aCol);
					if ($newState->getResult() != $inMarker) {
						$oppWinningMove =
							TTTility::findFirstWinOpportunity($oppMarker, $newState);
						if ($oppWinningMove) { return $oppWinningMove; }
					}
				}
			}
		}
		return null;
	}

	static public function findFirstWinOpportunity($inMarker, $inState, $inGuidance = null) {
		foreach ([0, 1, 2] as $aRow) {
			foreach ([0, 1, 2] as $aCol) {
				$newState = clone($inState);
				if ($newState->getMarkerAtPosition($aRow, $aCol) == "") {
					$newState->setMarkerAtPosition($inMarker, $aRow, $aCol);
					if ($newState->getResult() == $inMarker) {
						return [
							"row" => $aRow,
							"col" => $aCol,
							"marker" => $inMarker
					];}
				}
			}
		}
		return null;
	}

	// If the requested square (as given in guidance) is open, take it
	static public function findPreferredPosition($inMarker, $inState, $inGuidance = [1,1]) {
		if ($inState->getMarkerAtPosition($inGuidance[0], $inGuidance[1]) == "") {
			return [
				"row" => $inGuidance[0],
				"col" => $inGuidance[1],
				"marker" => $inMarker
			];
		}
		return null;
	}
}
