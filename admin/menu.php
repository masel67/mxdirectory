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

$moduleDirName = basename(dirname(__DIR__));

if (false !== ($moduleHelper = Xmf\Module\Helper::getHelper($moduleDirName))) {
} else {
    $moduleHelper = Xmf\Module\Helper::getHelper('system');
}
$adminObject = \Xmf\Module\Admin::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
//$pathModIcon32 = $moduleHelper->getModule()->getInfo('modicons32');

$moduleHelper->loadLanguage('modinfo');

$adminObject            = array();
$i                      = 0;
$adminmenu[$i]['title'] = _AM_MODULEADMIN_HOME;
$adminmenu[$i]['link']  = 'admin/index.php';
$adminmenu[$i]['icon']  = $pathIcon32 . '/home.png';
$i++;

$adminmenu[$i]['title'] = _MI_MXDIR_ADMENU1;
$adminmenu[$i]['link']  = 'admin/main.php?op=xdir';
$adminmenu[$i]['icon']  = $pathIcon32 . '/manage.png';
$i++;
$adminmenu[$i]['title'] = _MI_MXDIR_ADMENU9;
$adminmenu[$i]['link']  = 'admin/main.php?op=multicat';
$adminmenu[$i]['icon']  = $pathIcon32 . '/category.png';
$i++;
$adminmenu[$i]['title'] = _MI_MXDIR_ADMENU2;
$adminmenu[$i]['link']  = 'admin/main.php?op=linksConfigMenu';
$adminmenu[$i]['icon']  = $pathIcon32 . '/view_text.png';
$i++;
$adminmenu[$i]['title'] = _MI_MXDIR_ADMENU6;
$adminmenu[$i]['link']  = 'admin/coupon.php?op=menu';
$adminmenu[$i]['icon']  = $pathIcon32 . '/discount.png';
$i++;
$adminmenu[$i]['title'] = _MI_MXDIR_ADMENU3;
$adminmenu[$i]['link']  = 'admin/main.php?op=listNewLinks';
$adminmenu[$i]['icon']  = $pathIcon32 . '/submittedlink.png';
$i++;
$adminmenu[$i]['title'] = _MI_MXDIR_ADMENU4;
$adminmenu[$i]['link']  = 'admin/main.php?op=listBrokenLinks';
$adminmenu[$i]['icon']  = $pathIcon32 . '/brokenlink.png';
$i++;
$adminmenu[$i]['title'] = _MI_MXDIR_ADMENU5;
$adminmenu[$i]['link']  = 'admin/main.php?op=listModReq';
$adminmenu[$i]['icon']  = $pathIcon32 . '/modifiedlink.png';
//$i++;
//$adminmenu[$i]['title'] = _MI_MXDIR_ADMENU10;
//$adminmenu[$i]['link'] = "admin/myblocksadmin.php";
//$adminmenu[$i]["icon"]  = $pathIcon32 . '/block.png';
$i++;
$adminmenu[$i]['title'] = _AM_MODULEADMIN_ABOUT;
$adminmenu[$i]['link']  = 'admin/about.php';
$adminmenu[$i]['icon']  = $pathIcon32 . '/about.png';
