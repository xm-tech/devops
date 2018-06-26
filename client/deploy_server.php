<?php
	$ip=$_REQUEST['ip'];
	#echo $ip;
	$b=shell_exec('ssh root@'.$ip.' -p5797 "sh /data/script/demo.sh &"');
	echo $b;
?>
