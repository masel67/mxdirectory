<style type="text/css" media="screen">@import url(<{$xoops_url}>/modules/<{$smartydir}>/images/mxdirectory.css);</style>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<{$xoops_langcode}>" lang="<{$xoops_langcode}>">
<head>
<meta http-equiv="content-type" content="text/html; charset=<{$xoops_charset}>">
<meta http-equiv="content-language" content="<{$xoops_langcode}>">
<meta name="robots" content="<{$xoops_meta_robots}>">
<meta name="keywords" content="<{$xoops_meta_keywords}>">
<meta name="description" content="<{$xoops_meta_description}>">
<meta name="rating" content="<{$xoops_meta_rating}>">
<meta name="author" content="<{$xoops_meta_author}>">
<meta name="copyright" content="<{$xoops_meta_copyright}>">
<meta name="generator" content="XOOPS">
<title><{$xoops_sitename}> - <{$xoops_pagetitle}></title>
</head>
<body style="background-color: #ffffff;" onLoad="window.print()">
<div style='width: 600px; border: 3px dashed #000000; padding: 6px; font-family: Tahoma, Verdana, sans-serif; font-size: 10px; '>

	<table width='580' border='1' cellspacing='0' class="coupon_box">
		<tr>
			<td>

				<table border=0 width='580' cellspacing='0' cellpadding='2'>
					<tr>
						<td width='140'>
						<{if $coupon.logourl != ""}>
							<img src="<{$xoops_url}>/modules/<{$smartydir}>/images/shots/<{$coupon.logourl}>" alt="<{$coupon.linkTitle}> <{$smarty.const._MD_MXDIR_LOGO}>">
						<{/if}>
							<br>
							<span style="font-family: arial, helvetica, sans-serif; font-size: x-small;"><{$coupon.linkTitle}>
								<br><{$coupon.address}><br>
                <{if $coupon.address2 != ""}><{$coupon.address2}><br><{/if}>
								<{$coupon.city}>, <{$coupon.state}> <{$coupon.zip}><br>
<!--							<{$coupon.country}> -->
							</span>
							<br>
							<img src='/images/spacer.gif' height='4' alt=''><br>
						</td>
						<td>&nbsp;</td>
						<td style="vertical-align: top;">
							<table border='0' cellspacing='0' cellpadding='2' width='100%'>
								<tr>
									<td align='right'><span
                                            style="font-size: x-small; font-family: arial, helvetica, sans-sarif; "><{$coupon.counter}><{$coupon.couponid}></span><span
                                            style="font-size: x-small; font-family: arial, helvetica, sans-sarif; ">&nbsp;</span></td>
								</tr>
								<tr>
								  <td>
								    <span class="coupon_heading"><font face='arial, helvetica, sans-sarif' size='4'><{$coupon.heading}></font>
								    <{if $coupon.image}><img style="float: right;" src='<{$xoops_url}>/uploads/<{$coupon.image}>' alt="&amp;nbsp"><{/if}>
								    <br></span>
								    <span class="coupon_linktitle"><{$coupon.linkTitle}><br></span>
								  </td>
								</tr>
								<tr><td>&nbsp;</td></tr>
								<tr>
									<td>
										<span class="coupon_description"><{$coupon.description}></span>
									</td>
								</tr>
								<tr><td>&nbsp;</td></tr>
								<{if $coupon.expire != 0}>
								<tr>
                                    <td align='center'><font face='arial, helvetica, sans-serif' color='#000000' size='2'><span class="coupon_dates"><{$smarty.const._MD_MXDIR_EXPIRESON}><{$coupon.expire}></span></td>
                           								</tr>
                           								<{/if}>
                           							</table>
                           						</td>
                           					</tr>
                                     <tr>
                                 			<td style="text-align: center; font-family: arial, helvetica, sans-serif; font-size: x-small;">
                           			        <{if $coupon.phone}>
                           			          <{$smarty.const._MD_MXDIR_BUSPHONE}>&nbsp;<{$coupon.phone}>&nbsp;
                           			        <{/if}>
                           			        <{if ($coupon.fax)}>
                           			          <{$smarty.const._MD_MXDIR_BUSFAX}>&nbsp;<{$coupon.fax}>
                           			        <{/if}>
                           			      </td>
                                     </tr>
                           				</table>
                           			</td>
                           		</tr>
                           		<tr>
                           			<td align='center'><font face='arial, helvetica, sans-serif'><{$coupon_footer}></font></td>
                           		</tr>
                             </table>
                           </div>
                           <!--
                           	<table border=0 width='580' cellspacing='0' cellpadding='2'>
                           		<tr>
                           	    <td align="center">
                           				<form name=close action='<{$SCRIPT_NAME}>' method=get>
                           					<input type="button" onclick="javascript:window.print()" value='Print'>
                           				</form>
                           			</td>
                           		</tr>
                           	</table>
                           -->
                           </body>
                           </html>
