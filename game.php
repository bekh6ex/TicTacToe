<?php

use TicTacToe\Game;

require 'vendor/autoload.php';

if (!function_exists('readline')) {
    function readline($text)
    {
        echo $text;
        $fp = fopen("php://stdin","r");
        return rtrim(fgets($fp, 1024));
    }
}

$gameMapImage =[
    ['q', 'w', 'e'],
    ['a', 's', 'd'],
    ['z', 'x', 'c'],
];

$controlMap = [
    'q' => [1,1],
    'w' => [2,1],
    'e' => [3,1],
    'a' => [1,2],
    's' => [2,2],
    'd' => [3,2],
    'z' => [1,3],
    'x' => [2,3],
    'c' => [3,3],
];

function renderRow(array $values) {
    $values = array_map(function ($item) { return str_replace(Game::NONE, ' ', $item); }, $values);
    return ' ' . implode(' | ', $values) . ' ';
}

function renderField(array $field) {
    $delimiter = '---+---+---';

    $renderedRows = array_map('renderRow', $field);

    return implode(PHP_EOL . $delimiter . PHP_EOL, $renderedRows);
}

function writeLine($string = '') {
    echo $string . PHP_EOL;
}

$playerMap = [0 => Game::X, 1 => Game::O];


$game = new Game();

writeLine('Controls:');
writeLine(renderField($gameMapImage));
writeLine();

$currentPlayerIndex = 0;
while (!$game->isFinished()) {
    $playerMark = $playerMap[$currentPlayerIndex];

    writeLine(renderField($game->getFieldAsArray()));
    writeLine();

    $keyPressed = '';
    do {
        $keyPressed = readline($playerMark . " turn:");
        if (!isset($controlMap[$keyPressed])) {
            writeLine('Unknown control pressed!');
            continue;
        }
        list($x, $y) = $controlMap[$keyPressed];
        try {
            $player->makeMove($game);
            $game->putMark($playerMark, $x, $y);
            break;
        } catch (PositionIsNotEmptyException $e) {
            writeLine('Position is not empty - try another!');
        }
    } while (true);

    $currentPlayerIndex = 1 - $currentPlayerIndex;
}

writeLine();
writeLine('================================');
writeLine();
writeLine('Winner: ' . $game->getWinner());
writeLine();
writeLine(renderField($game->getFieldAsArray()));
writeLine();




