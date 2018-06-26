<script src="jquery-1.9.1.js"></script>
<script>

	function deploy(){
		var ip=$("#select_machine").val();
		var iptxt=$("#select_machine").find("option:selected").text();
		if(ip==""){
			alert("未选择机器");
			return;
		}
		if(confirm("确认在 "+iptxt+" 上部署新服 ?")){
            var params={};
            $.ajax({
                type:"POST",
                dataType:"text",
                url:"deploy_server.php?ip="+ip,
                data:params,
                timeout : 120000,

                success: function(data){
                    document.getElementById("deploy_server_ret").innerHTML=data;
                },
                error: function(data){
                    alert("数据超时或者异常!");
                },
            });
        }
	}

</script>

<style type="text/css">
	.select_div_style {margin-left:100px;width:280px;height:50px;float:center;}
	.button_div_style {margin-left:100px;width:280px;height:50px;float:left;}
	.button_style {width:150px;height:25px;margin-top:12px;}
	.ret_div_style {margin-left:400px;height:50px;padding-top:15px;color:red}
</style>
<div class="select_div_style">
	<select id="select_machine" name="machines" style="width:200px;">
    	<option value="">选择机器</option>
		<?php
		$con = mysql_connect("localhost","ppgames","IDFS(7^%x#2");
        if (!$con){
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db("demoserver", $con);
        $ret = mysql_query("SELECT * FROM t_machine where servernum < 5 and memoryAvailable > 6 and sizeExdiskFree > 30 order by servernum");
        while($row=mysql_fetch_array($ret)){
            echo "<option value=\"".$row['inip']."\">".$row['ip']."(区服个数".$row['servernum'].")</option>";
        }
		?>
	</select>
</div>
<div class="button_div_style">
	<input type="button" class="button_style" value="部署" onclick="deploy();"></input> 
</div>
<div>
	<span style="color:red">&nbsp;&nbsp;加新服后需做的事：1:到114.55.67.83服更新支付服务器列表/data/www/demo/server.json</span>
</div>
<div id="deploy_server_ret" class="ret_div_style"></div>
