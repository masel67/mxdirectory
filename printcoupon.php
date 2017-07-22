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
include XOOPS_ROOT_PATH . '/header.php';
$mydirname = basename(__DIR__);
global $xoopsTpl;
$coupid = isset($_GET['coupid']) ? (int)$_GET['coupid'] : 0;
if (!($coupid > 0)) {
    redirect_header('index.php');
}

/**
 * @param $coupid
 */
function PrintPage($coupid)
{
    global $xoopsModule, $xoopsTpl, $xoopsModuleConfig, $mydirname;
    include __DIR__ . '/class/coupon.php';
    $couponHandler = new XdirectoryCouponHandler($GLOBALS['xoopsDB']);

    //    $couponHandler = xoops_getModuleHandler('coupon', $mydirname);
    $couponHandler->increment($coupid);
    $coupon     = $couponHandler->getLinkedCoupon($coupid);
    $coupon_arr =& $couponHandler->prepare2show($coupon);
    $xoopsTpl->assign('coupon_footer', $xoopsModuleConfig['coupon_footer']);
    $xoopsTpl->assign('coupon', $coupon_arr[$coupon[0]['cid']]['coupons'][0]);
    //    $xoopsTpl->template_dir = XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname();
    $xoopsTpl->display('db:xdir_print_savings.tpl');
}

//Smarty directory autodetect
$smartydir = $mydirname;
$xoopsTpl->assign('smartydir', $smartydir);
PrintPage($coupid);
