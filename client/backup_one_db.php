<?php
	require 'common.php';
	$sid=$_REQUEST['sid'];
	$sip=Util::getIpBySid($sid);
	$b=shell_exec('ssh root@'.$sip.' " -p5797 sh /data/script/maintain.sh backup_one_db '.$sid.'" &');
	echo $b;
?>
