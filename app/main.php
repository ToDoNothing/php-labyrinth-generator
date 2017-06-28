<?php
include 'Matrix.php';

$matrix = new Matrix();

$cell = new Cell(1,1, Cell::BLANK);

$arrCells = $matrix->generate($cell);

var_dump($arrCells);