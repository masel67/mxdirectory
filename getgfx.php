<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    {@link https://xoops.org/ XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package
 * @since
 * @author       XOOPS Development Team
 */

include __DIR__ . '/header.php';
include __DIR__ . '/include/securitycheck.php';

$random_num = (!isset($_GET['random_num']) || (int)($_GET['random_num'] == 0)) ? die() : (int)$_GET['random_num'];
$gd         = isset($_GET['gd']) ? (int)$_GET['gd'] : 0;

$code = mx_calc_security($random_num);

$min_font_sz     = 3;        // minimum font size allowed
$max_font_sz     = 5;        // maximum font size allowed
$img_height_mult = 1.5;    // height of image - multiplier * font height
$img_extend      = 2;        // number of additional chars to extend image

$str_start_pos = $img_extend * 0.25;    // horiz. center string in image

//
$img_width  = imagefontwidth($max_font_sz) * (strlen($code) + (int)$img_extend);
$img_height = (int)(imagefontheight($max_font_sz) * $img_height_mult);
$xoff       = imagefontwidth((int)$max_font_sz * $str_start_pos);

switch ($gd) {
    case 2:
        $img = imagecreatetruecolor($img_width, $img_height);
        break;
    case 1:
        $img = imagecreate($img_width, $img_height);
        break;
    default:
        die();
}

$bg    = imagecolorallocate($img, 255, 255, 255);
$black = imagecolorallocate($img, 76, 76, 76);
$len   = strlen($code);

$xpos        = $xoff;
$bdr_keepout = 0.1;

for ($i = 0; $i < $len; $i++) {
    $font_size = rand($min_font_sz, $max_font_sz);
    $xpos      += imagefontwidth($font_size);

    $yoff_max = $img_height - (int)((1 + $bdr_keepout) * imagefontheight($font_size));
    $yoff_min = (int)($bdr_keepout * imagefontheight($font_size));

    $ypos = rand($yoff_min, $yoff_max);
    $vert = false;
    //
    // UNTESTED FEATURE - On servers using GD2
    // You can uncomment the following line to also display chars vertically
    //	$vert = rand(1);
    if ($vert && ($gd == 2)) {
        imagecharup($img, $font_size, $xpos, $ypos, $code, $black);
    } else {
        imagechar($img, $font_size, $xpos, $ypos, $code, $black);
    }
    $code = substr($code, 1);
}
header('Content-Type: image/jpeg');
imagejpeg($img);
imagedestroy($img);
die();
