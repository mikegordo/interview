<?php

class Desk {
    private $figures = [];

    /**
     * Flag indicates last move done by black
     * True by default because whites always start
     *
     * @var bool
     */
    private $lastMoveBlack = true;

    public function __construct() {
        $this->figures['a'][1] = new Rook(false);
        $this->figures['b'][1] = new Knight(false);
        $this->figures['c'][1] = new Bishop(false);
        $this->figures['d'][1] = new Queen(false);
        $this->figures['e'][1] = new King(false);
        $this->figures['f'][1] = new Bishop(false);
        $this->figures['g'][1] = new Knight(false);
        $this->figures['h'][1] = new Rook(false);

        $this->figures['a'][2] = new Pawn(false);
        $this->figures['b'][2] = new Pawn(false);
        $this->figures['c'][2] = new Pawn(false);
        $this->figures['d'][2] = new Pawn(false);
        $this->figures['e'][2] = new Pawn(false);
        $this->figures['f'][2] = new Pawn(false);
        $this->figures['g'][2] = new Pawn(false);
        $this->figures['h'][2] = new Pawn(false);

        $this->figures['a'][7] = new Pawn(true);
        $this->figures['b'][7] = new Pawn(true);
        $this->figures['c'][7] = new Pawn(true);
        $this->figures['d'][7] = new Pawn(true);
        $this->figures['e'][7] = new Pawn(true);
        $this->figures['f'][7] = new Pawn(true);
        $this->figures['g'][7] = new Pawn(true);
        $this->figures['h'][7] = new Pawn(true);

        $this->figures['a'][8] = new Rook(true);
        $this->figures['b'][8] = new Knight(true);
        $this->figures['c'][8] = new Bishop(true);
        $this->figures['d'][8] = new Queen(true);
        $this->figures['e'][8] = new King(true);
        $this->figures['f'][8] = new Bishop(true);
        $this->figures['g'][8] = new Knight(true);
        $this->figures['h'][8] = new Rook(true);
    }

    public function move($move) {
        if (!preg_match('/^([a-h])(\d)-([a-h])(\d)$/', $move, $match)) {
            throw new \Exception("Incorrect move");
        }

        $xFrom = $match[1];
        $yFrom = $match[2];
        $xTo   = $match[3];
        $yTo   = $match[4];

        if (!isset($this->figures[$xFrom][$yFrom])) {
            throw new \Exception("Incorrect move");
        }

        $this->validateColor($this->figures[$xFrom][$yFrom]);
        $this->validateJumpOver([$xFrom, $yFrom], [$xTo, $yTo]);
        $this->figures[$xFrom][$yFrom]->validateMove([$xFrom, $yFrom], [$xTo, $yTo], empty($this->figures[$xTo][$yTo]));
        $this->figures[$xTo][$yTo] = $this->figures[$xFrom][$yFrom];

        unset($this->figures[$xFrom][$yFrom]);
    }

    protected function validateColor($figure) {
        $isBlack = $figure->isBlackFigure();
        if ($this->lastMoveBlack == $isBlack) {
            throw new \Exception("Incorrect move");
        }
        $this->lastMoveBlack = !$this->lastMoveBlack;
    }

    protected function validateJumpOver($from, $to) {
        list($xFrom, $yFrom) = $from;
        list($xTo, $yTo) = $to;
        $canJumpOver = $this->figures[$xFrom][$yFrom]->canJumpOverFigure();
        if ($canJumpOver) {
            return;
        }

        if (abs($xFrom - $xTo) < 2 && abs($yFrom - $yTo) < 2) {
            return;
        }

        // only implementing for strictly vertical or horizontal moves
        if ($xFrom != $xTo && $yFrom == $yTo) {
            for ($x = $xTo > $xFrom ? $xFrom + 1 : $xFrom - 1; $x < $xTo; $x = $xTo > $xFrom ? $x + 1 : $x - 1) {
                if (!empty($this->figures[$x][$yFrom])) {
                    throw new \Exception("Incorrect move");
                }
            }
        }

        if ($yFrom != $yTo && $xFrom == $xTo) {
            for ($y = $yTo > $yFrom ? $yFrom + 1 : $yFrom - 1; $y < $yTo; $y = $yTo > $yFrom ? $y + 1 : $y - 1) {
                if (!empty($this->figures[$xFrom][$y])) {
                    throw new \Exception("Incorrect move");
                }
            }
        }
    }

    public function dump() {
        for ($y = 8; $y >= 1; $y--) {
            echo "$y ";
            for ($x = 'a'; $x <= 'h'; $x++) {
                if (isset($this->figures[$x][$y])) {
                    echo $this->figures[$x][$y];
                } else {
                    echo '-';
                }
            }
            echo "\n";
        }
        echo "  abcdefgh\n";
    }
}
