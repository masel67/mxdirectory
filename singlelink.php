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

include __DIR__ . '/header.php';

require_once XOOPS_ROOT_PATH . "/modules/$mydirname/class/coupon.php";
//require_once "include/functions.php";

global $xoopsModule;
$pathIcon16 = \Xmf\Module\Admin::iconUrl('', 16);

$myts = MyTextSanitizer::getInstance();// MyTextSanitizer object
//require_once XOOPS_ROOT_PATH."/class/xoopstree.php";
$mydirname = basename(__DIR__);
include XOOPS_ROOT_PATH . '/modules/' . $mydirname . '/class/mxdirectorytree.php';

$mytree = new MxdirectoryTree($xoopsDB->prefix('xdir_cat'), 'cid', 'pid');
$lid    = isset($_GET['lid']) ? (int)$_GET['lid'] : 0;
$cid    = isset($_GET['cid']) ? (int)$_GET['cid'] : 0;
if (!($xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid()))) {
    $sql = sprintf('UPDATE %s SET hits = hits+1 WHERE lid = %u AND STATUS > 0', $xoopsDB->prefix('xdir_links'), $lid);
    $xoopsDB->queryF($sql);
}
$GLOBALS['xoopsOption']['template_main'] = 'xdir_singlelink.tpl';
include XOOPS_ROOT_PATH . '/header.php';

$result = $xoopsDB->query('select l.lid, l.cid, l.title, l.address, l.address2, l.city, l.state, l.zip, l.country, l.mfhrs, l.sathrs, l.sunhrs, l.phone, l.fax, l.mobile, l.home, l.tollfree, l.email, l.url, l.admcontname, l.admcontnumb, l.logourl, l.status, l.date, l.hits, l.rating, l.votes, l.comments, l.premium, t.description from '
                          . $xoopsDB->prefix('xdir_links')
                          . ' l, '
                          . $xoopsDB->prefix('xdir_text')
                          . " t where l.lid=$lid and l.lid=t.lid and status>0");
list($lid, $cid, $ltitle, $address, $address2, $city, $state, $zip, $country, $mfhrs, $sathrs, $sunhrs, $phone, $fax, $mobile, $home, $tollfree, $email, $url, $admname, $admnumb, $logourl, $status, $time, $hits, $rating, $votes, $comments, $premium, $description) = $xoopsDB->fetchRow($result);

//Pretty Page Titles
$title = '';

$lvlopts = getPremiumOptions($premium);
if ($cid > 0) {
    $show   = 0;
    $min    = 0;
    $sql    = 'SELECT title FROM ' . $xoopsDB->prefix('xdir_cat') . " t where cid=$cid";
    $result = $xoopsDB->query($sql, $show, $min);
    $myrow  = $xoopsDB->fetchArray($result);
    $title  = ' - ' . $myts->htmlSpecialChars($myrow['title']);
}

$xoopsTpl->assign('xoops_pagetitle', $myts->htmlSpecialChars($xoopsModule->getVar('name')) . $myts->htmlSpecialChars($title) . ' - ' . $myts->htmlSpecialChars($ltitle));

$pathstring = "<a href='index.php'>" . _MD_MXDIR_MAIN . '</a> : ';
$pathstring .= $mytree->getNicePathFromId($cid, 'title', 'viewcat.php?op=');
//XHTML Compliance
$pathstring = preg_replace('/&c/', 'c', $pathstring);
$xoopsTpl->assign('category_path', $pathstring);
//modify listing
$showmod = $xoopsModuleConfig['showmod'];
$xoopsTpl->assign('showmod', $showmod);

$adminlink = '';
$admcont   = '';
if ($xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid())) {
    $xoopsTpl->assign('admin', 1);
    $adminlink = '<a href="' . XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/main.php?op=modLink&amp;lid=' . $lid . '"><img src="' . $pathIcon16 . '/edit.png"' . ' border="0" alt="' . _MD_MXDIR_EDITTHISLINK . '"></a>';
    if (trim($admname) != '') {
        $admcont = trim($admname) . ' - ';
        $admcont .= trim($admnumb) == '' ? _MD_MXDIR_UNKNOWN : trim($admnumb);
    }
}

$xoopsTpl->assign('admcont', $admcont);
$votestring = ($votes == 1) ? _MD_MXDIR_ONEVOTE : sprintf(_MD_MXDIR_NUMVOTES, $votes);
$xoopsTpl->assign('xoops_module_header', $xoops_module_header);

if ($xoopsModuleConfig['useshots'] == 1) {
    $xoopsTpl->assign('shotwidth', $xoopsModuleConfig['logo_maximgwidth']);
    $xoopsTpl->assign('tablewidth', $xoopsModuleConfig['logo_maximgwidth'] + 10);
    $xoopsTpl->assign('show_screenshot', true);
    $xoopsTpl->assign('lang_noscreenshot', _MD_MXDIR_NOSHOTS);
}

//require_once "include/functions.php";
$mfhrs  = displayTime($mfhrs);
$sathrs = displayTime($sathrs);
$sunhrs = displayTime($sunhrs);

$bizhrs  = array('1' => _MD_MXDIR_BUSMFHRSSHORT . $mfhrs, '2' => _MD_MXDIR_BUSSATHRSSHORT . $sathrs, '3' => _MD_MXDIR_BUSSUNHRSSHORT . $sunhrs);
$bnums   = array($phone, $fax, $mobile, $home, $tollfree);
$biznums = displaybiznums($bnums);

$xoopsTpl->assign('p1color', $xoopsModuleConfig['premium_listing1col']);
$xoopsTpl->assign('p2color', $xoopsModuleConfig['premium_listing2col']);
$xoopsTpl->assign('p3color', $xoopsModuleConfig['premium_listing3col']);
$xoopsTpl->assign('p4color', $xoopsModuleConfig['premium_listing4col']);
$xoopsTpl->assign('p5color', $xoopsModuleConfig['premium_listing5col']);

$path     = $mytree->getPathFromId($cid, 'title');
$path     = substr($path, 1);
$path     = str_replace('/', " <img src='" . XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . "/images/arrow.gif' board='0' alt=''> ", $path);
$new      = newlinkgraphic($time, $status);
$pop      = popgraphic($hits);
$ratingfl = (($rating / 2) - floor($rating / 2) < 0.5) ? (int)(floor($rating / 2) * 10) : (int)((floor($rating / 2) + .5) * 10);
$ratingfl = str_pad($ratingfl, 2, '0', STR_PAD_LEFT);
$rating   = "<img src='" . XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/images/ratings/rate' . $ratingfl . ".gif' alt='" . _MD_MXDIR_RATINGC . number_format($rating, 2) . "'> ";
//$couponHandler = xoops_getModuleHandler('coupon', $mydirname);
$couponHandler = new XdirectoryCouponHandler($GLOBALS['xoopsDB']);
//Adding record related template items
$xoopsTpl->assign('link', array(
    'coupons'      => $couponHandler->getCountByLink($lid),
    'id'           => $lid,
    'cid'          => $cid,
    'rating'       => $rating,
    'url'          => $url,
    'lvlopts'      => $lvlopts,
    'titletrim'    => $myts->htmlspecialchars($ltitle),
    'title'        => $myts->htmlspecialchars($ltitle) . $new . $pop,
    'address'      => $myts->htmlspecialchars($address),
    'address2'     => $myts->htmlspecialchars($address2),
    'city'         => $myts->htmlspecialchars($city),
    'state'        => $myts->htmlspecialchars($state),
    'zip'          => $myts->htmlSpecialChars($zip),
    'country'      => $myts->htmlSpecialChars($country),
    'bizhrs'       => $bizhrs,
    'biznums'      => $biznums,
    'email'        => $myts->htmlSpecialChars($email),
    'category'     => $path,
    'logourl'      => $myts->htmlSpecialChars($logourl),
    'updated'      => formatTimestamp($time, 'm'),
    'description'  => $myts->displayTarea($description, 0),
    'adminlink'    => $adminlink,
    'hits'         => $hits,
    'votes'        => $votestring,
    'comments'     => $comments,
    'premium'      => $premium,
    'mail_subject' => rawurlencode(sprintf(_MD_MXDIR_INTRESTLINK, $xoopsConfig['sitename'])),
    'mail_body'    => rawurlencode(sprintf(_MD_MXDIR_INTLINKFOUND, $xoopsConfig['sitename']) . ':  ' . XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/singlelink.php?lid=' . $lid)
));

//Adding non-record related template items
$xoopsTpl->assign('lang_description', _MD_MXDIR_DESCRIPTIONC);
$xoopsTpl->assign('lang_lastupdate', _MD_MXDIR_LASTUPDATEC);
$xoopsTpl->assign('lang_hits', _MD_MXDIR_HITSC);
$xoopsTpl->assign('lang_rating', _MD_MXDIR_RATINGC);
$xoopsTpl->assign('lang_ratethissite', _MD_MXDIR_RATETHISSITE);
$xoopsTpl->assign('lang_reportbroken', _MD_MXDIR_REPORTBROKEN);
$xoopsTpl->assign('lang_tellafriend', _MD_MXDIR_TELLAFRIEND);
$xoopsTpl->assign('lang_modify', _MD_MXDIR_MODIFY);
$xoopsTpl->assign('lang_category', _MD_MXDIR_CATEGORYC);
$xoopsTpl->assign('lang_visit', _MD_MXDIR_VISIT);
$xoopsTpl->assign('lang_comments', _COMMENTS);
$xoopsTpl->assign('lang_phone', _MD_MXDIR_BUSPHONE);
$xoopsTpl->assign('lang_fax', _MD_MXDIR_BUSFAX);
$xoopsTpl->assign('lang_mobile', _MD_MXDIR_BUSMOBILE);
$xoopsTpl->assign('lang_home', _MD_MXDIR_BUSHOME);
$xoopsTpl->assign('lang_tollfree', _MD_MXDIR_BUSTOLLFREE);
$xoopsTpl->assign('lang_email', _MD_MXDIR_BUSEMAIL);
$xoopsTpl->assign('lang_mfhrs', _MD_MXDIR_BUSMFHRSSHORT);
$xoopsTpl->assign('lang_sathrs', _MD_MXDIR_BUSSATHRSSHORT);
$xoopsTpl->assign('lang_sunhrs', _MD_MXDIR_BUSSUNHRSSHORT);

//alphalist function
$letters = letters();
$xoopsTpl->assign('letters', $letters);
//mid autodetect
$xoopsTpl->assign('xmid', $xoopsModule->getVar('mid'));
//Smarty directory autodetect
$xoopsTpl->assign('usealpha', $xoopsModuleConfig['usealpha']);
$xoopsTpl->assign('usesearch', $xoopsModuleConfig['usesearch']);
$smartydir = $xoopsModule->getVar('dirname');
$xoopsTpl->assign('smartydir', $smartydir);
//$xoopsTpl->assign('lang_url', _MD_MXDIR_BUSURL);
include XOOPS_ROOT_PATH . '/include/comment_view.php';
include XOOPS_ROOT_PATH . '/footer.php';
