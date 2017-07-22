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

/******************************************************************************
 * Function: b_xdir_top_show
 * Input   : $options[0] = date for the most recent links
 *                    hits for the most popular links
 *           $block['content'] = The optional above content
 *           $options[1]   = How many reviews are displayed
 *           $options[2]   = How many characters of title are displayed
 *           $options[3]   = Directory name
 *           $options[4]   = Checkbox value of whether to display empty block
 *           $options[5]   = Category to use
 * Output  : Returns the desired most recent or most popular links
 *****************************************************************************
 * @param $options
 * @return array|string
 */
function b_xdir_coup_show($options)
{
    //require_once XOOPS_ROOT_PATH.'/class/xoopstree.php';
    $mydirname = basename(dirname(__DIR__));
    require_once XOOPS_ROOT_PATH . '/modules/' . $mydirname . '/class/mxdirectorytree.php';

    global $xoopsDB, $xoopModuleConfig;
    $mytree = new MxdirectoryTree($xoopsDB->prefix('xdir_cat'), 'cid', 'pid');

    $mydirname = basename(dirname(__DIR__), 'a');
    require_once XOOPS_ROOT_PATH . '/modules/' . $mydirname . '/class/coupon.php';
    $myts = MyTextSanitizer::getInstance();
    //  require_once XOOPS_ROOT_PATH."/modules/" . $mydirname . "/header.php";
    $couponHandler = new XdirectoryCouponHandler($xoopsDB);

    $block = array();

    // now get subcats of this category
    if ($options[5] === 'All') {
        $catlist = 0;
    } else {
        $catlist   = array();
        $catlist[] = (int)$options[5];
        $tree      = $mytree->getChildTreeArray((int)$options[5], 'title ASC');
        foreach ($tree as $branch) {
            $catlist[] .= $branch['cid'];
        }
    }
    $coups = $couponHandler->getByCategory($catlist, (int)$options[1]);
    foreach ($coups as $key => $values) {
        if (!XOOPS_USE_MULTIBYTES) {
            if (strlen($coups[$key]['linkTitle']) >= $options[2]) {
                $coups[$key]['linkTitle'] = substr($coups[$key]['linkTitle'], 0, $options[2] - 1) . '...';
            }
        }
    }
    $block = $couponHandler->prepare2show($coups, true);
    for ($i = 0; $i < count($block); $i++) {
        $block[$i]['mydirname'] = $mydirname;
    }
    if (empty($block)) {
        $block = ($options[5] == 0) ? '' : array('ld' => '', 'cid' => '', 'image' => '', 'mydirname' => '', 'linkTitle' => '');
    }

    return $block;
}

/**
 * @param $options
 * @return string
 */
function b_xdir_coup_edit($options)
{
    global $xoopsDB;
    //require_once XOOPS_ROOT_PATH.'/class/xoopstree.php';
    $mydirname = basename(dirname(__DIR__));
    require_once XOOPS_ROOT_PATH . '/modules/' . $mydirname . '/class/mxdirectorytree.php';

    $mytree = new MxdirectoryTree($xoopsDB->prefix('xdir_cat'), 'cid', 'pid');
    $form   = '' . _MB_MXDIR_DISP . '&nbsp;';
    $form   .= "<input type='hidden' name='options[]' value='";

    switch ($options[0]) {
        case 'image':
            $form .= "image'";
            break;
        case 'text':
        default:
            $form .= "text'";
            break;
    }

    $form .= '>';
    $form .= "<input type='text' name='options[]' value='" . $options[1] . "'>&nbsp;" . _MB_MXDIR_LINKS . '';
    $form .= '&nbsp;<br>' . _MB_MXDIR_CHARS . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "'>&nbsp;" . _MB_MXDIR_LENGTH . '';
    $form .= "<input type='hidden' name='options[]' value='" . $options[3] . "'>";
    if ($options[4] == 1) {
        $ychk = 'checked';
        $nchk = '';
    } else {
        $ychk = '';
        $nchk = 'checked';
    }
    $form .= '<br><br>' . _MB_MXDIR_BLANK . '&nbsp;';
    $form .= "<input type='radio' $ychk name='options[]' value='1'>" . _YES;
    $form .= "<input type='radio' $nchk name='options[]' value='0'>" . _NO;

    $form .= '<br><br>' . _MB_MXDIR_SELECT_CAT . '&nbsp;';
    $tree = $mytree->getChildTreeArray(0, 'title ASC');
    $form .= "<select name='options[5]'>";
    $form .= "<option value='All'>" . _MB_MXDIR_ALLCATS;
    foreach ($tree as $branch) {
        $branch['prefix'] = substr($branch['prefix'], 0, -1);
        $branch['prefix'] = str_replace('.', '--', $branch['prefix']);
        $form             .= "<option value='" . $branch['cid'] . "'";
        $selopt           = ($options[5] == $branch['cid']) ? " selected='selected' " : '';
        $form             .= $selopt . '>' . $branch['prefix'] . $branch['title'];
    }
    $form .= '</select>';

    return $form;
}
