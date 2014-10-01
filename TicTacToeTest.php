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

        $this->setExpectedException(PositionIsNotEmptyException::class);
        $this->game->putMark(TicTacToe::O, 1, 1);
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
//        $combinationsCollection = [];

        for ($y = 1; $y <= $this->field->getRowCount(); $y++) {
            for ($x = 1; $x <= $this->field->getColumnCount(); $x++) {

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

    public function getPossibleCombinations($x, $y)
    {
        $combinations = [];
        if ($this->canGetRowCombinationForPosition($x,$y)) {
            $combinations[] = $this->getRow($y);
        }

        if ($this->canGetColumnCombinationForPosition($x,$y)) {
            $combinations[] = $this->getColumn($x);
        }

        if ($this->canGetDownwardDiagonalCombinationForPosition($x,$y)) {
            $combinations[] = $this->getDownwardDiagonal();
        }

        if ($this->canGetUpwardDiagonalCombinationForPosition($x,$y)) {
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

class PositionIsNotEmptyException extends Exception
{
}


class TurnOrderException extends Exception
{
}
