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
    public function putMarkX_MarkShouldBeSet()
    {
        $this->game->putMark(TicTacToe::X, 1, 1);

        $this->assertSame(TicTacToe::X, $this->game->getPositionStatus(1,1));
    }

    /**
     * @test
     */
    public function putMark_()
    {
        $this->markTestIncomplete();
//        $this->game->putMark();

    }

    /**
     * @return TicTacToe
     */
    private function createGame()
    {
        return new TicTacToe();
    }

}

class TicTacToe {

    const O = 'o';
    const X = 'x';
    const NONE = null;
    private $field = [
        [self::NONE, self::NONE, self::NONE],
        [self::NONE, self::NONE, self::NONE],
        [self::NONE, self::NONE, self::NONE],
    ];

    public function isFinished()
    {
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

}
