<?php

require_once("AbstractBot.php");
require_once("TTTility.php");

class DNABot extends AbstractBot {
	// The base is the part of the DNA Bot that we accept as common
	private $_Base;

	// getter
	public function getBase() {
		return $this->_Base;
	}

	// setter
	public function setBase($inBase) {
		$this->_Base = $inBase;
		$this->generateTrial();
	}

	// This adds a new random strat to the end of the base
	// useful when evolving
	public function extendBase() {
		$initialBaseSize = count($this->getBase());
		while (count($this->getBase()) == $initialBaseSize) {
			$rand = rand(0, TTTility::getStratsCount() - 1);
			if (in_array($rand, $this->getBase())) { continue; }
			$this->_Base[] = $rand;
		}
		$this->generateTrial();
	}

	// The trial is the bit that we're trying out
	private $_Trial;

	// getter
	public function getTrial() {
		return $this->_Trial;
	}

	// setter
	public function setTrial($inTrial) {
		$this->_Trial = $inTrial;
	}

	// this fills out the experimental part
	public function generateTrial() {
		$this->_Trial = [];
		while (count($this->getStrand()) < TTTility::getStratsCount()) {
			$rand = rand(0, TTTility::getStratsCount() - 1);
			if (in_array($rand, $this->getStrand())) { continue; }
			$this->_Trial[] = $rand;
		}
	}


	// The strand is the whole thing
	public function getStrand() {
		$ted = $this->getBase();
		return array_merge($ted, $this->getTrial());
	}


	// constructor
	public function __construct($inSide, $inBase = [], $inDoExtend = false ) {
		parent::__construct($inSide);
		$this->setBase($inBase);
		$this->setTrial([]);
		if ($inDoExtend) { $this->extendBase(); }
		$this->generateTrial();
	}


	public function makeMove($inState) {
		foreach ($this->getStrand() as $aStrat) {
			if ($cMove = TTTility::executeByNumber($aStrat, $this->getSide(), $inState)) {
				return $cMove;
			}
		}
		// Total fallback.  This should be one of the choices above
		throw new Exception("No methods returned a valid move...");
	}
}
