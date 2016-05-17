<?php

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

$mydirname = basename(dirname(__DIR__));

eval('

function b_sitemap_' . $mydirname . '(){

	$db =& XoopsDatabaseFactory::getDatabaseConnection();
  $smtree = new MxdirectoryTree($db->prefix("xdir_cat"),"cid","pid");
	$myts = MyTextSanitizer::getInstance();

	$ret = array() ;
	$tree = $smtree->getFirstChild(0,"title ASC");
	foreach ($tree as $branch) {
 	  $ret["parent"][] = array(
 	                          "id" => $branch["cid"],
		                        "title" => $myts->htmlSpecialChars( $branch["title"] ),
			                      "url" => "viewcat.php?cid=".$branch["cid"]);
  }
	return $ret ;
}

');
