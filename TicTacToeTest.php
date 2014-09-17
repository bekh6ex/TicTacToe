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

    /**
     * @test
     */
    public function getWinner_DrawGame_ReturnsDRAW()
    {
        $this->markTestIncomplete();

        $this->drawGame();

        $winner = $this->game->getWinner();

        $this->assertEquals(TicTacToe::DRAW, $winner);
    }

    /**
     * @test
     */
    public function putMark_GameIsFinished_ThrowsGameOverException()
    {
        $this->markTestIncomplete();
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
    const DRAW = 'DRAW';

    /**
     * @var GameField
     */
    private $field = [];
    private $previousMark;

    private $winner = null;

    public function __construct()
    {
        $this->field = new GameField();
    }

    public function isFinished()
    {
        if ($this->winner !== null) {
            return true;
        }

        $this->checkForWinnerInRows();
        $this->checkForWinnerInColumns();
        $this->checkForWinnerInDiagonals();
        $this->checkForDrawGame();

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

    public function getPositionStatus($posX, $posY)
    {
        return $this->field->get($posX, $posY);
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

    /**
     * @return void
     */
    private function checkForWinnerInRows()
    {
        if ($this->winner !== null) {
            return;
        }

        for ($i = 1; $i <= $this->field->getRowCount(); $i++) {
            $marks = $this->field->getRow($i);
            if ($this->areSetAndSame($marks)) {
                $this->winner = current($marks);
            }
        }
    }

    private function checkForWinnerInColumns()
    {
        if ($this->winner !== null) {
            return;
        }

        for ($i = 1; $i <= $this->field->getColumnCount(); $i++) {
            $marks = $this->field->getColumn($i);
            if ($this->areSetAndSame($marks)) {
                $this->winner = current($marks);
            }
        }
    }

    private function checkForWinnerInDiagonals()
    {
        if ($this->winner !== null) {
            return;
        }

        $diagonals =[
            $this->field->getDiagonal1(),
            $this->field->getDiagonal2(),
        ];

        foreach ($diagonals as $marks) {
            if ($this->areSetAndSame($marks)) {
                $this->winner = current($marks);
            }
        }
    }

    private function checkForDrawGame()
    {
        if ($this->winner !== null) {
            return;
        }

        if ($this->field->fieldIsFull()) {
            $this->winner = self::DRAW;
        }
    }
}

class GameField
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
