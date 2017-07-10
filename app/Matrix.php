<?php
include 'Cell.php';

class Matrix
{
    private $visited = [];
	private $height;
    private $width;

    public $matrix = [];

    public function __construct(int $height = 100, int $width = 100)
    {
    	$this->height = $height;
    	$this->width = $width;
        $this->initialize();
    }

    private function initialize()
    {
        for ($y = 1; $y < $this->height; $y++) {
            $lineArray = [];
            for ($x = 1; $x < $this->width; $x++) {
                if ($y % 2 == 0 && $x % 2 == 0) {
                    $lineArray[] = new Cell($y - 1, $x - 1, Cell::BLANK);
                } else {
                    $lineArray[] = new Cell($y - 1, $x - 1, Cell::WALL);
                }
            }
            $this->matrix[] = $lineArray;
        }
        $this->matrix[1][1] = new Cell(1, 1, Cell::BLANK);
        $this->matrix[1][0] = new Cell(1, 0, Cell::VISITED);
        $this->matrix[$this->height - 3][$this->width - 2] = new Cell($this->height - 3, $this->width - 2, Cell::VISITED);
        return true;
    }

    public function generate(Cell $currentCell)
    {
        $startCell = $currentCell;
        do {

            $neighbours = $this->getNeighbours($startCell);
            $randomNeighbour = $neighbours[array_rand($neighbours)];
            if (isset($randomNeighbour)) {
                $this->visited[] = $startCell;
                $this->removeWall($startCell, $randomNeighbour);
                $startCell = $randomNeighbour;
            } else {
                $visitedCell = array_pop($this->visited);
                if ($visitedCell) {
                    $startCell = $visitedCell;
                }
            }
        } while (!empty($this->visited));
    }

    public function walk(Cell $startCell, $endCell)
    {
        $currentCell = $startCell;
        $currentCell->type = Cell::WALK_VISITED;
        do {
            $neighbours = $this->getNeighbours($currentCell, Cell::VISITED, 1);
            $randomNeighbour = $neighbours[array_rand($neighbours)];
            if (isset($randomNeighbour)) {
                $this->visited[] = $currentCell;
                $currentCell->type = Cell::WALK_VISITED;
                $currentCell = $randomNeighbour;
            } else {
                $currentCell->type = Cell::DEAD_BLOCK;
                $visitedCell = array_pop($this->visited);
                if ($visitedCell) {
                    $currentCell = $visitedCell;
                }
            }
        } while ($currentCell->x != $endCell->x && $currentCell->y != $endCell->y);
        $currentCell->type = Cell::WALK_VISITED;
        return 'SUCCESS';
    }

    public function getLeftCell(Cell $cell, $type = Cell::BLANK, $padding = 2)
    {
        $leftCell = $this->matrix[$cell->y][$cell->x - $padding];
        if (isset($leftCell) && $leftCell->type == $type) {
            return $leftCell;
        }
        return false;
    }

    public function getRightCell(Cell $cell, $type = Cell::BLANK, $padding = 2)
    {
        $rightCell = $this->matrix[$cell->y][$cell->x + $padding];
        if (isset($rightCell) && $rightCell->type == $type) {
            return $rightCell;
        }
        return false;
    }

    public function getTopCell(Cell $cell, $type = Cell::BLANK, $padding = 2)
    {
        $topCell = $this->matrix[$cell->y + $padding][$cell->x];
        if (isset($topCell) && $topCell->type == $type) {
            return $topCell;
        }
        return false;
    }

    public function getBottomCell(Cell $cell, $type = Cell::BLANK, $padding = 2)
    {
        $bottomCell = $this->matrix[$cell->y - $padding][$cell->x];
        if (isset($bottomCell) && $bottomCell->type == $type) {
            return $bottomCell;
        }
        return false;
    }

    private function removeWall(Cell $fromCell, Cell $toCell)
    {
        $xDiff = $toCell->x - $fromCell->x;
        $yDiff = $toCell->y - $fromCell->y;

        $addX = $xDiff != 0 ? $xDiff / abs($xDiff) : 0;
        $addY = $yDiff != 0 ? $yDiff / abs($yDiff) : 0;

        $wallX = $fromCell->x + $addX;
        $wallY = $fromCell->y + $addY;

        $newCell = new Cell($wallY, $wallX, Cell::VISITED);
        $fromCell->type = Cell::VISITED;
        $toCell->type = Cell::VISITED;
        $this->matrix[$wallY][$wallX] = $newCell;

        return true;
    }

    public function getNeighbours(Cell $cell, $type = Cell::BLANK, $padding = 2): array
    {
        $arrCells = [];

        if ($this->getLeftCell($cell, $type, $padding)) $arrCells[] = $this->getLeftCell($cell, $type, $padding);
        if ($this->getRightCell($cell, $type, $padding)) $arrCells[] = $this->getRightCell($cell, $type, $padding);
        if ($this->getTopCell($cell, $type, $padding)) $arrCells[] = $this->getTopCell($cell, $type, $padding);
        if ($this->getBottomCell($cell, $type, $padding)) $arrCells[] = $this->getBottomCell($cell, $type, $padding);

        return $arrCells;
    }
}