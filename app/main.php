<?php
include 'Matrix.php';
ini_set('memory_limit', '256M');
$matrix = new Matrix();

$cell = new Cell(1,1, Cell::BLANK);

$arrCells = $matrix->generate($matrix->matrix[1][1]);


$im = imagecreate(Matrix::WIDTH-1, Matrix::HEIGHT-1);

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
//$endCell = new Cell(Matrix::WIDTH-2,Matrix::HEIGHT-8, Cell::BLANK);
//echo $matrix->walk($cell,$endCell);