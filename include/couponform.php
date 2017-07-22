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

require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';

$uploadirectory = '/uploads/';

$coupform      = new XoopsThemeForm(_MD_MXDIR_COUPONFORM, 'couponform', $_SERVER['PHP_SELF'], 'POST', true);
$linkimg_array = XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . '/uploads/');
$coupform->addElement(new XoopsFormHidden('lid', $lid));
$coupform->addElement(new XoopsFormText(_MD_MXDIR_COUPONHEADER, 'heading', 25, 30, $heading), true);
$coupform->addElement(new XoopsFormDhtmlTextArea(_MD_MXDIR_DESCRIPTIONC, 'descr', $descr));
$image_option = new XoopsFormSelect(_MD_MXDIR_COUPONIMGMGR . '<br>' . _MD_MXDIR_COUPONIMG . '<br>', 'image', $image);
$image_option->addOptionArray($linkimg_array);
$imgtray = new XoopsFormElementTray(_MD_MXDIR_COUPSEL, '<br>');

$image_option->setExtra("onchange='showImgSelected(\"imagex\", \"image\", \"" . $uploadirectory . "\", \"\", \"" . XOOPS_URL . "\")'");
$imgtray->addElement($image_option, false);
$imgtray->addElement(new XoopsFormLabel('', "<br><img src='" . XOOPS_URL . $uploadirectory . '/' . $image . "' name='imagex' id='imagex' alt=''>"));
//$coupform->addElement($image_option);
$coupform->addElement($imgtray);
$coupform->addElement(new XoopsFormRadioYN(_MD_MXDIR_CONVERTLBR, 'lbr', $lbr));
$coupform->addElement(new XoopsFormDateTime(_MD_MXDIR_PUBLISHCOUPON, 'publish', 25, $publish));
$expire_option = new XoopsFormCheckBox(_MD_MXDIR_SETEXPIRATION, 'expire_enable', $setexpire);
$expire_option->addOption(1, _YES);
$coupform->addElement($expire_option);
$coupform->addElement(new XoopsFormDateTime(_MD_MXDIR_EXPIRECOUPON, 'expire', 25, $expire));

$button_tray = new XoopsFormElementTray('');
$button_tray->addElement(new XoopsFormButton('', 'submit', _MD_MXDIR_SUBMIT, 'submit'));

if ($couponid) {
    $button_tray->addElement(new XoopsFormButton('', 'delete', _MD_MXDIR_DELETE, 'submit'));
    $coupform->addElement(new XoopsFormHidden('couponid', $couponid));
}
$coupform->addElement($button_tray);
$coupform->display();
