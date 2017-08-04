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
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$myts = MyTextSanitizer::getInstance(); // MyTextSanitizer object

if (!empty($HTTP_POST_VARS['submit'])) {
    $eh = new ErrorHandler; //ErrorHandler object
    if (empty($xoopsUser)) {
        $ratinguser = 0;
    } else {
        $ratinguser = $xoopsUser->getVar('uid');
    }

    //Make sure only 1 anonymous from an IP in a single day.
    $anonwaitdays = 1;
    $ip           = getenv('REMOTE_ADDR');
    $lid          = (int)$HTTP_POST_VARS['lid'];
    $cid          = (int)$HTTP_POST_VARS['cid'];
    $rating       = (int)$HTTP_POST_VARS['rating'];

    // Check if Rating is Null
    if ($rating == '--') {
        redirect_header('ratelink.php?cid=' . $cid . '&amp;lid=' . $lid . '', 4, _MD_MXDIR_NORATING);
        exit();
    }

    // Check if Link POSTER is voting (UNLESS Anonymous users allowed to post)
    if ($ratinguser != 0) {
        $result = $xoopsDB->query('select submitter from ' . $xoopsDB->prefix('xdir_links') . " where lid=$lid");
        while (list($ratinguserDB) = $xoopsDB->fetchRow($result)) {
            if ($ratinguserDB == $ratinguser) {
                redirect_header('index.php', 4, _MD_MXDIR_CANTVOTEOWN);
                exit();
            }
        }

        // Check if REG user is trying to vote twice.
        $result = $xoopsDB->query('select ratinguser from ' . $xoopsDB->prefix('xdir_votedata') . " where lid=$lid");
        while (list($ratinguserDB) = $xoopsDB->fetchRow($result)) {
            if ($ratinguserDB == $ratinguser) {
                redirect_header('index.php', 4, _MD_MXDIR_VOTEONCE2);
                exit();
            }
        }
    } else {

        // Check if ANONYMOUS user is trying to vote more than once per day.
        $yesterday = (time() - (86400 * $anonwaitdays));
        $result    = $xoopsDB->query('select count(*) FROM ' . $xoopsDB->prefix('xdir_votedata') . " WHERE lid=$lid AND ratinguser=0 AND ratinghostname = '$ip' AND ratingtimestamp > $yesterday");
        list($anonvotecount) = $xoopsDB->fetchRow($result);
        if ($anonvotecount > 0) {
            redirect_header('index.php', 4, _MD_MXDIR_VOTEONCE2);
            exit();
        }
    }
    if ($rating > 10) {
        $rating = 10;
    }

    //All is well.  Add to Line Item Rate to DB.
    $newid    = $xoopsDB->genId($xoopsDB->prefix('xdir_votedata') . '_ratingid_seq');
    $datetime = time();
    $sql      = sprintf("INSERT INTO %s (ratingid, lid, ratinguser, rating, ratinghostname, ratingtimestamp) VALUES (%u, %u, %u, %u, '%s', %u)", $xoopsDB->prefix('xdir_votedata'), $newid, $lid, $ratinguser, $rating, $ip, $datetime);
    $xoopsDB->query($sql) || $eh->show('0013');

    //All is well.  Calculate Score & Add to Summary (for quick retrieval & sorting) to DB.
    updaterating($lid);
    $ratemessage = _MD_MXDIR_VOTEAPPRE . '<br>' . sprintf(_MD_MXDIR_THANKURATE, $xoopsConfig[sitename]);
    redirect_header('index.php', 2, $ratemessage);
    exit();
} else {
    $GLOBALS['xoopsOption']['template_main'] = 'xdir_ratelink.tpl';
    include XOOPS_ROOT_PATH . '/header.php';
    $lid    = isset($_GET['lid']) ? (int)$_GET['lid'] : 0;
    $cid    = isset($_GET['cid']) ? (int)$_GET['cid'] : 0;
    $result = $xoopsDB->query('select title from ' . $xoopsDB->prefix('xdir_links') . " where lid=$lid");
    list($title) = $xoopsDB->fetchRow($result);
    $xoopsTpl->assign('link', array('id' => $lid, 'cid' => $cid, 'title' => $myts->htmlSpecialChars($title)));
    $xoopsTpl->assign('lang_voteonce', _MD_MXDIR_VOTEONCE);
    $xoopsTpl->assign('lang_ratingscale', _MD_MXDIR_RATINGSCALE);
    $xoopsTpl->assign('lang_beobjective', _MD_MXDIR_BEOBJECTIVE);
    $xoopsTpl->assign('lang_donotvote', _MD_MXDIR_DONOTVOTE);
    $xoopsTpl->assign('lang_rateit', _MD_MXDIR_RATEIT);
    $xoopsTpl->assign('lang_cancel', _CANCEL);
    //Smarty directory autodetect
    $smartydir = $xoopsModule->getVar('dirname');
    $xoopsTpl->assign('smartydir', $smartydir);
    include XOOPS_ROOT_PATH . '/footer.php';
}
