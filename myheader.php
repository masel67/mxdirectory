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

/////////////////////////////////////////////////////////////
// Title    : Frame Branding Hack for Xoops Mylinks        //
// Author   : Freeop                                       //
// Email    : Webmaster@belizecountry.com                  //
// Website  : http://www.Belizecountry.com                 //
// System   : Xoops RC 3.0.4 / 3.0.5             10-14-02  //
// Filename : myheader.php                                 //
// Type     : Module Hack for MyLinks                      //
/////////////////////////////////////////////////////////////

// Code below uses users current selected theme style      //

include __DIR__ . '/../../mainfile.php';
$url = $_GET['url'];
$lid = (int)$_GET['lid'];
$cid = (int)$_GET['cid'];
// EVU CODE - changed - 2F5376 to transparent
echo '<html><head><style><!--.bg1 {    background-color : #E3E4E0;}.bg2 {    background-color : #e5e5e5;}.bg3 {     background-color : #f6f6f6;}.bg4 {    background-color : #f0f0f0;}.bg5 {    background-color : f8f8f8;}body { margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;font-family: Tahoma, taipei; color;#000000; font-size: 10px; background-color : transparent; color: #ffffff;}a {  font-weight: bold;font-family: Tahoma, taipei; font-size: 10px; text-decoration: none; color: #666666; font-style: normal}A:hover {  font-weight: bold;text-decoration: underline;  font-family: Tahoma, taipei; font-size: 10px; color: #FF9966; font-style: normal}td {  font-family: Tahoma, taipei; color: #000000; font-size: 10px;border-top-width : 1px; border-right-width : 1px; border-bottom-width : 1px; border-left-width : 1px;}img { border:0;}//--></style>';
$mail_subject = rawurlencode(sprintf(_MD_MXDIR_INTRESTLINK, $xoopsConfig['sitename']));
$mail_body    = rawurlencode(sprintf(_MD_MXDIR_INTLINKFOUND, $xoopsConfig['sitename']) . ':  ' . XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/singlelink.php?cid=' . $cid . '&amp;lid=' . $lid);
?>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="150"><a href="<?php echo XOOPS_URL; ?>" target="xoopshead"><img src="<?php echo XOOPS_URL; ?>/images/logo.gif" alt=""/></a>
        <td width="100%" align="center">
            <table class="bg3" width=95% cellspacing="2" cellpadding="3" border="0" style="border: #e0e0e0 1px solid;">
                <tr>
                    <td style="border-bottom: #e0e0e0 1px solid;">
                        <b><?php echo $xoopsConfig['sitename']; ?></b></td>
                </tr>
                <tr>
                    <td class='bg4' align="center">
                        <small>
                            <a target="main" href="ratelink.php?cid=<?php echo $cid; ?>&amp;lid=<?php echo $lid; ?>"><?php echo _MD_MXDIR_RATETHISSITE; ?></a> | <a target="main"
                                                                                                                                                                    href="brokenlink.php?lid=<?php echo $lid; ?>"><?php echo _MD_MXDIR_REPORTBROKEN; ?></a>
                            | <a target='_top' href='contact.php?op=tell&amp;subject=<?php echo $mail_subject; ?>&body=<?php echo $mail_body; ?>'><?php echo _MD_MXDIR_TELLAFRIEND; ?></a> | <a
                                    target='_top' href="<?php echo XOOPS_URL; ?>">Back to <?php echo $xoopsConfig['sitename']; ?></a> | <a target='_top' href="<?php echo $url; ?>">Close Frame</a>
                        </small>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body></html>
