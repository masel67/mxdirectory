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

//Inserted as Global replacement of $xoopsModule->getVar('dirname') and for module directory name in handlers
defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

$mydirname = basename(dirname(__DIR__));

/**
 * @param $time
 * @param $status
 * @return string
 */
function newlinkgraphic($time, $status)
{
    global $mydirname;
    $count     = 7;
    $new       = '';
    $startdate = (time() - (86400 * $count));
    if ($startdate < $time) {
        if ($status == 1) {
            $new = "&nbsp;<img src=\"" . XOOPS_URL . '/modules/' . $mydirname . "/images/newred.gif\" alt=\"" . _MD_MXDIR_NEWTHISWEEK . "\">";
        } elseif ($status == 2) {
            $new = "&nbsp;<img src=\"" . XOOPS_URL . '/modules/' . $mydirname . "/images/update.gif\" alt=\"" . _MD_MXDIR_UPTHISWEEK . "\">";
        }
    }

    return $new;
}

/**
 * @param $hits
 * @return string
 */
function popgraphic($hits)
{
    global $xoopsModuleConfig, $mydirname;
    if ($hits >= $xoopsModuleConfig['popular']) {
        return "&nbsp;<img src=\"" . XOOPS_URL . '/modules/' . $mydirname . "/images/pop.gi_MD_MXDIR_alt=\"" . _MD_POPULAR . "\">";
    }

    return '';
}

//Reusable Link Sorting Functions
/**
 * @param $orderby
 * @return string
 */
function convertorderbyin($orderby)
{
    switch (trim($orderby)) {
        case 'titleA':
            $orderby = 'title ASC';
            break;
        case 'dateA':
            $orderby = 'date ASC';
            break;
        case 'hitsA':
            $orderby = 'hits ASC';
            break;
        case 'ratingA':
            $orderby = 'rating ASC';
            break;
        case 'titleD':
            $orderby = 'title DESC';
            break;
        case 'hitsD':
            $orderby = 'hits DESC';
            break;
        case 'ratingD':
            $orderby = 'rating DESC';
            break;
        case'dateD':
        default:
            $orderby = 'date DESC';
            break;
    }

    return $orderby;
}

/**
 * @param $orderby
 * @return mixed
 */
function convertorderbytrans($orderby)
{
    switch (trim($orderby)) {
        case 'hits ASC':
            $orderbyTrans = _MD_POPULARITYLTOM;
            break;
        case 'hits DESC':
            $orderbyTrans = _MD_POPULARITYMTOL;
            break;
        case 'title ASC':
            $orderbyTrans = _MD_TITLEATOZ;
            break;
        case 'title DESC':
            $orderbyTrans = _MD_TITLEZTOA;
            break;
        case 'date ASC':
            $orderbyTrans = _MD_DATEOLD;
            break;
        case 'rating ASC':
            $orderbyTrans = _MD_RATINGLTOH;
            break;
        case 'rating DESC':
            $orderbyTrans = _MD_RATINGHTOL;
            break;
        case 'date DESC':
        default:
            $orderbyTrans = _MD_DATENEW;
            break;
    }

    return $orderbyTrans;

    /*
  if ($orderby == "hits ASC")    $orderbyTrans = ""._MD_MXDIR_POPULARITYLTOM."";
  if ($orderby == "hits DESC")   $orderbyTrans = ""._MD_MXDIR_POPULARITYMTOL."";
  if ($orderby == "title ASC")   $orderbyTrans = ""._MD_MXDIR_TITLEATOZ."";
  if ($orderby == "title DESC")  $orderbyTrans = ""._MD_MXDIR_TITLEZTOA."";
  if ($orderby == "date ASC")    $orderbyTrans = ""._MD_MXDIR_DATEOLD."";
  if ($orderby == "date DESC")   $orderbyTrans = ""._MD_MXDIR_DATENEW."";
  if ($orderby == "rating ASC")  $orderbyTrans = ""._MD_MXDIR_RATINGLTOH."";
  if ($orderby == "rating DESC") $orderbyTrans = ""._MD_MXDIR_RATINGHTOL."";
  return $orderbyTrans;
    */
}

/**
 * @param $orderby
 * @return string
 */
function convertorderbyout($orderby)
{
    switch (trim($orderby)) {
        case 'title ASC':
            $orderby = 'titleA';
            break;
        case 'date ASC':
            $orderby = 'dateA';
            break;
        case 'hits ASC':
            $orderby = 'hitsA';
            break;
        case 'rating ASC':
            $orderby = 'ratingA';
            break;
        case 'title DESC':
            $orderby = 'titleD';
            break;
        case 'hits DESC':
            $orderby = 'hitsD';
            break;
        case 'rating DESC':
            $orderby = 'ratingD';
            break;
        case 'date DESC':
        default:
            $orderby = 'dateD';
            break;
    }

    return $orderby;

    /*
    if ($orderby == "title ASC")            $orderby = "titleA";
    if ($orderby == "date ASC")            $orderby = "dateA";
    if ($orderby == "hits ASC")          $orderby = "hitsA";
    if ($orderby == "rating ASC")        $orderby = "ratingA";
    if ($orderby == "title DESC")              $orderby = "titleD";
    if ($orderby == "date DESC")            $orderby = "dateD";
    if ($orderby == "hits DESC")          $orderby = "hitsD";
    if ($orderby == "rating DESC")        $orderby = "ratingD";
    return $orderby;
    */
}

//updates rating data in itemtable for a given item
/**
 * @param $sel_id
 */
function updaterating($sel_id)
{
    global $xoopsDB;
    $query = 'SELECT rating FROM ' . $xoopsDB->prefix('xdir_votedata') . ' WHERE lid = ' . $sel_id . '';
    //echo $query;
    $voteresult  = $xoopsDB->query($query);
    $votesDB     = $xoopsDB->getRowsNum($voteresult);
    $totalrating = 0;
    while (list($rating) = $xoopsDB->fetchRow($voteresult)) {
        $totalrating += $rating;
    }
    $finalrating = $totalrating / $votesDB;
    $finalrating = number_format($finalrating, 4);
    $query       = 'UPDATE ' . $xoopsDB->prefix('xdir_links') . " SET rating=$finalrating, votes=$votesDB WHERE lid = $sel_id";
    //echo $query;
    $xoopsDB->query($query) or exit();
}

//returns the total number of items in items table that are accociated with a given table $table id
/**
 * @param        $sel_id
 * @param string $status
 * @return int
 */
function getTotalItems($sel_id, $status = '')
{
    global $xoopsDB, $mytree;
    $count = 0;
    $arr   = array();
    $query = 'SELECT count(*) FROM ' . $xoopsDB->prefix('xdir_links') . ' WHERE (cid=' . $sel_id . ' OR cidalt1=' . $sel_id . ' OR cidalt2=' . $sel_id . ' OR cidalt3=' . $sel_id . ' OR cidalt4=' . $sel_id . ')';
    if ($status != '') {
        $query .= " and status>=$status";
    }
    $result = $xoopsDB->query($query);
    list($thing) = $xoopsDB->fetchRow($result);
    $count = $thing;
    $arr   = $mytree->getAllChildId($sel_id);
    $size  = count($arr);
    for ($i = 0; $i < $size; $i++) {
        $query2 = 'SELECT count(*) FROM ' . $xoopsDB->prefix('xdir_links') . ' WHERE (cid=' . $arr[$i] . ' OR cidalt1=' . $arr[$i] . ' OR cidalt2=' . $arr[$i] . ' OR cidalt3=' . $arr[$i] . ' OR cidalt4=' . $arr[$i] . ')';
        if ($status != '') {
            $query2 .= " and status>=$status";
        }
        $result2 = $xoopsDB->query($query2);
        list($thing) = $xoopsDB->fetchRow($result2);
        $count += $thing;
    }

    return $count;
}

//Alpha Sort
/**
 * @return string
 */
function letters()
{
    global $xoopsModule, $xoopsModuleConfig;
    $letterchoice = '';
    $alphabet     = array();
    // $alphabet = array ("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
    if ($xoopsModuleConfig['num_letters']) {
        for ($i = 0; $i <= 9; $i++) {
            $alphabet[] = chr(48 + $i);
        }
        $alphabet[64] = '&nbsp;-&nbsp;';
    }

    for ($i = 65; $i <= 90; $i++) {
        $alphabet[] = chr($i);
    }
    $letterchoice .= '&nbsp;';
    //	$letterchoice .= "|&nbsp;";
    //    while (list($key, $ltr) = each($alphabet)) {
    foreach ($alphabet as $key => $ltr) {
        $letterchoice .= (($xoopsModuleConfig['num_letters'] = true) && ($ltr === '&nbsp;-&nbsp;')) ? $ltr : "<a href='viewalpha.php?list=$ltr'>$ltr</a>";
        //		$letterchoice .= "<a href='viewalpha.php?list=$ltr'>$ltr</a>";
        //		$letterchoice .= "&nbsp;|&nbsp;";
        $letterchoice .= '&nbsp;';
    }

    return $letterchoice;
}

//Display Time
/**
 * @param $value
 * @return string
 */
function displayTime($value)
{
    global $xoopsModuleConfig;

    //		$valckr = ($value = "0") ? _MD_UNKNOWN : $value ;
    $openstrip  = substr($value, 0, 5);
    $osckr      = substr($value, 0, 1);
    $closestrip = substr($value, -5);
    $csckr      = substr($value, -1);

    $clocktype = $xoopsModuleConfig['time_option'];
    $currhrs   = $value;
    $timearray = array();
    $ampmarray = array();
    $hrsarray  = array(
        'AM 12',
        'AM 1',
        'AM 2',
        'AM 3',
        'AM 4',
        'AM 5',
        'AM 6',
        'AM 7',
        'AM 8',
        'AM 9',
        'AM 10',
        'AM 11',
        'PM 12',
        'PM 1',
        'PM 2',
        'PM 3',
        'PM 4',
        'PM 5',
        'PM 6',
        'PM 7',
        'PM 8',
        'PM 9',
        'PM 10',
        'PM 11'
    );

    for ($i = 0; $i < 24; $i++) {
        for ($j = 0; $j < 60; $j = $j + 15) {
            $h                = $i;
            $h                = ($i < 10) ? $h = '0' . $h : $h = $h;
            $tkey             = ($j != 0) ? $h . ':' . $j : $h . ':0' . $j;
            $timearray[$tkey] = ($j != 0) ? $i . ':' . $j : $i . ':0' . $j;
            $ampmarray[$tkey] = ($j != 0) ? $hrsarray[$i] . ':' . $j : $hrsarray[$i] . ':0' . $j;
        }
    }
    $clocktype = (int)$clocktype;
    $clocktype = ($clocktype < 1) ? $clocktype = $timearray : $clocktype = $ampmarray;

    //display specific
    $value = (($value !== '')
              && ($closestrip !== '25:00')
              && ($closestrip !== '26:00')
              && ($openstrip !== '25:00')
              && ($openstrip !== '26:00')) ? ((isset($clocktype[$openstrip]) ? $clocktype[$openstrip] : 0) . ' - ' . (isset($clocktype[$closestrip]) ? $clocktype[$closestrip] : 0)) : $value;
    $value = (($openstrip === '25:00') || ($closestrip === '25:00')) ? _MD_MXDIR_BUSCLOSED : $value;
    $value = (($openstrip === '26:00') || ($closestrip === '26:00')) ? _MD_MXDIR_ALOPEN : $value;
    $value = (($value === ' - ') || ($openstrip === ' - ') || ($closestrip === ' - ')) ? _MD_MXDIR_UNKNOWN : $value;
    $value = (($value == '-') || ($value == '') || ($osckr == '-') || ($csckr == '-')) ? _MD_MXDIR_UNKNOWN : $value;

    return $value;
}

//Level Options Arrayer
/**
 * @param $olvl
 * @return mixed
 */
function getPremiumOptions($olvl)
{
    global $xoopsModuleConfig, $mydirname;
    $myLevelOption = $xoopsModuleConfig['premium_listing' . $olvl . 'opts'];
    //$nl = (int)(count($mylvlopt));
    // $nlvls with 11
    for ($opi = 1; $opi < 12; $opi++) {
        $premiumOption      = in_array($opi, $myLevelOption) ? '1' : '0';
        $levelOptions[$opi] = $premiumOption;
        if ($levelOptions['1'] == '0') {
            array_fill(2, 9, '0');
            $opi = 12;
        }
    }

    return $levelOptions;
}

//Level Select Builder
/**
 * @return bool
 */
function getlvlselects()
{
    global $xoopsModuleConfig;

    for ($eachlvl = 1; $eachlvl < 6; $eachlvl++) {
        $mylvls = $xoopsModuleConfig['premium_listing' . $eachlvl . 'opts'];
        $mylvls = in_array(11, $mylvls) ? $xoopsModuleConfig['premium_listing' . $eachlvl] : '0';
        if ($mylvls != '0') {
            $ulvls[$eachlvl] = $mylvls;
        }
    }

    return isset($ulvls) ? $ulvls : false;
}

//Hour Display Cleaner

/**
 * @param $bnums
 * @return array|bool
 */
function displaybiznums($bnums)
{
    list($phone, $fax, $mobile, $home, $tollfree) = $bnums;
    $isbiznums = array();
    $i         = 1;
    if (!($phone == '')) {
        $isbiznums[$i] = _MD_MXDIR_BUSPH . $phone;
        $i++;
    }
    if (!($fax == '')) {
        $isbiznums[$i] = _MD_MXDIR_BUSFAX . $fax;
        $i++;
    }
    if (!($mobile == '')) {
        $isbiznums[$i] = _MD_MXDIR_BUSMO . $mobile;
        $i++;
    }
    if (!($home == '')) {
        $isbiznums[$i] = _MD_MXDIR_BUSHO . $home;
        $i++;
    }
    if (!($tollfree == '')) {
        $isbiznums[$i] = _MD_MXDIR_BUSTF . $tollfree;
    }

    $biznums = empty($isbiznums) ? false : $isbiznums;

    return $biznums;
}

//Upgrade Script Functions
/**
 * @param $tablename
 * @return bool
 */
function TableExists($tablename)
{
    global $xoopsDB;
    $result = $xoopsDB->queryF("SHOW TABLES LIKE '$tablename'");

    return ($xoopsDB->getRowsNum($result) > 0);
}

/**
 * @param $fieldname
 * @param $table
 * @return bool
 */
function FieldExists($fieldname, $table)
{
    global $xoopsDB;
    $result = $xoopsDB->queryF("SHOW COLUMNS FROM	$table LIKE '$fieldname'");

    return ($xoopsDB->getRowsNum($result) > 0);
}

/**
 * @param $field
 * @param $table
 * @return mixed
 */
function AddField($field, $table)
{
    global $xoopsDB;
    $result = $xoopsDB->queryF('ALTER TABLE ' . $table . " ADD $field;");

    return $result;
}

/**
 * @param $fieldname
 * @param $oldfval
 * @param $newfval
 * @param $tablename
 * @return mixed
 */
function UpdateaField($fieldname, $oldfval, $newfval, $tablename)
{
    global $xoopsDB;
    $result = $xoopsDB->queryF('UPDATE ' . $tablename . " SET $fieldname = '$newfval' WHERE $fieldname = '$oldfval';");

    return $result;
}
