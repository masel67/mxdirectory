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
 *           $options[1]   = How many reviews are displayes
 * Output  : Returns the desired most recent or most popular links
 *****************************************************************************
 * @param $options
 * @return array|string
 */
function b_xdir_top_show($options)
{
    //require_once XOOPS_ROOT_PATH.'/class/xoopstree.php';
    $mydirname = basename(dirname(__DIR__));
    require_once XOOPS_ROOT_PATH . '/modules/' . $mydirname . '/class/mxdirectorytree.php';

    global $xoopsDB;
    $mytree = new MxdirectoryTree($xoopsDB->prefix('xdir_cat'), 'cid', 'pid');
    $block  = array();
    $myts   = MyTextSanitizer::getInstance();

    switch (trim($options[0])) {
        case 'hits':
            $hitchk     = ' AND hits>0 ';
            $limit      = ' LIMIT ' . $options[1];
            $orderby    = 'hits';
            $rand_limit = '';
            break;
        case 'rand':
            $hitchk     = '';
            $limit      = '';
            $orderby    = 'NULL';
            $rand_limit = $options[1];
            break;
        case 'rank':  // order by rank if votes>0
            $hitchk     = ' AND votes>0 ';
            $limit      = ' LIMIT ' . $options[1];
            $orderby    = 'rating';
            $rand_limit = '';
            break;
        case 'date':
        default:
            $hitchk     = '';
            $limit      = ' LIMIT ' . $options[1];
            $orderby    = 'date';
            $rand_limit = '';
            break;
    }

    if ($options[5] === 'All') {
        $dispcat = '';
    } else {
        $start   = (int)$options[5];
        $tree    = $mytree->getChildTreeArray($start, 'title ASC');
        $dispcat = ' AND ((cid = ' . $options[5] . ')';
        $dispcat .= ' OR (cidalt1 = ' . $options[5] . ')';
        $dispcat .= ' OR (cidalt2 = ' . $options[5] . ')';
        $dispcat .= ' OR (cidalt3 = ' . $options[5] . ')';
        $dispcat .= ' OR (cidalt4 = ' . $options[5] . ')';
        foreach ($tree as $branch) {
            $dispcat .= ' OR (cid = ' . $branch['cid'] . ')';
            $dispcat .= ' OR (cidalt1 = ' . $branch['cid'] . ')';
            $dispcat .= ' OR (cidalt2 = ' . $branch['cid'] . ')';
            $dispcat .= ' OR (cidalt3 = ' . $branch['cid'] . ')';
            $dispcat .= ' OR (cidalt4 = ' . $branch['cid'] . ')';
        }
        $dispcat .= ')';
    }

    //	$result = $xoopsDB->query("SELECT lid, cid, cidalt1, cidalt2, cidalt3, cidalt4, title, date, hits FROM ".$xoopsDB->prefix("xdir_links")." WHERE (status>0".$hitchk.$dispcat.") ORDER BY ".$orderby." DESC",$limit);
    $result   = $xoopsDB->query('SELECT lid, cid, title, date, hits, rating, votes FROM ' . $xoopsDB->prefix('xdir_links') . ' WHERE (status>0' . $hitchk . $dispcat . ') ORDER BY ' . $orderby . ' DESC' . $limit);
    $lstcount = 0;
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $link  = array();
        $title = $myts->htmlSpecialChars($myrow['title']);
        if (!XOOPS_USE_MULTIBYTES) {
            if (strlen($myrow['title']) >= $options[2]) {
                $title = $myts->htmlSpecialChars(substr($myrow['title'], 0, $options[2] - 1)) . '...';
            }
        }
        $link['id']    = $myrow['lid'];
        $link['cid']   = $myrow['cid'];
        $link['title'] = $title;

        $lstcount++;
        $link['mydirname'] = $options[3];
        switch ($options[0]) {
            case 'hits':
                $link['criteria'] = $myrow['hits'];
                break;
            case 'rank':
                $link['criteria'] = sprintf('%01.2f', $myrow['rating']);
                break;
            case 'rand':
            case 'date':
            default:
                $link['criteria'] = formatTimestamp($myrow['date'], 's');
                break;
        }

        $block['links'][] = $link;
    }
    $retval = $block;

    if (empty($block)) {
        $retval = ($options[4] == 0) ? '' : array('id' => '', 'cid' => '', 'title' => '');
    } else {
        // now check to see if random block
        if (($options[0] === 'rand') and ($rand_limit <= $lstcount)) {
            $rand_ret = array();
            $rand_key = array_rand($block['links'], $rand_limit);
            if (is_array($rand_key)) {
                foreach ($rand_key as $idx) {
                    $rand_ret['links'][] = $block['links'][$idx];
                }
            } else {
                $rand_ret['links'][] = $block['links'][$rand_key];
            }
            $block  = $rand_ret;
            $retval = $block;
        }
    }

    return $retval;
}

/**
 * @param $options
 * @return string
 */
function b_xdir_top_edit($options)
{
    //require_once XOOPS_ROOT_PATH.'/class/xoopstree.php';
    $mydirname = basename(dirname(__DIR__));
    require_once XOOPS_ROOT_PATH . '/modules/' . $mydirname . '/class/mxdirectorytree.php';

    global $xoopsDB, $xoopModuleConfig;
    $mytree = new MxdirectoryTree($xoopsDB->prefix('xdir_cat'), 'cid', 'pid');

    $form = '' . _MB_MXDIR_DISP . '&nbsp;';
    $form .= "<input type='hidden' name='options[]' value='";

    switch ($options[0]) {
        case 'date':
            $form .= "date'";
            break;
        case 'rand':
            $form .= "rand'";
            break;
        case 'rank':
            $form .= "rank'";
            break;
        case 'hits':
        default:
            $form .= "hits'";
            break;
    }

    $form .= '>';
    $form .= "<input type='text' name='options[]' value='" . $options[1] . "'>&nbsp;" . _MB_MXDIR_LINKS . '';
    $form .= '&nbsp;<br>' . _MB_MXDIR_CHARS . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "'>&nbsp;" . _MB_MXDIR_LENGTH . '';
    $form .= "<input type='hidden' name='options[]' value='" . $options[3] . "'";
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
