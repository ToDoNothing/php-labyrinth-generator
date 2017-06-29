<?php
include 'Cell.php';

class Matrix
{
    const HEIGHT = 100;
    const WIDTH = 100;

    const START_X = 1;
    const START_Y = 1;

    private $visited = [];

    public $matrix = [];

    public function __construct()
    {
        $this->initialize();
    }

    private function initialize()
    {
        for ($y = 1; $y < self::HEIGHT; $y++) {
            $lineArray = [];
            for ($x = 1; $x < self::WIDTH; $x++) {
                if ($y%2 == 0 && $x%2 == 0){
                    $lineArray[] = new Cell($y-1, $x-1, Cell::BLANK);
                } else {
                    $lineArray[] = new Cell($y-1, $x-1,  Cell::WALL);
                }
            }
            $this->matrix[] = $lineArray;
        }
        $this->matrix[1][1] = new Cell(1, 1, Cell::BLANK);
        return true;
    }

    public function generate(Cell $currentCell)
    {
        $startCell = $currentCell;
        do{

            $neighbours = $this->getNeighbours($startCell);
            $randomNeighbour = $neighbours[array_rand($neighbours)];
            if (isset($randomNeighbour)){
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
        do{
            $neighbours = $this->getNeighbours($currentCell);
            $randomNeighbour = $neighbours[array_rand($neighbours)];
            if (isset($randomNeighbour)){
                $this->visited[] = $currentCell;
                $currentCell = $randomNeighbour;
            } else {
                $visitedCell = array_pop($this->visited);
                if ($visitedCell) {
                    $currentCell = $visitedCell;
                }
            }
        }while($currentCell->x != $endCell->x && $currentCell->y != $endCell->y);
        return 'SUCCESS';
    }

    public function getLeftBlankCell(Cell $cell)
    {
        $leftCell = $this->matrix[$cell->y][$cell->x-2];
        if (isset($leftCell) && $leftCell->type == Cell::BLANK){
            return $leftCell;
        }
        return false;
    }

    public function getRightBlankCell(Cell $cell)
    {
        $rightCell = $this->matrix[$cell->y][$cell->x+2];
        if (isset($rightCell) && $rightCell->type == Cell::BLANK){
            return $rightCell;
        }
        return false;
    }

    public function getTopBlankCell(Cell $cell)
    {
        $topCell = $this->matrix[$cell->y+2][$cell->x];
        if (isset($topCell) && $topCell->type == Cell::BLANK){
            return $topCell;
        }
        return false;
    }

    public function getBottomBlankCell(Cell $cell)
    {
        $bottomCell = $this->matrix[$cell->y-2][$cell->x];
        if (isset($bottomCell) && $bottomCell->type == Cell::BLANK){
            return $bottomCell;
        }
        return false;
    }

    private function removeWall(Cell $fromCell, Cell $toCell){
        $xDiff = $toCell->x - $fromCell->x;
        $yDiff = $toCell->y - $fromCell->y;

        $addX = $xDiff != 0 ? $xDiff/abs($xDiff) : 0;
        $addY = $yDiff != 0 ? $yDiff/abs($yDiff) : 0;

        $wallX = $fromCell->x + $addX;
        $wallY = $fromCell->y + $addY;

        $newCell = new Cell($wallY, $wallX, Cell::VISITED);
        $fromCell->type = Cell::VISITED;
        $toCell->type = Cell::VISITED;
        $this->matrix[$wallY][$wallX] = $newCell;



        return true;
    }

    public function getNeighbours(Cell $cell):array {
        $arrCells = [];

        if ($this->getLeftBlankCell($cell)) $arrCells[]= $this->getLeftBlankCell($cell);
        if ($this->getRightBlankCell($cell)) $arrCells[]= $this->getRightBlankCell($cell);
        if ($this->getTopBlankCell($cell)) $arrCells[]= $this->getTopBlankCell($cell);
        if ($this->getBottomBlankCell($cell)) $arrCells[]= $this->getBottomBlankCell($cell);

        return $arrCells;
    }
}