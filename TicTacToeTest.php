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
        $this->assertSame(false, $this->game->isFinished());
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

        $this->assertSame(true, $this->game->isFinished());
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
    public function putMark_FullField_GameIsFinished()
    {
        $this->drawGame();

        $this->assertEquals(true, $this->game->isFinished());
    }

    /**
     * @return TicTacToe
     */
    private function createGame()
    {
        return new TicTacToe();
    }

    private function drawGame()
    {
        $this->game->putMark(TicTacToe::O, 1,1); $this->game->putMark(TicTacToe::X, 2,1); $this->game->putMark(TicTacToe::O, 3,1);
        $this->game->putMark(TicTacToe::O, 1,2); $this->game->putMark(TicTacToe::X, 2,2); $this->game->putMark(TicTacToe::X, 3,2);
        $this->game->putMark(TicTacToe::X, 1,3); $this->game->putMark(TicTacToe::O, 2,3); $this->game->putMark(TicTacToe::X, 3,3);
    }

}

class TicTacToe {

    const O = 'o';
    const X = 'x';
    const NONE = null;
    private $field = [];

    public function isFinished()
    {
        if ($this->fieldIsFull()) {
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
            $markCount++;
        }, 0);

        return $markCount === 9;
    }

}
