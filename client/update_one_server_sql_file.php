<?php
	require 'common.php';
	$sid=$_REQUEST['sid'];
	$sip=Util::getIpBySid($sid);
	$b=shell_exec('ssh root@'.$sip.' -p5797 "sh /data/script/maintain.sh update_one_server_sql_file '.$sid.' " &');
	echo $b;
?>
