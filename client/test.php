<?php
	#$b=exec('ssh xm@114.55.72.240 "sh /data/script/t.sh say good"', $out, $status);
	#$b=shell_exec('ssh xm@114.55.72.240 "sh /data/script/t.sh say 运维操作"');
	#echo $b.",";
	#echo($out['0']);
	#echo $status;
	#echo $b;
	require 'common.php';	
	$ip=Util::getIpBySid(118);
	echo $ip;
?>
