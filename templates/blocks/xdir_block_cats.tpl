<{foreach item=link from=$block}>
<!--  <a href="<{$xoops_url}>/modules/<{$link.mydirname}>/singlelink.php?cid=<{$link.cid}>&amp;lid=<{$link.id}>"><{$link.title}></a> (<{$link.criteria}>)<br> -->
  <a href='<{$xoops_url}>/modules/<{$link.mydirname}>/viewcat.php?cid=<{$link.cid}>'><{$link.prefix}><{$link.title}></a>
  <{if $link.menutype == 0}><br><{else}>&nbsp;|&nbsp;<{/if}>
<{/foreach}>

