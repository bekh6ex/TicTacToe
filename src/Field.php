<?php

namespace TicTacToe;

use TicTacToe\Exception\PositionIsNotEmptyException;

class Field
{
    const NONE = 'empty';

    private $rowCount = 3;
    private $columnCount = 3;

    private $field = [];

    public function __construct()
    {
        $width = $this->columnCount;
        $height = $this->rowCount;
        for ($y = 1; $y <= $height; ++$y) {
            $this->field[$y] = [];
            for ($x = 1; $x <= $width; ++$x) {
                $this->field[$y][$x] = self::NONE;
            }
        }
    }

    public static function createFromArray(array $fieldArray)
    {
        $field = new self;
        $field->field = $fieldArray;

        return $field;
    }

    /**
     * @return bool
     */
    public function fieldIsFull()
    {
        $hasEmptyPosition = false;
        array_walk_recursive($this->field, function ($item) use (&$hasEmptyPosition) {
            if ($item === self::NONE) {
                $hasEmptyPosition = true;
            }
        }, 0);

        return !$hasEmptyPosition;
    }

    public function getPossibleCombinations($x, $y)
    {
        $combinations = [];
        if ($this->canGetRowCombinationForPosition($x, $y)) {
            $combinations[] = $this->getRow($y);
        }

        if ($this->canGetColumnCombinationForPosition($x, $y)) {
            $combinations[] = $this->getColumn($x);
        }

        if ($this->canGetDownwardDiagonalCombinationForPosition($x, $y)) {
            $combinations[] = $this->getDownwardDiagonal();
        }

        if ($this->canGetUpwardDiagonalCombinationForPosition($x, $y)) {
            $combinations[] = $this->getUpwardDiagonal();
        }

        return $combinations;
    }

    /**
     * @param $x
     * @param $y
     * @param $symbol
     * @throws PositionIsNotEmptyException
     */
    public function set($x, $y, $symbol)
    {
        if ($this->field[$y][$x] !== self::NONE) {
            throw new PositionIsNotEmptyException;
        }
        $this->field[$y][$x] = $symbol;
    }

    public function toArray()
    {
        return $this->field;
    }

    private function getRow($y)
    {
        return array_values($this->field[$y]);
    }

    private function getColumn($x)
    {
        return array_values(array_column($this->field, $x));
    }

    private function getDownwardDiagonal()
    {
        return [
            $this->field[1][1],
            $this->field[2][2],
            $this->field[3][3],
        ];
    }

    private function getUpwardDiagonal()
    {
        return [
            $this->field[1][3],
            $this->field[2][2],
            $this->field[3][1],
        ];
    }

    /**
     * @return int
     */
    public function getRowCount()
    {
        return $this->rowCount;
    }

    /**
     * @return int
     */
    public function getColumnCount()
    {
        return $this->columnCount;
    }

    private function canGetRowCombinationForPosition($x, $y)
    {
        return $x == 1;
    }

    private function canGetColumnCombinationForPosition($x, $y)
    {
        return $y == 1;
    }

    private function canGetUpwardDiagonalCombinationForPosition($x, $y)
    {
        return $x == 1 && $y == 3;
    }

    private function canGetDownwardDiagonalCombinationForPosition($x, $y)
    {
        return $x == 1 && $y == 1;
    }
}
