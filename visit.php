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
 * @author       Adam Frick, africk69@yahoo.com (based on mylinks module)
 */

include __DIR__ . '/../../mainfile.php';
$myts = MyTextSanitizer::getInstance(); // MyTextSanitizer object
$lid  = (int)$_GET['lid'];
$cid  = (int)$_GET['cid'];
$sql  = sprintf('UPDATE %s SET hits = hits+1 WHERE lid = %u AND STATUS > 0', $xoopsDB->prefix('xdir_links'), $lid);
$xoopsDB->queryF($sql);
$result = $xoopsDB->query('select url from ' . $xoopsDB->prefix('xdir_links') . " where lid=$lid and status>0");
list($url) = $xoopsDB->fetchRow($result);

if ($xoopsModuleConfig['frame'] != '') {
    header('Content-Type:text/html; charset=' . _CHARSET);
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
    echo '<html><head>
		<title>' . $xoopsConfig['sitename'] . "</title>
		</head>
		<frameset rows='70px,100%' cols='*' border='0' frameborder='0' framespacing='0' >
		<frame src='myheader.php?url=$url&amp;cid=$cid&amp;lid=$lid' frame name='xoopshead' scrolling='no' target='main' Noresize>
		<frame src='" . $myts->oopsHtmlSpecialChars($url) . "' frame name='main' scrolling='auto' target='Main'>
		</frameset></html>";
} else {
    echo "<html><head><meta http-equiv=\"Refresh\" content=\"0; URL=" . $myts->oopsHtmlSpecialChars($url) . "\"></meta></head><body></body></html>";
}
exit();
