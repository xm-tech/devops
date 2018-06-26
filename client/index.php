<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>运维工具</title>
	<script src="js/jquery-1.11.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<style>
		.left{
			hover:background-color:#f5f5f5;margin-left:200px;float:left;width:200px;height:800px;border:1px solid #A4D3EE;
		}
		.right{
			margin-left:420px;width:1200px;height:800px;border:1px solid #A4D3EE;hover:background-color:#f5f5f5;
		}
		.frame{
			width:100%; height:100%;border:0px;
		}
		.oper{
			border:1px solid #B9D3EE;width:160px;height:20px;margin-left:20px;margin-top:15px;cursor:pointer;
		}
	</style>

	<script type="text/javascript">
		function getContent(phpname){
			document.getElementById("right").innerHTML="<iframe id=\"content\" class=\"frame\" src=\""+phpname+"\"></iframe>";
		}
	</script>

 </head>
 <body>
  <div id="top" style="margin-left:200px;margin-bottom:10px;float:center;width:1420px;height:50px;border:1px solid #A4D3EE">
		<span style="margin-left:600px;">运维工具</span>
		<span style="color:#B23AEE;">&nbsp;&nbsp;&nbsp;&nbsp;TODO:权限;操作日志记录</span>
  </div>
	<div id="left" class="left">
  <?php
  		$con = mysql_connect("localhost","ppgames","IDFS(7^%x#2");
        if (!$con){
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db("demoserver", $con);
        $ret = mysql_query("SELECT * FROM t_func ORDER BY `order` ASC");
        while($row=mysql_fetch_array($ret)){
            echo "<input type=\"button\" value=\"".$row['name']."\" class=\"oper\" onclick=\"getContent('".$row['cmd']."')\"></input>";
        }
  ?>
	</div>
  <div id="right" class="right">
	<iframe id="content" class="frame" src="maintain.php?time=<?php echo time()?>"></iframe>
  </div>
 </body>
</html>
