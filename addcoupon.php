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

global $xoopsDB;
include __DIR__ . '/header.php';
include __DIR__ . '/class/coupon.php';
//require_once XOOPS_ROOT_PATH."/class/xoopstree.php";
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
require_once XOOPS_ROOT_PATH . '/include/xoopscodes.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

$mydirname = basename(__DIR__);
include XOOPS_ROOT_PATH . '/modules/' . $mydirname . '/class/mxdirectorytree.php';

$myts = MyTextSanitizer::getInstance(); // MyTextSanitizer object

$couponid = isset($_GET['couponid']) ? (int)$_GET['couponid'] : 0;

if ($couponid > 0) {
    $couponHandler = new XdirectoryCouponHandler($GLOBALS['xoopsDB']);
    $coupon        = $couponHandler->get($couponid);

    //    $couponHandler = xoops_getModuleHandler('coupon', $mydirname);
    //    $coupon =& $couponHandler->get($couponid);
    $lid = $coupon->getVar('lid');
    //    $myts = MyTextSanitizer::getInstance();
    $lbr = $coupon->getVar('lbr');
    $coupon->setVar('dohtml', 1);
    $coupon->setVar('dobr', $lbr);
    $descr   = $coupon->getVar('description', 'E');
    $image   = $coupon->getVar('image', 'E');
    $heading = $coupon->getVar('heading', 'E');
    $publish = $coupon->getVar('publish') > 0 ? $coupon->getVar('publish') : time();
    $expire  = $coupon->getVar('expire');
    if ($expire > 0) {
        $setexpire = 1;
    } else {
        $setexpire = 0;
        $expire    = time() + 3600 * 24 * 7;
    }
} else {
    $lid      = isset($_POST['lid']) ? (int)$_POST['lid'] : (isset($_GET['lid']) ? (int)$_GET['lid'] : 0);
    $couponid = isset($_POST['couponid']) ? $_POST['couponid'] : null;
    $descr    = isset($_POST['descr']) ? $_POST['descr'] : '';
    $publish  = isset($_POST['publish']) ? $_POST['publish'] : 0;
    $image    = isset($_POST['image']) ? $_POST['image'] : '';
    $expire   = isset($_POST['expire']) ? $_POST['expire'] : 0;
    $heading  = isset($_POST['heading']) ? $_POST['heading'] : '';
    $lbr      = isset($_POST['lbr']) ? $lbr : 0;
    if ($expire > 0) {
        $setexpire = 1;
    } else {
        $setexpire = 0;
        $expire    = time() + 3600 * 24 * 7;
    }
}

if (empty($xoopsUser) || !$xoopsUser->isAdmin($xoopsModule->mid()) || ($lid == 0 && empty($_POST['delete']))) {
    redirect_header('index.php', 3, _NOPERM);
    exit();
}

if (!empty($_POST['submit'])) {
    $couponHandler = new XdirectoryCouponHandler($GLOBALS['xoopsDB']);
    //    $couponHandler = xoops_getModuleHandler('coupon', $mydirname);
    if (isset($_POST['couponid'])) {
        $thiscoupon = $couponHandler->get($_POST['couponid']);
        $message    = _MD_MXDIR_COUPONEDITED;
    } else {
        $thiscoupon = $couponHandler->create();
        $message    = _MD_MXDIR_COUPONADDED;
    }
    $thiscoupon->setVar('description', $_POST['descr']);
    $thiscoupon->setVar('image', $_POST['image']);
    $thiscoupon->setVar('lid', $_POST['lid']);
    $thiscoupon->setVar('publish', strtotime($_POST['publish']['date']) + $_POST['publish']['time']);
    $lbr = isset($_POST['lbr']) ? $lbr : 0;
    $thiscoupon->setVar('lbr', $lbr);
    if (isset($_POST['expire_enable']) && ($_POST['expire_enable'] == 1)) {
        $thiscoupon->setVar('expire', strtotime($_POST['expire']['date']) + $_POST['expire']['time']);
    } else {
        $thiscoupon->setVar('expire', 0);
    }
    $thiscoupon->setVar('heading', $_POST['heading']);
    if ($couponHandler->insert($thiscoupon)) {
        redirect_header('singlelink.php?lid=' . $thiscoupon->getVar('lid'), 3, $message);
        exit();
    }
} elseif (!empty($_POST['delete'])) {
    if (!empty($_POST['ok'])) {
        if (empty($_POST['couponid'])) {
            redirect_header('index.php', 2, 'error');
            exit();
        }
        $couponHandler = new XdirectoryCouponHandler($GLOBALS['xoopsDB']);
        //        $couponHandler = xoops_getModuleHandler('coupon', $mydirname);
        $coupon = $couponHandler->get($_POST['couponid']);
        $lid    = $coupon->getVar('lid');
        if ($couponHandler->delete($coupon)) {
            redirect_header('singlelink.php?lid=' . $lid, 3, _MD_MXDIR_COUPONDELETED);
            exit();
        }
    } else {
        include XOOPS_ROOT_PATH . '/header.php';
        xoops_confirm(array('delete' => 'yes', 'couponid' => (int)$_POST['couponid'], 'ok' => 1), 'addcoupon.php', _MD_MXDIR_COUPONRUSURE);
        require_once XOOPS_ROOT_PATH . '/footer.php';
        exit();
    }
}
include XOOPS_ROOT_PATH . '/header.php';
include __DIR__ . '/include/couponform.php';
require_once XOOPS_ROOT_PATH . '/footer.php';
