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
 * @author       Block added by: Tripmon & ZySpec for mx-directory
 */

/******************************************************************************
 * Function: b_xdir_categories
 * Input   : $options[0] = Include Subcategories (1=yes, 0=no)
 *           $options[1] = Horizontal Menu (1=yes, 0=no)
 * Output  : Returns the links to categories
 ******************************************************************************/
$mydirname = basename(dirname(__DIR__));
//include XOOPS_ROOT_PATH."/modules/" . $mydirname . "/class/mxdirectorytree.php";

/**
 * @param $options
 * @return array
 */
function b_xdir_categories($options)
{
    //require_once XOOPS_ROOT_PATH.'/class/xoopstree.php';
    //  $mydirname = basename ( dirname(__DIR__ ) ) ;
    //  include XOOPS_ROOT_PATH."/modules/" . $mydirname . "/class/mxdirectorytree.php";

    global $xoopsDB, $xoopModuleConfig;
    $mydirname = basename(dirname(__DIR__));
    $mytree    = new MxdirectoryTree($xoopsDB->prefix('xdir_cat'), 'cid', 'pid');
    $block     = array();
    $myts      = MyTextSanitizer::getInstance();

    $block[] = array('cid' => 0, 'prefix' => '', 'title' => strtoupper(_MB_MXDIR_MAIN), 'mydirname' => $mydirname, 'menutype' => $options[1]);

    if ($options[0] == 1) {
        $tree = $mytree->getChildTreeArray(0, 'title ASC');
        foreach ($tree as $branch) {
            $branch['prefix'] = substr($branch['prefix'], 0, -1);
            $branch['prefix'] = str_replace('.', '--', $branch['prefix']);
            $block[]          = array('cid' => $branch['cid'], 'prefix' => $branch['prefix'], 'title' => $branch['title'], 'mydirname' => $mydirname, 'menutype' => $options[1]);
            //    "<a href='".XOOPS_URL."/modules/".$mydirname."/viewcat.php?cid=".$branch['cid']."'>".$branch['prefix'].$branch['title']."</a>";
            //    $sel_cat -> addOption($branch['cid'],$branch['prefix'].$branch['title']);
        }
    } else {
        $result  = $xoopsDB->query('SELECT cid, title FROM ' . $xoopsDB->prefix('xdir_cat') . ' WHERE pid=0 ORDER BY title ASC');
        $numrows = $xoopsDB->getRowsNum($result);
        while (list($cid, $title) = $xoopsDB->fetchRow($result)) {
            $block[] = array('cid' => $cid, 'prefix' => '', 'title' => $title, 'mydirname' => $mydirname, 'menutype' => $options[1]);
        }
    }
    //  if (empty($block)) {
    //    $block[] = array('cid'=>0, 'prefix'=>'', 'title'=>strtoupper(_MD_MXDIR_MAIN), 'mydirname'=>$mydirname);
    //  }
    return $block;
}

/**
 * @param $options
 * @return string
 */
function b_xdir_cat_edit($options)
{
    //require_once XOOPS_ROOT_PATH.'/class/xoopstree.php';
    $mydirname = basename(dirname(__DIR__));
    require_once XOOPS_ROOT_PATH . '/modules/' . $mydirname . '/class/mxdirectorytree.php';

    global $xoopsDB, $xoopModuleConfig;
    $mytree = new MxdirectoryTree($xoopsDB->prefix('xdir_cat'), 'cid', 'pid');

    $icychk = ($options[0] == 1) ? 'checked' : '';
    $icnchk = ($options[0] == 1) ? '' : 'checked';
    $form   = "<span style=\"text-align: left;\"><table><tr><td width='200'>" . _MB_MXDIR_INCCATS . '</td><td>';
    $form   .= "<input type='radio' $icychk name='options[0]' value='1'> " . _YES . ' ';
    $form   .= "<input type='radio' $icnchk name='options[0]' value='0'> " . _NO . '</td></tr>';

    $hmychk = ($options[0] == 1) ? 'checked' : '';
    $hmnchk = ($options[0] == 1) ? '' : 'checked';
    $form   .= "<tr><td width='200'>" . _MB_MXDIR_HORIZCATS . '</td><td>';
    $form   .= "<input type='radio' $hmychk name='options[1]' value='1'> " . _YES . ' ';
    $form   .= "<input type='radio' $hmnchk name='options[1]' value='0'> " . _NO . '</td></tr></table></span>';

    return $form;
}
