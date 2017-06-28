<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/28/17
 * Time: 8:47 PM
 */
class Cell
{
    const BLANK = 0;
    const WALL = 1;
    const DEAD_BLOCK = 2;
    const VISITED = 3;

    public $x;
    public $y;
    public $type;

    public function __construct(int $y, int $x, $type)
    {
        $this->x = $x;
        $this->y = $y;
        $this->type = $type;
    }

    public function isWall()
    {
        if ($this->type == self::WALL) return true;
        return false;
    }

    public function isBlank()
    {
        if ($this->type == self::BLANK) return true;
        return false;
    }

    public function isDeadBlock()
    {
        if ($this->type == self::DEAD_BLOCK) return true;
        return false;
    }
}