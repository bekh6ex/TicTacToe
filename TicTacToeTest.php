<?php

class TicTacToeTest extends PHPUnit_Framework_TestCase
{
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

        $this->assertSame(TicTacToe::X, $this->game->getPositionStatus(1, 1));
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
        $this->game->putMark(TicTacToe::X, 1, 1);
        $this->game->putMark(TicTacToe::O, 1, 2);
        $this->game->putMark(TicTacToe::X, 2, 1);
        $this->game->putMark(TicTacToe::O, 2, 2);
        $this->game->putMark(TicTacToe::X, 3, 1);

        $this->assertGameIsFinished();
    }

    /**
     * @test
     */
    public function isFinished_ThreeOInAFirstRow_GameIsFinished()
    {
        $this->game->putMark(TicTacToe::X, 3, 3); //Just for first turn
        $this->game->putMark(TicTacToe::O, 1, 1);
        $this->game->putMark(TicTacToe::X, 1, 2);
        $this->game->putMark(TicTacToe::O, 2, 1);
        $this->game->putMark(TicTacToe::X, 2, 2);
        $this->game->putMark(TicTacToe::O, 3, 1);

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
        $this->game->putMark(TicTacToe::X, 1, 2);
        $this->game->putMark(TicTacToe::O, 1, 1);
        $this->game->putMark(TicTacToe::X, 2, 2);
        $this->game->putMark(TicTacToe::O, 2, 1);
        $this->game->putMark(TicTacToe::X, 3, 2);

        $this->assertGameIsFinished();
    }

    /**
     * @test
     */
    public function isFinished_FirstColumnWithX_GameIsFinished()
    {
        $this->game->putMark(TicTacToe::X, 1, 1); $this->game->putMark(TicTacToe::O, 2, 1);
        $this->game->putMark(TicTacToe::X, 1, 2); $this->game->putMark(TicTacToe::O, 2, 2);
        $this->game->putMark(TicTacToe::X, 1, 3);

        $this->assertGameIsFinished();
    }

    /**
     * @test
     */
    public function isFinished_SecondColumnWithX_GameIsFinished()
    {
        $this->game->putMark(TicTacToe::X, 2, 1); $this->game->putMark(TicTacToe::O, 3, 1);
        $this->game->putMark(TicTacToe::X, 2, 2); $this->game->putMark(TicTacToe::O, 3, 2);
        $this->game->putMark(TicTacToe::X, 2, 3);

        $this->assertGameIsFinished();
    }

    /**
     * @test
     */
    public function putMark_PositionIsOccupied_ThrowsPositionIsNotEmptyException()
    {
        $this->game->putMark(TicTacToe::X, 1, 1);

        $this->setExpectedException(PositionIsNotEmptyException::class);
        $this->game->putMark(TicTacToe::O, 1, 1);
    }

    /**
     * @test
     */
    public function putMark_SameMarkInARow_TurnOrderException()
    {
        $this->game->putMark(TicTacToe::X, 1, 1);

        $this->setExpectedException(TurnOrderException::class);
        $this->game->putMark(TicTacToe::X, 1, 1);
    }

    /**
     * @test
     */
    public function isFinished_SameMarksInDiagonal_GameIsFinished()
    {
        $this->game->putMark(TicTacToe::X, 1, 1); $this->game->putMark(TicTacToe::O, 2, 1);
                                                  $this->game->putMark(TicTacToe::X, 2, 2); $this->game->putMark(TicTacToe::O, 3, 2);
                                                                                            $this->game->putMark(TicTacToe::X, 3, 3);

        $this->assertGameIsFinished();
    }

    /**
     * @test
     */
    public function isFinished_SameMarksInAnotherDiagonal_GameIsFinished()
    {
                                                                                            $this->game->putMark(TicTacToe::X, 3, 1);
                                                                                            $this->game->putMark(TicTacToe::O, 3, 2);
                                                  $this->game->putMark(TicTacToe::X, 2, 2);
                                                  $this->game->putMark(TicTacToe::O, 2, 3);
        $this->game->putMark(TicTacToe::X, 1, 3);

        $this->assertGameIsFinished();
    }

    private function drawGame()
    {
        $this->game->putMark(TicTacToe::X, 1, 1);
                                                  $this->game->putMark(TicTacToe::O, 2, 1);
                                                                                            $this->game->putMark(TicTacToe::X, 3, 1);
        //=============================================================================================================
                                                  $this->game->putMark(TicTacToe::O, 2, 2);
        $this->game->putMark(TicTacToe::X, 1, 2);
                                                                                            $this->game->putMark(TicTacToe::O, 3, 2);
        //=============================================================================================================
                                                    $this->game->putMark(TicTacToe::X, 2, 3);
        $this->game->putMark(TicTacToe::O, 1, 3);
                                                                                            $this->game->putMark(TicTacToe::X, 3, 3);
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

class TicTacToe
{

    const O = 'o';
    const X = 'x';
    const NONE = 'empty';
    const FIELD_SIZE = 3;
    /**
     * @var GameField
     */
    private $field = [];
    private $previousMark;

    public function __construct()
    {
        $this->field = new GameField();
    }

    public function isFinished()
    {
        if ($this->field->fieldIsFull()) {
            return true;
        }

        if ($this->oneOfRowsHasSameMarks() || $this->oneOfColumnsHasSameMarks() || $this->oneOfDiagonalsHasSameMarks()) {
            return true;
        }

        return false;
    }

    /**
     * @param $mark
     * @param $posX
     * @param $posY
     * @throws PositionIsNotEmptyException
     */
    public function putMark($mark, $posX, $posY)
    {
        if ($this->previousMark == $mark) {
            throw new TurnOrderException;
        }
        $this->field->set($posX, $posY, $mark);
        $this->previousMark = $mark;
    }

    public function getPositionStatus($posX, $posY)
    {
        return $this->field->get($posX, $posY);
    }

    /**
     * @return bool
     */
    private function oneOfRowsHasSameMarks()
    {
        $result = false;
        for ($i = 1; $i <= $this->field->getRowCount(); $i++) {
            $result = $result || $this->areSetAndSame($this->field->getRow($i));
        }

        return $result;
    }

    private function oneOfDiagonalsHasSameMarks()
    {
        return $this->areSetAndSame($this->field->getDiagonal1()) || $this->areSetAndSame($this->field->getDiagonal2());
    }

    /**
     * @return bool
     */
    private function oneOfColumnsHasSameMarks()
    {
        $result = false;
        for ($i = 1; $i <= $this->field->getColumnCount(); $i++) {
            $result = $result || $this->areSetAndSame($this->field->getColumn($i));
        }

        return $result;
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
}

class GameField
{
    const O = 'o';
    const X = 'x';
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

    public function get($x, $y)
    {
        return $this->field[$y][$x];
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

    public function getRow($y)
    {
        return array_values($this->field[$y]);
    }

    public function getColumn($x)
    {
        return array_values(array_column($this->field, $x));
    }

    public function getDiagonal1()
    {
        return [
            $this->field[1][1],
            $this->field[2][2],
            $this->field[3][3],
        ];
    }

    public function getDiagonal2()
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
}

class PositionIsNotEmptyException extends Exception
{
}


class TurnOrderException extends Exception
{
}
