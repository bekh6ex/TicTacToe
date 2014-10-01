<?php

namespace TicTacToe;


interface GameImage
{

    /**
     * @return Field
     */
    public function getField();

    /**
     * @return mixed
     */
    public function getPreviousMark();
}
