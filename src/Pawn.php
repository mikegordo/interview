<?php

class Pawn extends Figure {
    protected $isFirstMove = true;

    protected $canJumpOver = false;

    public function validateMove($from, $to, $isDestinationEmpty) {
        parent::validateMove($from, $to, $isDestinationEmpty);

        list($xFrom, $yFrom) = $from;
        list($xTo, $yTo) = $to;

        // direction
        $diff = $yTo - $yFrom;
        if (($diff > 0) == $this->isBlack) {
            throw new \Exception("Incorrect move");
        }

        // vertical move
        if (abs($diff) > 2 ||
            (abs($diff) == 2 && !$this->isFirstMove)) {
            throw new \Exception("Incorrect move");
        }

        // diagonal move
        if (($xFrom != $xTo) && $isDestinationEmpty) {
            throw new \Exception("Incorrect move");
        }

        $this->isFirstMove = false;
    }

    public function __toString() {
        return $this->isBlack ? '♟' : '♙';
    }
}
