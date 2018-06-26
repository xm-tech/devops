<?php
	class Util{
		
		public static function getIpBySid($sid){
            # FIXME 使用更新的 mysql API
			$con = mysql_connect("localhost","ppgames","IDFS(7");
			if (!$con){
				die('Could not connect: ' . mysql_error());
			}
			mysql_select_db("demoserver", $con);
			# FIXME 根据sid判断是查 ip 还是 inip
			#$sql="SELECT ip FROM t_server where sid=$sid";
			$sql="SELECT inip FROM t_server where sid=$sid";
			$ret = mysql_query($sql);
			$row=mysql_fetch_array($ret);
            #echo "$row[0]";
			return "$row[0]";
		}

	}
?>
