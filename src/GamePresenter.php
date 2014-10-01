<?php

namespace TicTacToe;


interface GamePresenter
{
    public function displayGreetingMessage();

    public function displayGameResults(Game $game);

    public function greetPlayer(Player $player);
}
