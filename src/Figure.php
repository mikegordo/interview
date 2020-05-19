<?php

class Figure {
    protected $isBlack;

    protected $canJumpOver = true;

    public function __construct($isBlack) {
        $this->isBlack = $isBlack;
    }

    public function isBlackFigure() {
        return $this->isBlack;
    }

    public function canJumpOverFigure() {
        return $this->canJumpOver;
    }

    public function validateMove($from, $to, $isDestinationEmpty) {
        return true;
    }

    /** @noinspection PhpToStringReturnInspection */
    public function __toString() {
        throw new \Exception("Not implemented");
    }
}
