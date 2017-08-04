<{$xoops_module_header}>
<table width="888" border="0" align="center" cellpadding="0" cellspacing="0" class="c_search">
  <tr>
    <td class="c_search_l"><{$smarty.const._MD_MXDIR_DIRHEADER}></td>
	<{if $usesearch != "0"}>
    <td class="c_search_table">
      <!--Search Table-->
			<form name='search' id='search' action='<{$xoops_url}>/search.php' method='post' onsubmit='return xoopsFormValidate_search();'>
        <input type='hidden' name='mids[]' value='<{$xmid}>'>
        <input name='query' type='text' class="c_search_input" id='query' value='' size='20' maxlength='255'>
          <select name='andor'  size='1' class="c_search_select" id='andor'>
            <option value='AND' selected='selected'><{$smarty.const._MD_MXDIR_ALLWORDS}></option>
            <option value='OR'><{$smarty.const._MD_MXDIR_ANYWORDS}></option>
            <option value='exact'><{$smarty.const._MD_MXDIR_EXACTMATCH}></option>
          </select>
        <input type='submit' class='c_searchbutton' name='submit'  id='submit' value='<{$smarty.const._MD_SEARCH}>'>
        <input type='hidden' name='action' id='action' value='results'>
      </form>
    </td>
    <td class="c_search_r">
  <{else}>
    <td colspan="2" class="c_search_r">
  <{/if}>
      <div><a href="<{$xoops_url}>/modules/<{$smartydir}>/savings.php"><{$smarty.const._MD_MXDIR_SAVINGS}></a></div>
      <div><a href="<{$xoops_url}>/modules/<{$smartydir}>/submit.php"><{$smarty.const._MD_MXDIR_SUBMITLINK}></a></div>
    </td>
  </tr>
  <{if $usealpha != "0"}>
  <tr align="center"><td colspan="3" class="c_select_letters"><{$smarty.const._MD_MXDIR_SEARCHFOR}>:&nbsp;<{$letters}></td></tr>
  <{/if }>
</table>
<hr>

<script type='text/javascript'>
<!--
  function xoopsFormValidate_search(){}
//-->
</script>
<h4 class="c_title"><{$lang_mylistings}></h4>
<div class="c_navbar"><{$category.navbar}></div>
<table width="100%" class="index_category_links_display">
  <tr><td width="100%" align="center" valign="top">
  <!-- Start link loop -->
    <{section name=i loop=$links}>
    <{if $links[i].premium =="0" || $links[i].lvlopts.1=="0"}>
    <table style="width: 100%; padding: 10px;">
    <{elseif $links[i].premium =="1" && $links[i].lvlopts.1 =="1"}>
    <table style="width: 100%; background-color: <{$p1color}>; padding: 10px;">
    <{elseif $links[i].premium =="2" && $links[i].lvlopts.1 =="1"}>
    <table style="width: 100%; background-color: <{$p2color}>; padding: 10px;">
    <{elseif $links[i].premium =="3" && $links[i].lvlopts.1 =="1"}>
    <table style="width: 100%; background-color: <{$p3color}>; padding: 10px;">
    <{elseif $links[i].premium =="4" && $links[i].lvlopts.1 =="1"}>
    <table style="width: 100%; background-color: <{$p4color}>; padding: 10px;">
    <{elseif $links[i].premium =="5" && $links[i].lvlopts.1 =="1"}>
    <table style="width: 100%; background-color: <{$p5color}>; padding: 10px;">
    <{/if}>
      <tr><td colspan='3'>
        <table><tr>
          <{if $links[i].status > 0}>
          <td colspan='2' class="link_title"><{$links[i].adminlink}><a href="<{$xoops_url}>/modules/<{$smartydir}>/singlelink.php?cid=<{$links[i].cid}>&amp;lid=<{$links[i].id}>"><{$links[i].title}></a> <{if $links[i].lvlopts.5 =="1" && $links[i].coupons > 0}> <a href="savings.php?lid=<{$links[i].id}>"><img src="<{$xoops_url}>/modules/<{$smartydir}>/images/coupons.jpg" alt="<{$smarty.const._MD_MXDIR_SAVINGS}>"></a> <{/if}></td>
          <{else}>
          <td colspan='2' class="link_title"><{$links[i].title}> <{if $links[i].lvlopts.5 =="1" && $links[i].coupons > 0}> <img src="<{$xoops_url}>/modules/<{$smartydir}>/images/coupons.jpg" alt="<{$smarty.const._MD_MXDIR_SAVINGS}>"><{/if}></td>
          <{/if}>
          <td class="link_rating"><{if $links[i].rating > 0}><{$lang_rating}><{$links[i].rating}> (<{$links[i].votes}>)<{/if}></td>
        </tr></table>
      </td></tr>
      <tr>
      <{if $links[i].logourl != "" && $links[i].lvlopts.7 == "1" && $show_screenshot == "1"}>
        <td class="link_image_panel"><a href="<{$xoops_url}>/modules/<{$smartydir}>/singlelink.php?cid=<{$links[i].cid}>&amp;lid=<{$links[i].id}>"><img src="images/shots/<{$links[i].logourl}>" alt="<{$smarty.const._MD_MXDIR_LOGO}>"></a></td>
        <td style="text-align: left; vertical-align: bottom;">
      <{else}>
        <td colspan='2' style="text-align: left; vertical-align: bottom;">
      <{/if}>
          <span class="link_address"><{$links[i].address}><{if $links[i].address2 != ""}>,<{$links[i].address2}><{/if}>
            , <{$links[i].city}>, <{$links[i].state}>, <{$links[i].zip}>
            <{if $links[i].country != ""}>[<font style="font-weight: bold;"><{$links[i].country}></font>]<{/if}>
            <br>
          </span>
        </td>
        <td>
          <span class="link_dropdowns">
            <{if $links[i].biznums}><{html_options name=biznums options=$links[i].biznums}><{/if}>
            &nbsp;&nbsp;<{html_options name=bizhrs options=$links[i].bizhrs}>
	        </span>
        <{if $links[i].url != "http://" && $links[i].url != "" && $links[i].lvlopts.2 == "1"}>
          <a href='visit.php?cid=<{$links[i].cid}>&amp;lid=<{$links[i].id}>' target='_blank'><img src='images/link.gif' alt='<{$lang_visit}>'><span class="c_url"><{$links[i].url}></span></a>
        <{/if}>
        <br>
        </td></tr>
      </table>
      <hr>
    <{/section}>
    <!-- End link loop -->
  </td></tr>
</table>
  	  <div class="c_navbar"><{$category.navbar}></div>
<{include file='db:system_notification_select.tpl'}>
