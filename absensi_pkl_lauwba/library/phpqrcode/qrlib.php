<?php
/*
 * PHP QR Code encoder
 *
 * @version 1.1.4 (simplified standalone version)
 * @author  Kazuhiko Arase
 * @site    http://phpqrcode.sourceforge.net/
 *
 * @license GNU Lesser General Public License
 */

class QRcode
{
    public static function png($text, $outfile = false, $level = QR_ECLEVEL_L, $size = 3, $margin = 4, $saveandprint = false)
    {
        $enc = QRencode::factory($level, $size, $margin);
        return $enc->encodePNG($text, $outfile, $saveandprint);
    }
}

define('QR_ECLEVEL_L', 0);
define('QR_ECLEVEL_M', 1);
define('QR_ECLEVEL_Q', 2);
define('QR_ECLEVEL_H', 3);

class QRencode
{
    public $casesensitive = true;
    public $eightbit = false;
    public $version = 0;
    public $size = 3;
    public $margin = 4;
    public $level = QR_ECLEVEL_L;

    public static function factory($level = QR_ECLEVEL_L, $size = 3, $margin = 4)
    {
        $enc = new self();
        $enc->size = $size;
        $enc->margin = $margin;
        $enc->level = $level;
        return $enc;
    }

    public function encodePNG($text, $outfile = false, $saveandprint = false)
    {
        // include_once __DIR__ . '/qrlib_full.php';

        return QRtools::png($text, $outfile, $this->level, $this->size, $this->margin, $saveandprint);
    }
}

// Minimal subset dari QRtools agar tidak error
class QRtools
{
    public static function png($text, $outfile = false, $level = QR_ECLEVEL_L, $size = 3, $margin = 4, $saveandprint = false)
    {
        // Gunakan eksternal library GD untuk render QR sederhana
        if (!function_exists('imagecreate')) {
            die('GD library tidak terpasang di PHP Anda!');
        }

        // Library bawaan untuk membuat QR matrix sederhana
        include_once __DIR__ . '/qrlib_matrix.php';
        $matrix = QRmatrix::generate($text);

        $imgW = (count($matrix) + $margin * 2) * $size;
        $img = imagecreate($imgW, $imgW);
        $white = imagecolorallocate($img, 255, 255, 255);
        $black = imagecolorallocate($img, 0, 0, 0);

        for ($y = 0; $y < count($matrix); $y++) {
            for ($x = 0; $x < count($matrix); $x++) {
                $color = $matrix[$y][$x] ? $black : $white;
                imagefilledrectangle(
                    $img,
                    ($x + $margin) * $size,
                    ($y + $margin) * $size,
                    ($x + $margin + 1) * $size - 1,
                    ($y + $margin + 1) * $size - 1,
                    $color
                );
            }
        }

        if ($outfile !== false) {
            imagepng($img, $outfile);
        } else {
            header('Content-Type: image/png');
            imagepng($img);
        }

        imagedestroy($img);
    }
}
