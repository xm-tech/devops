<?php
	#$b=exec('ssh xm@114.55.72.240 "sh /data/script/t.sh say good"', $out, $status);
	$b=shell_exec('ssh root@114.55.72.240 -p5797 "sh /data/script/t.sh say 客服操作"');
	#echo $b.",";
	#echo($out['0']);
	#echo $status;
	echo $b;
?>
