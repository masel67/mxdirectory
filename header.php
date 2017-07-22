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

require_once __DIR__ . '/../../mainfile.php';

//$whatdir = basename ( __DIR__ ) ;
//if (preg_match("#[\]#", $whatdir)) {
//	$split = preg_split('/[^\]/',$whatdir);
//} else {
//	$split = preg_split('/[^/]/',$whatdir);
//}
//$count = count($split) - 1;
//$mydirname = $split[$count];

$mydirname = basename(__DIR__);

include XOOPS_ROOT_PATH . '/modules/' . $mydirname . '/include/functions.php';

$xoops_module_header = '<link rel="stylesheet" type="text/css" href="' . XOOPS_URL . '/modules/' . $mydirname . '/images/style.css">';

if (empty($xoopsModuleConfig['rss_enable'])) {
    $xoops_module_header .= '
	<link rel="alternate" type="application/rss+xml" title="' . $mydirname . '" href="' . XOOPS_URL . '/modules/' . $mydirname . '/mxdir_rss.php">
	';
}
