<?php

namespace TicTacToe;

class AsciiGameImageGenerator implements GameImageGenerator
{

    /**
     * @param Field $field
     * @param $previousMark
     * @return GameImage
     */
    public function generateImage(Field $field, $previousMark)
    {
        return new AsciiGameImage($field);
    }
}
