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

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

/**
 * @param $inval
 * @param $goodkey
 * @return bool|string
 */
function mx_security_check($inval, $goodkey)
{
    $retval = false;
    $code   = mx_calc_security($goodkey);
    if ($code) {
        $retval = ($code == $inval) ? $code : false;
    }

    return $retval;
}

/**
 * @param $rnd_num
 * @return bool|string
 */
function mx_calc_security($rnd_num)
{
    global $xoopsModule;
    $mydirname = basename(dirname(__DIR__), 'a');

    $retval = false;
    if ($rnd_num) {
        if (empty($xoopsModule) || $xoopsModule->getVar('dirname') != $mydirname) {
            $moduleHandler = xoops_getHandler('module');
            $module        = $moduleHandler->getByDirname($mydirname);
        } else {
            $module =& $xoopsModule;
        }
        $smid    = $module->getVar('mid');
        $datekey = date('F j');
        $rcode   = hexdec(md5($_SERVER['HTTP_USER_AGENT'] . $rnd_num . $smid . $datekey));
        $retval  = substr($rcode, 2, 6);
    }

    return $retval;
}
