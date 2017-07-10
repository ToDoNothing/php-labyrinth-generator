<?php
include 'Matrix.php';
ini_set('memory_limit', $argv[3] ? (int)$argv[3] . 'M' :'256M');

$labyrinthHeigth = $argv[1] ? $argv[1] : 100;
$labyrinthWidth = $argv[2] ? $argv[2] : 100;

$matrix = new Matrix($labyrinthHeigth, $labyrinthWidth);

$cell = new Cell(1, 1, Cell::BLANK);

$matrix->generate($matrix->matrix[1][1]);
$endCell = new Cell($labyrinthHeigth - 2, $labyrinthWidth - 2, Cell::BLANK);
echo $matrix->walk($cell, $endCell);

$im = imagecreate($labyrinthWidth - 1, $labyrinthHeigth - 1);

$black = imagecolorallocate($im, 0, 0, 0);

$white = imagecolorallocate($im, 255, 255, 255);
$red = imagecolorallocate($im, 255, 0, 0);
$blue = imagecolorallocate($im, 0, 0, 255);

foreach ($matrix->matrix as $keyY => $y) {
    /**@var Cell $x */
    foreach ($y as $keyX => $x) {
        if ($x->type == Cell::VISITED) {
            imagesetpixel($im, $keyX, $keyY, $white);
        } elseif ($x->type == Cell::DEAD_BLOCK) {
            imagesetpixel($im, $keyX, $keyY, $blue);
        } elseif ($x->type == Cell::WALK_VISITED) {
            imagesetpixel($im, $keyX, $keyY, $red);
        }
    }
}

imagepng($im, 'result.png');

imagedestroy($im);