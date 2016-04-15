<?php

/* This is a utility class for the TicTacToeState class
 * While these functions could easily be part of the class itself, we've
 * created this grab bag to support the semantic idea that these functions
 * can be used to simplify bot creation.
 */

class TTTility {
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

	static public function findRandomFreeCorner($inMarker, $inState) {
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

	static public function findRandomFree($inMarker, $inState) {
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

	static public function findFirstWinOpportunity($inMarker, $inState) {
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

	static public function blockFirstLossOpportunity($inMarker, $inState) {
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
}
