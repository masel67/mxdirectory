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
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team, Kazumi Ono (AKA onokazu)
 */

//XoopsFormTime==>GNARGNAR>Hack&Slash~Tripmon~WhoopWhoop
defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
/**
 *
 *
 * @package       kernel
 * @subpackage    form
 *
 * @author        Kazumi Ono    <onokazu@xoops.org>
 * @copyright     copyright (c) 2000-2003 XOOPS.org
 */

/**
 * Date and time selection field
 *
 * @author       Kazumi Ono    <onokazu@xoops.org>
 * @copyright    copyright (c) 2000-2003 XOOPS.org
 *
 * @package      kernel
 * @subpackage   form
 */
class XoopsFormTime extends XoopsFormElementTray
{

    /**
     * XoopsFormTime constructor.
     * @param string $caption
     * @param string $name
     * @param int    $size
     * @param        $value
     */
    public function __construct($caption, $name, $size = 15, $value)
    {
        global $xoopsModuleConfig;
        $openstrip  = substr($value, 0, 5);
        $closestrip = substr($value, -5);

        parent::__construct($caption, '');
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

        //Box1
        $timetray    = new XoopsFormElementTray('', '');
        $timeselecto = new XoopsFormSelect(_MD_MXDIR_BUSOPEN, $name . 'o', $openstrip);
        $timeselecto->addOption('', _MD_MXDIR_UNKNOWN);
        $timeselecto->addOption('25:00', _MD_MXDIR_BUSCLOSED);
        $timeselecto->addOption('26:00', _MD_MXDIR_ALOPEN);
        $timeselecto->addOptionArray($clocktype);

        $timeselecto->setExtra('onchange="this.form.elements.mfhrs.value=this.form.elements.mfhrso.value+\' - \'+this.form.elements.mfhrsc.value;this.form.elements.sathrs.value=this.form.elements.sathrso.value+\' - \'+this.form.elements.sathrsc.value;this.form.elements.sunhrs.value=this.form.elements.sunhrso.value+\' - \'+this.form.elements.sunhrsc.value;"');
        $timetray->addElement($timeselecto);

        //Box2
        $timeselectc = new XoopsFormSelect(_MD_MXDIR_BUSCLOSE, $name . 'c', $closestrip);
        $timeselectc->addOption('', _MD_MXDIR_UNKNOWN);
        $timeselectc->addOption('25:00', _MD_MXDIR_BUSCLOSED);
        $timeselectc->addOption('26:00', _MD_MXDIR_ALOPEN);
        $timeselectc->addOptionArray($clocktype);

        $timeselectc->setExtra('onchange="this.form.elements.mfhrs.value=this.form.elements.mfhrso.value+\' - \'+this.form.elements.mfhrsc.value;this.form.elements.sathrs.value=this.form.elements.sathrso.value+\' - \'+this.form.elements.sathrsc.value;this.form.elements.sunhrs.value=this.form.elements.sunhrso.value+\' - \'+this.form.elements.sunhrsc.value;"');
        $timetray->addElement($timeselectc);

        //		$timetext=new XoopsFormlabel('', $currhrs);
        //		$timetext->setExtra('onload="this.form.elements.value.value=this.form.elements.name.value"');
        //		$timetray->addElement($timetext);

        $this->addElement($timetray);
    }
}
