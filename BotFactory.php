<?php

require_once("AbstractBot.php");

class BotFactory {
	static public function generateBot($inType, $inSide) {
		$className = "{$inType}Bot";
		require_once("$className.php");
		if (class_exists($className))
			{ return new $className($inSide); }
		else
			{ throw new Exception("Bot of type $inType not found...\n"); }
	}
}
