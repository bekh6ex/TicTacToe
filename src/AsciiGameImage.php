<?php

namespace TicTacToe;

class AsciiGameImage implements GameImage
{
    /**
     * @var array
     */
    private $field;

    function __construct(Field $field)
    {
        $this->field = $field->toArray();
    }

    /**
     * @return Field
     */
    public function getField()
    {
        return Field::createFromArray($this->field);
    }

    /**
     * @return mixed
     */
    public function getPreviousMark()
    {
        $xCount = 0;
        $oCount = 0;
        array_walk_recursive($this->field, function ($item) use (&$xCount, &$oCount) {
            if ($item == Game::X) {
                $xCount++;
            }

            if ($item == Game::O) {
                $oCount++;
            }
        });

        if (!$xCount && !$oCount) {
            return null;
        }

        if ($xCount > $oCount) {
            return Game::X;
        } else {
            return Game::O;
        }
    }
}
