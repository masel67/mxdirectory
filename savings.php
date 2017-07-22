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

include __DIR__ . '/../../mainfile.php';
include __DIR__ . '/header.php';
$mydirname = basename(__DIR__);
//added global to test coupon under 2.2
global $xoopsDB;
require_once __DIR__ . '/class/coupon.php';

$lid = isset($_GET['lid']) ? $_GET['lid'] : 0;
$cid = isset($_GET['cid']) ? $_GET['cid'] : 0;

$GLOBALS['xoopsOption']['template_main'] = 'xdir_savings.tpl';
include XOOPS_ROOT_PATH . '/header.php';

$couponHandler = new XdirectoryCouponHandler($GLOBALS['xoopsDB']);

$xoopsTpl->assign('xoops_module_header', $xoops_module_header);

if ($lid) {
    $categories =& $couponHandler->getByLink($lid);
} else {
    $categories =& $couponHandler->getByCategory($cid);
}
$xoopsTpl->assign('categories', $couponHandler->prepare2show($categories));
if ($xoopsUser) {
    $xoopsTpl->assign('admin', $xoopsUser->isAdmin($xoopsModule->mid()));
}
//Smarty directory autodetect
$xoopsTpl->assign('smartydir', $mydirname);

include XOOPS_ROOT_PATH . '/footer.php';
