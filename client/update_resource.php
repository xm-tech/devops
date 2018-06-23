<?php
	$env=$_REQUEST['env'];
	$resource_path="/home/wwwroot/default/$env/html";
	$b=shell_exec("svn up $resource_path && svn info $resource_path");
	echo "$resource_path:  $b";
?>
