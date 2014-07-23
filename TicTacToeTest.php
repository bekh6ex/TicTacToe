<?php

class TicTacToeTest extends PHPUnit_Framework_TestCase {
    /**
     * @var TicTacToe
     */
    private $game;

    protected function setUp()
    {
        $this->game = new TicTacToe();
    }

    /**
     * @test
     */
    public function createGame_GameIsNotFinished()
    {
        $this->assertGameNotFinished();
    }

    /**
     * @test
     */
    public function putMark_X_MarkShouldBeSet()
    {
        $this->game->putMark(TicTacToe::X, 1, 1);

        $this->assertSame(TicTacToe::X, $this->game->getPositionStatus(1,1));
    }

    /**
     * @test
     */
    public function isFinished_FullField_GameIsFinished()
    {
        $this->drawGame();

        $this->assertGameIsFinished();
    }

    /**
     * @test
     */
    public function isFinished_ThreeXInAFirstRow_GameIsFinished()
    {
        $this->game->putMark(TicTacToe::X, 1, 1); $this->game->putMark(TicTacToe::X, 2, 1); $this->game->putMark(TicTacToe::X, 3, 1);

        $this->assertGameIsFinished();
    }

    /**
     * @test
     */
    public function isFinished_ThreeOInAFirstRow_GameIsFinished()
    {
        $this->game->putMark(TicTacToe::O, 1, 1); $this->game->putMark(TicTacToe::O, 2, 1); $this->game->putMark(TicTacToe::O, 3, 1);

        $this->assertGameIsFinished();
    }

    /**
     * @test
     */
    public function isFinished_FirstRowFilledWithDifferentMarks_GameIsNotFinished()
    {
        $this->game->putMark(TicTacToe::O, 1, 1); $this->game->putMark(TicTacToe::X, 2, 1); $this->game->putMark(TicTacToe::O, 3, 1);

        $this->assertGameNotFinished();
    }

    /**
     * @test
     */
    public function isFinished_SecondRowFilledWithX_GameIsFinished()
    {
        $this->game->putMark(TicTacToe::X, 1, 2); $this->game->putMark(TicTacToe::X, 2, 2); $this->game->putMark(TicTacToe::X, 3, 2);

        $this->assertGameIsFinished();
    }

    /**
     * @test
     */
    public function isFinished_FirstColumnWithX_GameIsFinished()
    {
        $this->game->putMark(TicTacToe::X, 1, 1);
        $this->game->putMark(TicTacToe::X, 1, 2);
        $this->game->putMark(TicTacToe::X, 1, 3);

        $this->assertGameIsFinished();
    }


    private function drawGame()
    {
        $this->game->putMark(TicTacToe::O, 1,1); $this->game->putMark(TicTacToe::X, 2,1); $this->game->putMark(TicTacToe::O, 3,1);
        $this->game->putMark(TicTacToe::O, 1,2); $this->game->putMark(TicTacToe::X, 2,2); $this->game->putMark(TicTacToe::X, 3,2);
        $this->game->putMark(TicTacToe::X, 1,3); $this->game->putMark(TicTacToe::O, 2,3); $this->game->putMark(TicTacToe::X, 3,3);
    }

    private function assertGameNotFinished()
    {
        $this->assertEquals(false, $this->game->isFinished());
    }

    private function assertGameIsFinished()
    {
        $this->assertSame(true, $this->game->isFinished());
    }
}

class TicTacToe {

    const O = 'o';
    const X = 'x';
    const NONE = 'empty';
    private $field = [
        [self::NONE, self::NONE, self::NONE],
        [self::NONE, self::NONE, self::NONE],
        [self::NONE, self::NONE, self::NONE],
    ];

    public function isFinished()
    {
        if ($this->fieldIsFull()) {
            return true;
        }

        if ($this->oneOfRowsHasSameMarks() || $this->firstColumnHasSameMarks()) {
            return true;
        }

        return false;
    }

    public function putMark($mark, $posX, $posY)
    {
        $this->field[$posX-1][$posY-1] = $mark;
    }

    public function getPositionStatus($posX, $posY)
    {
        return $this->field[$posX-1][$posY-1];
    }

    /**
     * @return bool
     */
    private function fieldIsFull()
    {
        $hasEmptyPosition = false;
        array_walk_recursive($this->field, function ($item) use (&$hasEmptyPosition) {
            if ($item === self::NONE) {
                $hasEmptyPosition = true;
            }
        }, 0);

        return !$hasEmptyPosition;
    }

    /**
     * @return bool
     */
    private function hasSameSymbolsInRow($rowIndex)
    {
        $row = $this->getRow($rowIndex);

        return $this->areSameSymbolsAndSet($row);
    }

    /**
     * @return bool
     */
    private function oneOfRowsHasSameMarks()
    {
        $result = false;
        for ($i = 0; $i < $this->getRowCount(); $i++) {
            $result = $result || $this->hasSameSymbolsInRow($i);
        }
        return $result;
    }

    /**
     * @return int
     */
    private function getRowCount()
    {
        return 3;
    }

    /**
     * @return int
     */
    private function getColumnCount()
    {
        return 3;
    }

    private function firstColumnHasSameMarks()
    {
        return $this->areSameSymbolsAndSet($this->getColumn(0));
    }

    /**
     * @param array $symbols
     * @return bool
     */
    private function areSameSymbolsAndSet(array $symbols)
    {
        $result = true;
        $prev = $symbols[0];
        for ($i = 1; $i < $this->getColumnCount(); $i++) {
            $current = $symbols[$i];
            $result = $result && $current === $prev && $current !== self::NONE;
            $prev = $symbols[$i];
        }

        return $result;
    }

    /**
     * @param $rowIndex
     * @return array
     */
    private function getRow($rowIndex)
    {
        return array_column($this->field, $rowIndex);
    }

    /**
     * @param $index
     * @return mixed
     */
    private function getColumn($index)
    {
        return $this->field[$index];
    }

}
