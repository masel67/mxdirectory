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

/**
 * @param $category
 * @param $item_id
 * @return array
 */
function xdir_notify_iteminfo($category, $item_id)
{
    global $xoopsModule, $xoopsModuleConfig, $xoopsConfig;
    $mydirname = basename(dirname(__DIR__), 'a');

    if (empty($xoopsModule) || $xoopsModule->getVar('dirname') != $mydirname) {
        $moduleHandler = xoops_getHandler('module');
        $module        = $moduleHandler->getByDirname($mydirname);
        $configHandler = xoops_getHandler('config');
        $config        = $configHandler->getConfigsByCat(0, $module->getVar('mid'));
    } else {
        $module =& $xoopsModule;
        $config =& $xoopsModuleConfig;
    }

    //require_once XOOPS_ROOT_PATH . '/modules/' . $module->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/main.php';

    global $xoopsDB;
    $item = array();

    switch ($category) {
        case 'global':
            $item['name'] = '';
            $item['url']  = '';
            break;
        case 'category':
            // Assume we have a valid category id
            $sql          = 'SELECT title FROM ' . $xoopsDB->prefix('xdir_cat') . ' WHERE cid = ' . $item_id;
            $result       = $xoopsDB->query($sql); // TODO: error check
            $result_array = $xoopsDB->fetchArray($result);
            $item['name'] = $result_array['title'];
            $item['url']  = XOOPS_URL . '/modules/' . $mydirname . '/viewcat.php?cid=' . $item_id;
            break;
        case 'link':
            // Assume we have a valid link id
            $sql          = 'SELECT cid,title FROM ' . $xoopsDB->prefix('xdir_links') . ' WHERE lid = ' . $item_id;
            $result       = $xoopsDB->query($sql); // TODO: error check
            $result_array = $xoopsDB->fetchArray($result);
            $item['name'] = $result_array['title'];
            $item['url']  = XOOPS_URL . '/modules/' . $mydirname . '/singlelink.php?cid=' . $result_array['cid'] . '&amp;lid=' . $item_id;
            break;
        default:
    }

    return $item;
}
