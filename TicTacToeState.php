<?php

require_once("TTTility.php");

class TicTacToeState
{
	// members
	protected $_TurnToMove;
	protected $_Board;


	// getters and setters
	public function getTurnToMove()
		{ return $this->_TurnToMove; }

	public function setTurnToMove($inTTM)
		{ $this->_TurnToMove = $inTTM; }

	public function getBoard()
		{ return $this->_Board; }

	public function setBoard($inBoard)
		{ $this->_Board = $inBoard; }

	// position getter/setter
	public function getMarkerAtPosition($inRow, $inCol)
		{ return $this->_Board[$inRow][$inCol]; }

	public function setMarkerAtPosition($inMarker, $inRow, $inCol) {
		// verify marker
		if (($inMarker != "X") && ($inMarker != "O"))
			{ throw new Exception("Invalid marker '$inMarker'"); }

		// verify row
		if (($inRow < 0) || ($inRow > 2))
			{ throw new Exception("Invalid row '$inRow'"); }

		// verify column
		if (($inCol < 0) || ($inCol > 2))
			{ throw new Exception("Invalid column '$inCol'"); }
		
		// verify free
		if ($this->_Board[$inRow][$inCol] != "")
			{ throw new Exception("Position ($inRow, $inCol) already occupied..."); }

		$this->_Board[$inRow][$inCol] = $inMarker;
		$this->switchTurnToMove();
		$this->validate();
	}

	public function switchTurnToMove() {
		if ($this->getTurnToMove() == "X")
			{ $this->setTurnToMove("O"); }
		else
			{ $this->setTurnToMove("X"); }
	}


	// constructor
	public function __construct($inTurnToMove = "X",
		$inBoard = [["","",""],["","",""],["","",""]]
	) {
		$this->setTurnToMove($inTurnToMove);
		$this->setBoard($inBoard);
		$this->validate();
	}


	// display
	public function display() {
		$this->validate();
		foreach ($this->_Board as $aRow) {
			foreach ($aRow as $aValue) {
				if (!$aValue) { $aValue = " "; }
				print "[$aValue]";
			}
			print "\n";
		}

		switch ($this->getResult()) {
			case "X":
				print "X wins!\n";
				break;

			case "O":
				print "O wins!\n";
				break;

			default:
				print $this->_TurnToMove . " to move...\n";
				break;
		}
	}


	// Look for tricksy hobbitses
	public function validate() {
		$numX = 0;
		$numO = 0;

		// Count the markers, failing on something foreign
		foreach ($this->_Board as $aRow) {
			foreach ($aRow as $aValue) {
				if (($aValue != "X") && ($aValue != "O") && ($aValue != ""))
					{ throw new Exception("Invalid marker '$aValue' on board..."); }

				if ($aValue == "X") { $numX++; }
				if ($aValue == "O") { $numO++; }
			}
		}

		// X has too many pieces
		if ($numX > $numO + 2)
			{ throw new Exception("X has too many markers on board..."); }

		if (($numX > $numO) && ($this->_TurnToMove == "X"))
			{ throw new Exception("X has too many markers on board..."); }

		// O has too many pieces
		if ($numO > $numX)
			{ throw new Exception("O has too many markers on board..."); }

		if (($numX == $numO) && ($this->_TurnToMove == "O"))
			{ throw new Exception("O has too many markers on board..."); }

		// everything's fine
		return true;
	}


	public function getResult() {
		foreach (["X", "O"] as $aMarker) {
			foreach ([0, 1, 2] as $aRow) {
				if (TTTility::hasHorizontalWin($aMarker, $aRow, $this))
					{ return $aMarker; }
			}

			foreach ([0, 1, 2] as $aCol) {
				if (TTTility::hasVerticalWin($aMarker, $aCol, $this))
					{ return $aMarker; }
			}

			if (TTTility::hasDiagonalWin($aMarker, $this))
				{ return $aMarker; }
		}

		if (TTTility::hasFullBoard($this))
			{ return "T"; }
		else
			{ return "I"; }
	}
}
