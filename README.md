# TicTacToe

This is a Tic Tac Toe Bot Framework, created as a portfolio piece.  It
features the following:

* Exceptions
* Unit Tests
* Factory Pattern
* Polymorphic methods
* Reflection and dynamic class loading

Description of Files:

TicTacToeState.php
This class abstracts the idea of a Tic Tac Toe game.  It tracks whose
turn it is to move, ensures that a given board is valid, and gives out
state information about itself.
This class has unit tests.

TTTility.php
This is a helper class that supplies functions useful for bots as well as
TicTacToeStates.  It detects when a board is empty, full, and in a win state.
It also holds all strategems as well as methods for accessing them.
This class has unit tests.

BotFactory.php
This generates out bots.  In particular it makes sure that the named bot type
has a class file and then attempts to create and return a bot of that class.
This class has unit tests.


AbstractBot.php
This is the base behavior for bots.  It has a placeholder method for makeMove()
and a couple of property handlers.

PrimitiveBot.php
This is a bot that uses an intelligent priority of strategems to play
Tic Tac Toe.  It utilizes static functions from TTTility.

Primitive2Bot.php
This is another version of the PrimitiveBot that uses named calls rather than
explicitly invoking the underlying functions.

RandomBot.php
This is a bot that moves randomly under its own functions rather than
utilizing the TTTility class.

DNABot.php
This bot extends AbstractBot by adding a base and a trial.  The base is an
ordered list of strategem priorities, which are attempted in turn.  The base
(which is optional) is passed in from the invoker.  The trial is randomly
generated and fills out the list of strategems.  This bot also has the ability
to extend its base by one.  This is done so that a particularly successful bot
can add mutation to various children before adding a trial extension.
This class has unit tests.

Competition.php
This class handles a competition between 2 bots.  Its constructor accepts 2
children of AbstractBot.  Its compete method accept a match count and then
plays that many matches between the 2 bots, alternating the first move.  It
returns the result of those matches.
This class has unit tests.

testGame.php
This creates a couple of DNABots and pits them against each other.
