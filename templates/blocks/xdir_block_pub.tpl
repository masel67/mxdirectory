<span style="display:list-item; list-style-type:none; list-style:none; text-align:center;">
  <{foreach item=link from=$block}>
     <a href="<{$xoops_url}>/modules/<{$link.mydirname}>/savings.php?lid=<{$link.lid}>"><img src="<{$xoops_url}>/uploads/<{$link.image}>" <{$link.imgsize}>  alt="<{$link.linkTitle}>" title="<{$link.linkTitle}>"></a><br>
      <span style="font-size: x-small;"><a href="<{$xoops_url}>/modules/<{$link.mydirname}>/savings.php?lid=<{$link.lid}>"><{$link.heading}></a><br></span>
      <span style="font-size: x-small;">(<{$link.linkTitle}>)<br></span>
  <{/foreach}>
</span>
