<style type="text/css" media="screen">@import url(<{$xoops_url}>/modules/<{$smartydir}>/images/mxdirectory.css);</style>
<p align="center">

<span class="c_header"><{$smarty.const._MD_MXDIR_DIRHEADER}></span></p>

<div> <span class="c_title"><{$lang_reportbroken}></span>
  <form action="brokenlink.php" method="POST">
      <{securityToken}><{*//mb*}>
    <input type="hidden" name="lid" value="<{$link_id}>">
    <span class="c_desc"><{$lang_thanksforhelp}><br>
    <{$lang_forsecurity}></span><br><br><input name="submit" type="submit" class="c_formbuttons" value="<{$lang_reportbroken}>">�<input type=button class="c_formbuttons" onclick="'index.php';target='xoopshead'" value="<{$lang_cancel}>"">
  </form>
</div>
<br>
