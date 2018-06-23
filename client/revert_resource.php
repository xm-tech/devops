<?php
	$r=$_REQUEST['r'];
	$cmd="cd /home/wwwroot/default && svn co svn://121.40.207.204/bin/html -r $r";
	$b=shell_exec("cd /home/wwwroot/default && svn co svn://121.40.207.204/bin/html -r $r");
	echo $b;
?>
