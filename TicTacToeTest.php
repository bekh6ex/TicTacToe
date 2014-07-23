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
    public function AllMarksSet_GameIsFinished()
    {
        $this->markTestIncomplete();
        $game = new TicTacToe();


        $game->putMark(TicTacToe::O, 1, 1); $game->putMark(TicTacToe::O, 2, 1); $game->putMark(TicTacToe::X, 3, 1);
        $game->putMark(TicTacToe::X, 1, 2); $game->putMark(TicTacToe::X, 2, 2); $game->putMark(TicTacToe::O, 3, 2);
        $game->putMark(TicTacToe::O, 1, 3); $game->putMark(TicTacToe::X, 2, 3); $game->putMark(TicTacToe::X, 3, 3);

        $this->assertGameIsFinished();
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

        if ($this->hasSameInFirstRow()) {
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
        $markCount = 0;
        array_walk_recursive($this->field, function ($item) use (&$markCount) {
            if ($item !== self::NONE) {
                $markCount++;
            }
        }, 0);

        return $markCount === 9;
    }

    /**
     * @return bool
     */
    private function hasSameInFirstRow()
    {
        $result = true;
        $prev = $this->field[0][0];
        for ($i = 1; $i < 3; $i++) {
            $current = $this->field[$i][0];
            $result = $result && $current === $prev && $current !== self::NONE;
            $prev = $this->field[$i][0];
        }

        return $result;
    }

}
