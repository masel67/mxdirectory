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
$myts = MyTextSanitizer::getInstance(); // MyTextSanitizer object

if (!empty($HTTP_POST_VARS['submit'])) {
    if (empty($xoopsUser)) {
        $sender = 0;
    } else {
        $sender = $xoopsUser->getVar('uid');
    }
    $lid = (int)$HTTP_POST_VARS['lid'];
    $ip  = getenv('REMOTE_ADDR');
    if ($sender != 0) {
        // Check if REG user is trying to report twice.
        $result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('xdir_broken') . ' WHERE lid=' . $lid . ' AND sender=' . $sender . '');
        list($count) = $xoopsDB->fetchRow($result);
        if ($count > 0) {
            redirect_header('index.php', 2, _MD_MXDIR_ALREADYREPORTED);
            exit();
        }
    } else {
        // Check if the sender is trying to vote more than once.
        $result = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('xdir_broken') . " WHERE lid=$lid AND ip = '$ip'");
        list($count) = $xoopsDB->fetchRow($result);
        if ($count > 0) {
            redirect_header('index.php', 2, _MD_MXDIR_ALREADYREPORTED);
            exit();
        }
    }
    $newid = $xoopsDB->genId($xoopsDB->prefix('xdir_broken') . '_reportid_seq');
    $sql   = sprintf("INSERT INTO %s (reportid, lid, sender, ip) VALUES (%u, %u, %u, '%s')", $xoopsDB->prefix('xdir_broken'), $newid, $lid, $sender, $ip);
    $xoopsDB->query($sql) or exit();
    $tags                      = array();
    $tags['BROKENREPORTS_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/main.php?op=listBrokenLinks';
    $notificationHandler       = xoops_getHandler('notification');
    $notificationHandler->triggerEvent('global', 0, 'link_broken', $tags);
    redirect_header('index.php', 2, _MD_MXDIR_THANKSFORINFO);
    exit();
} else {
    $GLOBALS['xoopsOption']['template_main'] = 'xdir_brokenlink.tpl';
    include XOOPS_ROOT_PATH . '/header.php';
    $xoopsTpl->assign('lang_reportbroken', _MD_MXDIR_REPORTBROKEN);
    $xoopsTpl->assign('link_id', (int)$_GET['lid']);
    $xoopsTpl->assign('lang_thanksforhelp', _MD_MXDIR_THANKSFORHELP);
    $xoopsTpl->assign('lang_forsecurity', _MD_MXDIR_FORSECURITY);
    $xoopsTpl->assign('lang_cancel', _MD_MXDIR_CANCEL);
    //Smarty directory autodetect
    $smartydir = $xoopsModule->getVar('dirname');
    $xoopsTpl->assign('smartydir', $smartydir);
    require_once XOOPS_ROOT_PATH . '/footer.php';
}
