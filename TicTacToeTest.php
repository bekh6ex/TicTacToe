<?php

use TicTacToe\Exception\PositionIsNotEmptyException;
use TicTacToe\Exception\TurnOrderException;
use TicTacToe\Game;

require 'vendor/autoload.php';

class TicTacToeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Game
     */
    private $game;

    protected function setUp()
    {
        $this->game = new Game();
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
        $this->game->putMark(Game::X, 1, 1);

        $this->setExpectedException(PositionIsNotEmptyException::class);
        $this->game->putMark(Game::O, 1, 1);
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
        $this->game->putMark(Game::X, 1, 1);
        $this->game->putMark(Game::O, 1, 2);
        $this->game->putMark(Game::X, 2, 1);
        $this->game->putMark(Game::O, 2, 2);
        $this->game->putMark(Game::X, 3, 1);

        $this->assertGameIsFinished();
    }

    /**
     * @test
     */
    public function isFinished_ThreeOInAFirstRow_GameIsFinished()
    {
        $this->game->putMark(Game::X, 3, 3); //Just for first turn
        $this->game->putMark(Game::O, 1, 1);
        $this->game->putMark(Game::X, 1, 2);
        $this->game->putMark(Game::O, 2, 1);
        $this->game->putMark(Game::X, 2, 2);
        $this->game->putMark(Game::O, 3, 1);

        $this->assertGameIsFinished();
    }

    /**
     * @test
     */
    public function isFinished_FirstRowFilledWithDifferentMarks_GameIsNotFinished()
    {
        $this->game->putMark(Game::O, 1, 1); $this->game->putMark(Game::X, 2, 1); $this->game->putMark(Game::O, 3, 1);

        $this->assertGameNotFinished();
    }

    /**
     * @test
     */
    public function isFinished_SecondRowFilledWithX_GameIsFinished()
    {
        $this->game->putMark(Game::X, 1, 2);
        $this->game->putMark(Game::O, 1, 1);
        $this->game->putMark(Game::X, 2, 2);
        $this->game->putMark(Game::O, 2, 1);
        $this->game->putMark(Game::X, 3, 2);

        $this->assertGameIsFinished();
    }

    /**
     * @test
     */
    public function isFinished_FirstColumnWithX_GameIsFinished()
    {
        $this->game->putMark(Game::X, 1, 1); $this->game->putMark(Game::O, 2, 1);
        $this->game->putMark(Game::X, 1, 2); $this->game->putMark(Game::O, 2, 2);
        $this->game->putMark(Game::X, 1, 3);

        $this->assertGameIsFinished();
    }

    /**
     * @test
     */
    public function isFinished_SecondColumnWithX_GameIsFinished()
    {
        $this->game->putMark(Game::X, 2, 1); $this->game->putMark(Game::O, 3, 1);
        $this->game->putMark(Game::X, 2, 2); $this->game->putMark(Game::O, 3, 2);
        $this->game->putMark(Game::X, 2, 3);

        $this->assertGameIsFinished();
    }

    /**
     * @test
     */
    public function putMark_PositionIsOccupied_ThrowsPositionIsNotEmptyException()
    {
        $this->game->putMark(Game::X, 1, 1);

        $this->setExpectedException(PositionIsNotEmptyException::class);
        $this->game->putMark(Game::O, 1, 1);
    }

    /**
     * @test
     */
    public function putMark_SameMarkInARow_TurnOrderException()
    {
        $this->game->putMark(Game::X, 1, 1);

        $this->setExpectedException(TurnOrderException::class);
        $this->game->putMark(Game::X, 1, 1);
    }

    /**
     * @test
     */
    public function isFinished_SameMarksInDiagonal_GameIsFinished()
    {
        $this->game->putMark(Game::X, 1, 1); $this->game->putMark(Game::O, 2, 1);
                                                  $this->game->putMark(Game::X, 2, 2); $this->game->putMark(Game::O, 3, 2);
                                                                                            $this->game->putMark(Game::X, 3, 3);

        $this->assertGameIsFinished();
    }

    /**
     * @test
     */
    public function isFinished_SameMarksInAnotherDiagonal_GameIsFinished()
    {
                                                                                            $this->game->putMark(Game::X, 3, 1);
                                                                                            $this->game->putMark(Game::O, 3, 2);
                                                  $this->game->putMark(Game::X, 2, 2);
                                                  $this->game->putMark(Game::O, 2, 3);
        $this->game->putMark(Game::X, 1, 3);

        $this->assertGameIsFinished();
    }

    /**
     * @test
     */
    public function getWinner_DrawGame_ReturnsDRAW()
    {
        $this->drawGame();

        $winner = $this->game->getWinner();

        $this->assertEquals(Game::DRAW, $winner);
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
        $this->game->putMark(Game::X, 1, 1);
                                                  $this->game->putMark(Game::O, 2, 1);
                                                                                            $this->game->putMark(Game::X, 3, 1);
        //=============================================================================================================
                                                  $this->game->putMark(Game::O, 2, 2);
        $this->game->putMark(Game::X, 1, 2);
                                                                                            $this->game->putMark(Game::O, 3, 2);
        //=============================================================================================================
                                                    $this->game->putMark(Game::X, 2, 3);
        $this->game->putMark(Game::O, 1, 3);
                                                                                            $this->game->putMark(Game::X, 3, 3);
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
