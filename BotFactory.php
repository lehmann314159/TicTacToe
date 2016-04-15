<?php

require_once("AbstractBot.php");
require_once("PrimitiveBot.php");
require_once("RandomBot.php");

class BotFactory {
	static public function generateBot($inType, $inSide) {
		$className = "{$inType}Bot";
		if (class_exists($className))
			{ return new $className($inSide); }
		else
			{ throw new Exception("Bot of type $inType not found...\n"); }
	}
}
