<?php
include 'Matrix.php';

$matrix = new Matrix();

$cell = new Cell(1,1, Cell::BLANK);

$arrCells = $matrix->generate($cell);


$im = imagecreate(Matrix::WIDTH, Matrix::HEIGHT);

$black = imagecolorallocate($im, 0, 0, 0);

$white = imagecolorallocate($im, 255, 255, 255);

foreach ($matrix->matrix as $keyY=>$y){
    /**@var Cell $x*/
    foreach ($y as $keyX=>$x){
        if ( $x->type == Cell::VISITED ){
            imagesetpixel($im, $keyX, $keyY, $white);
        }
    }
}

imagepng($im, 'result.png');

imagedestroy($im);

var_dump($arrCells);