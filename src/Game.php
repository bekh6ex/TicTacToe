<?php

namespace TicTacToe;

use TicTacToe\Exception\PositionIsNotEmptyException;
use TicTacToe\Exception\TurnOrderException;

class Game
{
    const O = 'o';
    const X = 'x';
    const NONE = 'empty';
    const FIELD_SIZE = 3;
    const DRAW = 'DRAW';

    /**
     * @var Field
     */
    private $field = [];
    private $previousMark;

    private $winner = null;

    public function __construct()
    {
        $this->field = new Field();
    }

    public function isFinished()
    {
        if ($this->winnerIsSet()) {
            return true;
        }

        $this->checkForWinner();

        return $this->winner !== null;
    }

    /**
     * @param $mark
     * @param $posX
     * @param $posY
     * @throws PositionIsNotEmptyException
     * @throws TurnOrderException
     */
    public function putMark($mark, $posX, $posY)
    {
        if ($this->previousMark == $mark) {
            throw new TurnOrderException;
        }
        $this->field->set($posX, $posY, $mark);
        $this->previousMark = $mark;
    }

    public function getWinner()
    {
        if (!$this->winnerIsSet()) {
            $this->checkForWinner();
        }

        return $this->winner;
    }

    public function getFieldAsArray()
    {
        return $this->field->toArray();
    }

    protected function checkForWinner()
    {
        if ($this->winnerIsSet()) {
            return;
        }

        $this->checkForWinningCombinations();
        $this->checkForDrawGame();
    }

    protected function checkForWinningCombinations()
    {
        for ($y = 1; $y <= $this->field->getRowCount(); $y++) {
            for ($x = 1; $x <= $this->field->getColumnCount(); $x++) {
//                $this->field->findFirstPositionMatching(function ($x, $y) {
//                    return
//                });
                foreach ($this->field->getPossibleCombinations($x, $y) as $marks) {
                    if ($this->areSetAndSame($marks)) {
                        $this->winner = current($marks);
                        break;
                    }
                }
            }
        }
    }

    /**
     * @param array $marks
     * @return bool
     */
    private function areSetAndSame(array $marks)
    {
        $result = true;
        $prev = $marks[0];
        for ($i = 1; $i < self::FIELD_SIZE; $i++) {
            $current = $marks[$i];
            $result = $result && $current === $prev && $current !== self::NONE;
            $prev = $marks[$i];
        }

        return $result;
    }

    private function checkForDrawGame()
    {
        if ($this->field->fieldIsFull()) {
            $this->winner = self::DRAW;
        }
    }

    /**
     * @return bool
     */
    private function winnerIsSet()
    {
        return $this->winner !== null;
    }
}
