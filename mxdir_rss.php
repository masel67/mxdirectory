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

//
//  To involk:  http://<site/module url>/xdir_rss.php
//  Returns:    RSS 2.0 feed with 5 most recent entries
//
//  Command Line Options:
//      op    =  hits        most popular listings
//               rand        random listings
//               rank        top ranked listings
//               date        most recent listings <default>
//      catid =  <integer>   category to use for listings
//                            <default = 0 - All categories>
//      qty   =  <integer>   number of items to return*
//                            <default = 5 ($opsep)>
//                            * to maximize caching the number is a rounded
//                              to the nearest multiple of 5 ($opsep)
//
//  ------------------------------------------------------------------------ //
require_once __DIR__ . '/../../mainfile.php';
$mydirname = basename(__DIR__);

require_once XOOPS_ROOT_PATH . '/class/template.php';
//require_once XOOPS_ROOT_PATH.'/class/xoopstree.php';
$mydirname = basename(__DIR__);
include XOOPS_ROOT_PATH . '/modules/' . $mydirname . '/class/mxdirectorytree.php';
global $xoopsDB, $xoopsConfig;

//What to show in RSS listing
$op = isset($_GET['op']) ? $_GET['op'] : 'date';
//category to use
$opcid = (isset($_GET['catid']) && (is_numeric($_GET['catid']) && $_GET['catid'] > 0)) ? (int)$_GET['catid'] : 0;
//granularity for number of items to show
$rss_qkey = explode(',', _MD_MXDIR_RSSQTY);
$opsep    = $rss_qkey[0];
//number of items to show
$opqty  = (isset($_GET['qty']) && is_numeric($_GET['qty']) && ($_GET['qty'] >= 0)) ? (int)$_GET['qty'] : $opsep;
$getqty = (int)($opsep * ceil($opqty / $opsep));

$mytree = new MxdirectoryTree($xoopsDB->prefix('xdir_cat'), 'cid', 'pid');

switch ($op) {
    case 'hits':
        $hitchk     = ' AND hits>0 ';
        $ltype      = ' - ' . _MD_MXDIR_POPULARITY;
        $limit      = ' LIMIT 0,' . $getqty;
        $orderby    = 'hits DESC';
        $rand_limit = '';
        $cache_time = 86400;
        break;
    case 'rand':  // random listings
        $hitchk     = '';
        $ltype      = '';
        $limit      = '';
        $orderby    = 'NULL';
        $rand_limit = $getqty;
        $cache_time = 43200;
        break;
    case 'rank':
        // order by rank and votes
        $hitchk     = '';
        $ltype      = ' - ' . _MD_MXDIR_RATING;
        $limit      = ' LIMIT 0,' . $getqty;
        $orderby    = 'votes DESC';
        $rand_limit = '';
        $cache_time = 86400;
        break;
    case 'date':
    default:
        $hitchk     = '';
        $ltype      = ' - ' . _MD_MXDIR_DATE;
        $limit      = ' LIMIT 0,' . $getqty;
        $orderby    = 'date DESC';
        $rand_limit = '';
        $cache_time = 86400;
        $op         = 'date';
        break;
}

$pgcacheid = $op . $opcid . $getqty;  //calc a page cache id for smarty

if ($opcid == 0) {
    $dispcat = '';
    $start   = 0;
} else {
    $start   = $opcid;
    $tree    = $mytree->getChildTreeArray($start, 'title ASC');
    $dispcat = ' AND ((cid = ' . $opcid . ')';
    $dispcat .= ' OR (cidalt1 = ' . $opcid . ')';
    $dispcat .= ' OR (cidalt2 = ' . $opcid . ')';
    $dispcat .= ' OR (cidalt3 = ' . $opcid . ')';
    $dispcat .= ' OR (cidalt4 = ' . $opcid . ')';
    foreach ($tree as $branch) {
        $dispcat .= ' OR (cid = ' . $branch['cid'] . ')';
        $dispcat .= ' OR (cidalt1 = ' . $branch['cid'] . ')';
        $dispcat .= ' OR (cidalt2 = ' . $branch['cid'] . ')';
        $dispcat .= ' OR (cidalt3 = ' . $branch['cid'] . ')';
        $dispcat .= ' OR (cidalt4 = ' . $branch['cid'] . ')';
    }
    $dispcat .= ')';
}

if (function_exists('mb_http_output')) {
    $enctype = mb_internal_encoding();
    mb_http_output('UTF-8');
}
//header ('Content-Type:application/rss+xml;charset=UTF-8');
header('Content-Type:text/xml; charset=utf-8');
$rsstpl = new XoopsTpl();
$rsstpl->xoops_setCaching(2);
$rsstpl->xoops_setCacheTime($cache_time);
if (!$rsstpl->is_cached('db:xdir_rss.tpl', $pgcacheid)) {
    $sql    = 'SELECT l.lid, l.cid, l.title, l.logourl, l.date, l.hits, t.description';
    $sql    .= ' FROM ' . $xoopsDB->prefix('xdir_links') . ' l, ' . $xoopsDB->prefix('xdir_text') . ' t';
    $sql    .= ' WHERE (status>0' . $hitchk . $dispcat . ') AND (l.lid=t.lid)';
    $sql    .= ' ORDER BY ' . $orderby;
    $sql    .= $limit;
    $result = $xoopsDB->query($sql);
    $rsstpl->assign('channel_title', xoops_utf8_encode(htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)));
    $rsstpl->assign('channel_link', XOOPS_URL . '/modules/' . $mydirname . '/');
    $rsstpl->assign('channel_desc', xoops_utf8_encode(htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES)));
    $rsstpl->assign('channel_lastbuild', formatTimestamp(time(), 'rss'));
    $rsstpl->assign('channel_webmaster', $xoopsConfig['adminmail']);
    $rsstpl->assign('channel_editor', $xoopsConfig['adminmail']);
    $rsstpl->assign('channel_category', _MD_MXDIR_DIRHEADER . $ltype);
    $rsstpl->assign('channel_generator', 'MX-Directory');
    $rsstpl->assign('channel_language', _LANGCODE);
    if (file_exists(XOOPS_ROOT_PATH . '/images/logo.gif')) {
        $rsstpl->assign('image_url', XOOPS_URL . '/images/logo.gif');
        $imgsz = getimagesize(XOOPS_ROOT_PATH . '/images/logo.gif');
        if (empty($imgsz[0])) {
            $width = 88;
        } else {
            $width = ($imgsz[0] > 144) ? 144 : $imgsz[0];
        }
        if (empty($imgsz[1])) {
            $height = 31;
        } else {
            $height = ($imgsz[1] > 400) ? 400 : $imgsz[1];
        }
        $rsstpl->assign('image_width', $width);
        $rsstpl->assign('image_height', $height);
    } else {
        $rsstpl->assign('image_url', '');
    }

    if ($rows = $xoopsDB->getRowsNum($result)) {
        $lstcount = 0;
        $items    = array();

        while (list($lid, $cid, $title, $logourl, $date, $hits, $descr) = $xoopsDB->fetchRow($result)) {
            $linkurl = XOOPS_URL . '/modules/' . $mydirname . '/singlelink.php?lid=' . $lid;
            $guid    = (trim($logourl) != '') ? XOOPS_URL . '/modules/' . $mydirname . '/images/shots/' . xoops_utf8_encode(htmlspecialchars($logourl)) : XOOPS_URL . '/images/logo.gif';

            if (trim($descr) != '') {
                //Strip html & bb codes
                $descr = strip_tags($descr);
                $descr = preg_replace("/\[(.+?)\/\]/", '', $descr);
                $descr = xoops_utf8_encode(htmlspecialchars($descr, ENT_QUOTES));
            } else {
                $descr = xoops_utf8_encode(htmlspecialchars(' ', ENT_QUOTES));
            }
            $items[] = array(
                'title'       => xoops_utf8_encode(htmlspecialchars($title, ENT_QUOTES)),
                'link'        => $linkurl,
                'guid'        => $guid,
                'pubdate'     => formatTimestamp($date, 'rss'),
                'description' => $descr
            );
            $lstcount++;
        }

        // now check to see if random
        if (($op === 'rand') and ($rand_limit < $lstcount)) {
            $rand_ret = array();
            $rand_key = array_rand($items, $rand_limit);
            if (is_array($rand_key)) {
                foreach ($rand_key as $idx) {
                    $rand_ret[] = $items[$idx];
                }
            } else {
                $rand_ret[] = $items[$rand_key];
            }
            $items[] = $rand_ret;
        }
        $rsstpl->assign('items', $items);
    }
}

//$rsstpl->clear_cache('db:system_rss.tpl',$pgcacheid);
//$rsstpl->clear_cache('db:xdir_rss.tpl',$pgcacheid);
$rsstpl->display('db:xdir_rss.tpl', $pgcacheid);
//$rsstpl->display('db:system_rss.tpl',$pgcacheid);
if (isset($enctype) && !($enctype === false)) {
    mb_internal_encoding($enctype);
}
