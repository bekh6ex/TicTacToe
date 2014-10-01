<?php

namespace TicTacToe;

interface GameImageGenerator
{

    /**
     * @param Field $field
     * @param $previousMark
     * @return GameImage
     */
    public function generateImage(Field $field, $previousMark);
}
