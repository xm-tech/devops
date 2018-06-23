<?php
	require 'common.php';
	$sid=$_REQUEST['sid'];
	$sip=Util::getIpBySid($sid);
	$b=shell_exec('ssh root@'.$sip.' -p5797 "sh /data/script/maintain.sh confirm_one_server_stop '.$sid.' " ');
	echo $b
?>
