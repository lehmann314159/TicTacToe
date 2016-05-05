<?php

require_once("TicTacToeState.php");

class TTTilityTest extends PHPUnit_Framework_TestCase {

	// Empty Board Detection
	public function testEmptyBoard() {
		$emptyBoard = new TicTacToeState();
		$otherBoard = new TicTacToeState("O", [["","",""],["","X",""],["","",""]]);

		$this->assertTrue( TTTility::hasEmptyBoard($emptyBoard));
		$this->assertFalse(TTTility::hasEmptyBoard($otherBoard));
	}
	// Full Board Detection
	public function testFullBoard() {
		$fullBoard  = new TicTacToeState("O", [["X","O","X"],["X","X","O"],["O","X","O"]]);
		$otherBoard = new TicTacToeState("O", [["","",""],["","X",""],["","",""]]);

		$this->assertTrue( TTTility::hasFullBoard($fullBoard));
		$this->assertFalse(TTTility::hasFullBoard($otherBoard));
	}

	// Horizontal Win Detection
	public function testHorizontalWin() {
		$xBoard  = new TicTacToeState("O", [["X","X","X"],["O","O",""],["","",""]]);
		$oBoard  = new TicTacToeState("X", [["X","X",""],["O","O","O"],["X","",""]]);
		$noBoard = new TicTacToeState("X", [["","",""],["","",""],["","",""]]);

		$this->assertTrue( TTTility::hasHorizontalWin("X", 0, $xBoard));
		$this->assertFalse(TTTility::hasHorizontalWin("X", 1, $xBoard));
		$this->assertFalse(TTTility::hasHorizontalWin("O", 0, $oBoard));
		$this->assertTrue( TTTility::hasHorizontalWin("O", 1, $oBoard));
		$this->assertFalse(TTTility::hasHorizontalWin("X", 0, $noBoard));
	}

	// Vertical Win Detection
	public function testVerticalWin() {
		$xBoard  = new TicTacToeState("O",[["X","O",""],["X","O",""],["X","",""]]);
		$oBoard  = new TicTacToeState("X",[["O","X",""],["O","X",""],["O","X",""]]);
		$noBoard = new TicTacToeState("X",[["","",""],["","",""],["","",""]]);

		$this->assertTrue( TTTility::hasVerticalWin("X", 0, $xBoard));
		$this->assertFalse(TTTility::hasVerticalWin("X", 1, $xBoard));
		$this->assertTrue( TTTility::hasVerticalWin("O", 0, $oBoard));
		$this->assertFalse(TTTility::hasVerticalWin("O", 1, $oBoard));
		$this->assertFalse(TTTility::hasVerticalWin("X", 0, $noBoard));
	}

	// Diagonal Win Detection
	public function testDiagonalWin() {
		$winBoard = new TicTacToeState("O",
			[["X", "O", "O"], ["", "X", ""], ["", "", "X"]]);
		$emptyBoard = new TicTacToeState();

		$this->assertTrue( TTTility::hasDiagonalWin("X", $winBoard));
		$this->assertFalse(TTTility::hasDiagonalWin("X", $emptyBoard));
	}

	// strat function check
	public function testGetStrats() {
		$this->assertTrue( in_array('findRandomFree', TTTility::getStrats()));
		$this->assertFalse(in_array('findBAMBAMFree', TTTility::getStrats()));
	}

	// findRandomFree
	public function testFindFirstRandomFree() {
		$myBoard = new TicTacToeState();
		$myMove = TTTility::findRandomFree("X", $myBoard);
		$this->assertTrue(
			$myMove["row"] >= 0 &&
			$myMove["row"] <= 2 &&
			$myMove["col"] >= 0 &&
			$myMove["col"] <= 2
		);

		$myBoard = new TicTacToeState("X", [
			["X", "O", "X"], ["X", "X", "O"], ["O", "", "O"]
		]);
		$myMove = TTTility::findRandomFree("X", $myBoard);
		$this->assertTrue(($myMove["row"] == 2) && ($myMove["col"] == 1));
	}

	// findRandomFreeCorner
	public function testFindRandomFreeCorner() {
		$myBoard = new TicTacToeState();
		$myMove = TTTility::findRandomFreeCorner("X", $myBoard);
		$this->assertTrue(($myMove["row"] != 1) && ($myMove["col"] != 1));
	}

	// findFirstLossBlockOportunity
	public function testFindFirstLossBlockOpportunity() {
		$myBoard = new TicTacToeState("O", [
			["X", "O", ""], ["X", "", ""], ["", "", ""]
		]);
		$myMove = TTTility::findFirstLossBlockOpportunity("O", $myBoard);
		$this->assertTrue(($myMove["row"] == 2) && ($myMove["col"] == 0));

		$myMove = TTTility::findFirstLossBlockOpportunity("X", new TicTacToeState());
		$this->assertEquals(null, $myMove);
	}

	// findFirstWinOpportunity
	public function testFindFirstWinOpportunity() {
		$myBoard = new TicTacToeState("X", [
			["X", "O", ""], ["X", "O", ""], ["", "", ""]
		]);
		$myMove = TTTility::findFirstWinOpportunity("X", $myBoard);
		$this->assertTrue(($myMove["row"] == 2) && ($myMove["col"] == 0));

		$myMove = TTTility::findFirstWinOpportunity("X", new TicTacToeState());
		$this->assertEquals(null, $myMove);
	}

	//findPreferredPosition
	public function testFindPreferredPosition() {
		$myBoard = new TicTacToeState();
		$myMove = TTTility::findPreferredPosition("X", $myBoard, [1, 1]);
		$this->assertTrue($myMove["row"]    == "1");
		$this->assertTrue($myMove["col"]    == "1");
		$this->assertTrue($myMove["marker"] == "X");

		$myBoard = new TicTacToeState("O", [["", "", ""], ["", "X", ""], ["", "", ""]]);
		$myMove = TTTility::findPreferredPosition("O", $myBoard, [1, 1]);
		$this->assertEquals($myMove, null);
	}
}
