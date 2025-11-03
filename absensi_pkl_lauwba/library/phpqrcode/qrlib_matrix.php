<?php
class QRmatrix
{
    public static function generate($text)
    {
        // Ini versi sangat sederhana dari QR matrix (bukan QR kompleks)
        // Tujuannya hanya untuk testing / simulasi visual QR.
        // Untuk produksi, sebaiknya gunakan library resmi "phpqrcode" full version.
        $len = strlen($text);
        $size = max(21, $len); // min size
        $matrix = [];

        srand(crc32($text));
        for ($y = 0; $y < $size; $y++) {
            $matrix[$y] = [];
            for ($x = 0; $x < $size; $x++) {
                $matrix[$y][$x] = rand(0, 1);
            }
        }
        srand();

        return $matrix;
    }
}
