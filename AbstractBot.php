<?php

// Base Class For Bots
require_once("TicTacToeState.php");

abstract class AbstractBot {
	private $_Side;

	// No setter; we insist it be assigned only during construction
	public function getSide()
		{ return $this->_Side; }

	// constructor
	public function __construct($inSide) {
		if (($inSide != "X") && ($inSide != "O"))
			{ throw new Exception("Invalid Marker..."); }
		$this->_Side = $inSide;
	}

	// What makes us special
	abstract public function makeMove($inState);
}
