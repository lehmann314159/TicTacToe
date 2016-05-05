<?php

require_once("TicTacToeState.php");

class TicTacToeStateTest extends PHPUnit_Framework_TestCase {

	// An empty board can't have O to move next
	public function testTooManyOException() {
		#print "Too many O...\n";
		$this->setExpectedException('Exception');
		$myTTTState = new TicTacToeState("O");
	}

	// One cannot have two X and no O
	public function testTooManyXException() {
		#print "Too many X...\n";
		$this->setExpectedException('Exception');
		$myTTTState = new TicTacToeState("X", [["X","X",""], ["","",""], ["","",""]]);
	}

	// No bad markers on construction
	public function testBadMarkerOnConstruction() {
		#print "Bad Marker...\n";
		$this->setExpectedException('Exception');
		$myTTTState = new TicTacToeState( "X",[["X","O","F"], ["","",""], ["","",""]]);
	}

	// Vanilla construction
	public function testValidConstruction() {
		#print "Valid Construction...\n";
		$myTTTState = new TicTacToeState("O", [["X","O","X"], ["","",""], ["","",""]]);
		$this->assertTrue($myTTTState->validate());
	}

	// Placement on full position
	public function testAlreadyFilledPosition() {
		#print "Position already occupied...\n";
		$this->setExpectedException('Exception');
		$myTTTState = new TicTacToeState( "X",[["X","O",""], ["","",""], ["","",""]]);
		$myTTTState->setMarkerAtPosition("X", 0, 0);
	}

	// Foreign marker
	public function testBadMarkerAdded() {
		#print "Bad marker added...\n";
		$this->setExpectedException('Exception');
		$myTTTState = new TicTacToeState( "X",[["X","O",""], ["","",""], ["","",""]]);
		$myTTTState->setMarkerAtPosition("F", 0, 2);
	}

	// bad row
	public function testBadRow() {
		#print "Bad row...\n";
		$this->setExpectedException('Exception');
		$myTTTState = new TicTacToeState( "X",[["X","O",""], ["","",""], ["","",""]]);
		$myTTTState->setMarkerAtPosition("X", 3, 0);
	}

	// bad col
	public function testBadColumn() {
		#print "Bad column...\n";
		$this->setExpectedException('Exception');
		$myTTTState = new TicTacToeState( "X",[["X","O",""], ["","",""], ["","",""]]);
		$myTTTState->setMarkerAtPosition("X", 0, 3);
	}

	// detect X win
	public function testXWin() {
		#print "X Wins...\n";
		$myTTTState = new TicTacToeState( "O",[["X","O",""], ["O","X",""], ["","","X"]]);
		$this->assertEquals($myTTTState->getResult(), "X");
	}

	// detect O win
	public function testOWin() {
		#print "O Wins...\n";
		$myTTTState = new TicTacToeState( "X",[["X","O",""], ["X","O",""], ["","O","X"]]);
		$this->assertEquals($myTTTState->getResult(), "O");
	}

	// detect indeterminate
	public function testNoWin() {
		#print "No winner...\n";
		$myTTTState = new TicTacToeState( "X",[["X","O",""], ["O","X",""], ["","",""]]);
		$this->assertEquals($myTTTState->getResult(), "I");
	}
}
