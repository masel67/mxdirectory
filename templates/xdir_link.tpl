<{if $link.premium =="0" || $link.lvlopts.1=="0"}>
<table style="width: 100%; padding: 10px;">
<{elseif $link.premium =="1" && $link.lvlopts.1 =="1"}>
<table style="width: 100%; background-color: <{$p1color}>; padding: 10px;">
<{elseif $link.premium =="2" && $link.lvlopts.1 =="1"}>
<table style="width: 100%; background-color: <{$p2color}>; padding: 10px;">
<{elseif $link.premium =="3" && $link.lvlopts.1 =="1"}>
<table style="width: 100%; background-color: <{$p3color}>; padding: 10px;">
<{elseif $link.premium =="4" && $link.lvlopts.1 =="1"}>
<table style="width: 100%; background-color: <{$p4color}>; padding: 10px;">
<{elseif $link.premium =="5" && $link.lvlopts.1 =="1"}>
<table style="width: 100%; background-color: <{$p5color}>; padding: 10px;">
  <!--DWLayoutTable-->
  <{/if}>
  
  <tr><td colspan = "3"><table>
      <tr><td class="link_title"><{$link.adminlink}><a href="<{$xoops_url}>/modules/<{$smartydir}>/singlelink.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>"><{$link.title}></a> <{if $link.lvlopts.5 =="1" && $link.coupons > 0}> <a href="savings.php?lid=<{$link.id}>"><img src="<{$xoops_url}>/modules/<{$smartydir}>/images/coupons.jpg" alt="<{$smarty.const._MD_MXDIR_SAVINGS}>"></a> <{/if}></td>
      <td class="link_rating"><a href="<{$xoops_url}>/modules/<{$smartydir}>/ratelink.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>"><{$lang_rating}><{$link.rating}> (<{$link.votes}>)</a></td>
    </tr></table></td></tr>
    <tr> <{if $link.logourl != "" && $link.lvlopts.7 == "1" && $show_screenshot == "1"}>
      <td class="link_image_panel"><a href="<{$xoops_url}>/modules/<{$smartydir}>/singlelink.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>"><img src="images/shots/<{$link.logourl}>" alt="<{$smarty.const._MD_MXDIR_LOGO}>"></a></td>
    <{/if}>
	<td style="text-align: left; vertical-align: bottom;">
      <!-- (<{$lang_category}> <{$link.category}>) -->
      <span class="link_address"><{$link.address}><br>
      <{if $link.address2 != ""}>
      <{$link.address2}><br>
      <{/if}>
      <{$link.city}>, <{$link.state}> <{$link.zip}><br>
      <{if $link.country != ""}> <span style="font-weight: bold;"><{$lang_country}></span>&nbsp;<{$link.country}><br>
      <{/if}></span> <span class="link_dropdowns">
	  <{if $link.biznums}><{html_options name=biznums options=$link.biznums}><{/if}>
	  &nbsp;
	  <{html_options name=bizhrs options=$link.bizhrs}>
	  </span>
	  <br>
      <{if $link.url != "http://" && $link.url != "" && $link.lvlopts.2 == "1"}>
      <a href='visit.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>' target='_blank'><img src='images/link.gif' alt='<{$lang_visit}>'><span class="c_url"><{$link.url}></span></a>
	  <br>
      <{/if}>    </td>
    <td class="c_linkbtn_spacing"><table class="c_linkbtn_spacing">
        <tr class="c_linkbtn_spacing"> <{if $link.email != ""}>
          <td><form name="email" action="<{$xoops_url}>/modules/<{$smartydir}>/contact.php" method="get">
              <input type="hidden" name="lid" value="<{$link.id}>">
              <input type="hidden" name="op" value="ctob">
              <input type="submit" class="c_embtn" value="<{$smarty.const._MD_MXDIR_EMAILBTN}>">
            </form></td>
          <{/if}>
          <td>
          <!-- REPLACE THE FOLLOWING CODE WITH CODES FOR YOUR COUNTRY FROM THE /MAPS DIRECTORY -->
              <form action="http://maps.google.com/maps?" method="get" name="mapForm2" target="_new" id="mapForm2">
                              <input type="hidden" name="f" value="q">
                              <input type="hidden" name="hl" value="us">
                              <input type="hidden" name="q" value="<{$link.address}>, <{$link.zip}> <{$link.city}>, <{$link.country}> ">
                              <input type=submit name="getmap" value="Map">
                          </form>
          <!-- END OF CODE REPLACEMENT FOR COUNTRY MAPS -->
          </td>
          <td><form name="prnt" action="<{$SCRIPT_NAME}>" method="get">
              <input type="button" class="c_printbtn" onclick="openWithSelfMain('<{$xoops_url}>/modules/<{$smartydir}>/print.php?lid=<{$link.id}>', 'print', 500, 380);" value="<{$smarty.const._MD_MXDIR_PRINTBTN}>">
            </form></td>
        </tr>
    </table></td>
  </tr>
</table>
<{if $link.premium =="0" || $link.lvlopts.1=="0"}>
<table style="width: 100%; padding: 10px;">
<{elseif $link.premium =="1" && $link.lvlopts.1 =="1"}>
<table style="width: 100%; background-color: <{$p1color}>; padding: 10px;">
<{elseif $link.premium =="2" && $link.lvlopts.1 =="1"}>
<table style="width: 100%; background-color: <{$p2color}>; padding: 10px;">
<{elseif $link.premium =="3" && $link.lvlopts.1 =="1"}>
<table style="width: 100%; background-color: <{$p3color}>; padding: 10px;">
<{elseif $link.premium =="4" && $link.lvlopts.1 =="1"}>
<table style="width: 100%; background-color: <{$p4color}>; padding: 10px;">
<{elseif $link.premium =="5" && $link.lvlopts.1 =="1"}>
<table style="width: 100%; background-color: <{$p5color}>; padding: 10px;">
  <{/if}>
  <tr class="link_footer">
      <td  style="width: 105%;"><span class="link_nav_links"><a href="<{$xoops_url}>/modules/<{$smartydir}>/singlelink.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>"><{$smarty.const._MD_MXDIR_MOREINFOBTN}></a> | <a href="<{$xoops_url}>/modules/<{$smartydir}>/ratelink.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>"><{$lang_ratethissite}></a>&nbsp;
      <{if $link.isadmin || $link.is_owner || $showmod}>
      | <a href="<{$xoops_url}>/modules/<{$smartydir}>/modlink.php?lid=<{$link.id}>"><{$lang_modify}></a>&nbsp;
      <{/if}>
      | <a target="_top" href="contact.php?op=tell&amp;subject=<{$link.mail_subject}>&amp;lid=<{$link.id}>"><{$lang_tellafriend}></a> | <a href="<{$xoops_url}>/modules/<{$smartydir}>/singlelink.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>"><{$lang_comments}> (<{$link.comments}>)</a></span>
    </td>
  </tr>
</table>
<hr>
