<script src="jquery-1.9.1.js"></script>
<script>

	function stop_server(){
		var sid=$("#select_server").val();
		var sidtxt=$("#select_server").find("option:selected").text();
		if(sid==""){
			alert("未选择服务器");
			return;
		}
		if(confirm("确认停掉 "+sidtxt+" ?")){
			// TODO 查出sid所在的服务器
			var params={};
			$.ajax({
        		type:"POST",
				dataType:"text",
				url:"stop_one_server.php?sid="+sid,
				data:params,
				timeout : 120000,

				success: function(data){
					alert("succ");
					//document.getElementById("stop_server_ret").innerHTML=data;
				},
				error: function(data){
					alert("数据超时或者异常!");
				},
    		});
		}
	}


	function stop_server_now(){
		var sid=$("#select_server").val();
        var sidtxt=$("#select_server").find("option:selected").text();
        if(sid==""){
            alert("未选择服务器");
            return;
        }
        if(confirm("确认立即停服 "+sidtxt+" ?")){
            // TODO 查出sid所在的服务器
            var params={};
            $.ajax({
                type:"POST",
                dataType:"text",
                url:"stop_one_server_now.php?sid="+sid,
                data:params,
                timeout : 120000,

                success: function(data){
					alert("succ");
					//document.getElementById("stop_server_now_ret").innerHTML=data;
                },
                error: function(data){
                    alert("数据超时或者异常!");
                },
            });
        }
	}

	function confirm_server_stop(){
		var sid=$("#select_server").val();
        var sidtxt=$("#select_server").find("option:selected").text();
        if(sid==""){
            alert("未选择服务器");
            return;
        }
        if(confirm("确认执行该操作 ?")){
            // TODO 查出sid所在的服务器
            var params={};
            $.ajax({
                type:"POST",
                dataType:"text",
                url:"confirm_one_server_stop.php?sid="+sid,
                data:params,
                timeout : 120000,

                success: function(data){
					alert(data);
                },
                error: function(data){
                    alert("数据超时或者异常!");
                },
            });
        }
    }

	function start_server(){
		var sid=$("#select_server").val();
        var sidtxt=$("#select_server").find("option:selected").text();
        if(sid==""){
            alert("未选择服务器");
            return;
        }
		if(confirm("确认启动 "+sidtxt)){
			var params={};
			$.ajax({
				type:"POST",
				dataType:"text",
				url:"start_one_server.php?sid="+sid,
				data:params,
				timeout : 120000,

				success: function(data){
					alert("succ");
					//document.getElementById("start_server_ret").innerHTML=data;
				},
				error: function(data){
					alert("数据超时或者异常!");
				},
			});
		}
	}

	function confirm_server_start(){
		var sid=$("#select_server").val();
        var sidtxt=$("#select_server").find("option:selected").text();
        if(sid==""){
            alert("未选择服务器");
            return;
        }
        if(confirm("确认执行该操作 ?")){
            // TODO 查出sid所在的服务器
            var params={};
            $.ajax({
                type:"POST",
                dataType:"text",
                url:"confirm_one_server_start.php?sid="+sid,
                data:params,
                timeout : 120000,

                success: function(data){
                    alert(data);
                },
                error: function(data){
                    alert("数据超时或者异常!");
                },
            });
        }
	}

	function update_server_code(){
		var sid=$("#select_server").val();
        var sidtxt=$("#select_server").find("option:selected").text();
        if(sid==""){
            alert("未选择服务器");
            return;
        }
		if(confirm("确认更新 "+sidtxt+" 服务端代码?")){
			var params={};
			$.ajax({
				type:"POST",
				dataType:"text",
				url:"update_one_server_code.php?sid="+sid,
				data:params,
				timeout : 120000,

				success: function(data){
					alert("succ");
					//document.getElementById("update_code_ret").innerHTML=data;
				},
				error: function(data){
					alert("数据超时或者异常!");
				},
			});
		}
	}

	function confirm_update_server_code(){
		alert("TODO");
	}


	function backup_db(){
		var sid=$("#select_server").val();
        var sidtxt=$("#select_server").find("option:selected").text();
        if(sid==""){
            alert("未选择服务器");
            return;
        }
		if(confirm("确认备份 "+sidtxt+" db?")){
            var params={};
            $.ajax({
                type:"POST",
                dataType:"text",
                url:"backup_one_db.php?sid="+sid,
                data:params,
                timeout : 120000,

                success: function(data){
					alert("succ");
                    //document.getElementById("backup_db_ret").innerHTML=data;
                },
                error: function(data){
                    alert("数据超时或者异常!");
                },
            }); 
        }
	}

	function confirm_backup_db(){
		alert("TODO");
	}

	function update_db(){
		var sid=$("#select_server").val();
        var sidtxt=$("#select_server").find("option:selected").text();
        if(sid==""){
            alert("未选择服务器");
            return;
        }
		if(confirm("确认要执行 "+sidtxt+" 的 demo_update.sql ?")){
			var params={};
			$.ajax({
				type:"POST",
				dataType:"text",
				url:"update_one_server_db.php?sid="+sid,
				data:params,
				timeout : 120000,
       			 
				success: function(data){
					alert("succ");
                	//document.getElementById("update_db_ret").innerHTML=data;
            	},
				error: function(data){
                	alert("数据超时或者异常!");
				},
			});
		}
	}


	function confirm_update_db(){
		alert("TODO");
    }


</script>

<style type="text/css">
	.select_div_style {margin-left:100px;width:280px;height:50px;float:center;}
	.button_div_style {margin-left:100px;width:280px;height:50px;float:left;}
	.button_style {width:150px;height:25px;margin-top:12px;}
	.ret_div_style {margin-left:400px;height:50px;padding-top:15px;color:red}
</style>
<div class="select_div_style">
	<select id="select_server" name="servers" style="width:200px;">
    	<option value="">选服</option>
	<?php
		$con = mysql_connect("localhost","ppgames","IDFS(7^%x#2");
		if (!$con){
			die('Could not connect: ' . mysql_error());
  		}
		mysql_select_db("demoserver", $con);
		$ret = mysql_query("SELECT * FROM t_server");
		while($row=mysql_fetch_array($ret)){
			echo "<option value=\"".$row['sid']."\">".$row['sname']."</option>";	
		}
	?>
    	<option value="0">全服(TODO)</option>
	</select>
</div>
<div class="button_div_style">
	<input type="button" class="button_style" value="停服" onclick="stop_server();"></input>
</div>
<div id="stop_server_ret" class="ret_div_style">kill -15</div>
<div class="button_div_style">
    <input type="button" class="button_style" value="强制停服" onclick="stop_server_now();"></input>
</div>
<div id="stop_server_now_ret" class="ret_div_style">kill -9(可选) </div>

<div class="button_div_style">
    <input type="button" class="button_style" value="确认已停服" onclick="confirm_server_stop();"></input>
</div>
<div id="confirm_server_stop_ret" class="ret_div_style"></div>


<div class="button_div_style">
    <input type="button" class="button_style" value="db备份" onclick="backup_db();"></input>
</div>
<div id="backup_db_ret" class="ret_div_style"></div>

<div class="button_div_style">
    <input type="button" class="button_style" value="确认db已备份" onclick="confirm_backup_db();"></input>
</div>
<div id="confirm_backup_db_ret" class="ret_div_style"></div>

<div class="button_div_style">
    <input type="button" class="button_style" value="db更新" onclick="update_db();"></input>
</div>
<div id="update_db_ret" class="ret_div_style">svn up demo_update.sql, if diff(ver) exec demo_update.sql</div>

<div class="button_div_style">
    <input type="button" class="button_style" value="确认db已更新" onclick="confirm_update_db();"></input>
</div>
<div id="confirm_update_db_ret" class="ret_div_style"></div>

<div class="button_div_style">
    <input type="button" class="button_style" value="服务端代码更新" onclick="update_server_code();"></input>
</div>
<div id="update_code_ret" class="ret_div_style">更新前必须确认服务器端jar已提交,务必确保服务端代码版本的正确性</div>

<div class="button_div_style">
    <input type="button" class="button_style" value="确认服务端代码已更新" onclick="confirm_update_server_code();"></input>
</div>
<div id="confirm_update_code_ret" class="ret_div_style"></div>

<div class="button_div_style">
    <input type="button" class="button_style" value="启动" onclick="start_server();"></input>
</div>
<div id="start_server_ret" class="ret_div_style">停服和启动之间请保持15秒左右的时间</div>
<div class="button_div_style">
    <input type="button" class="button_style" value="确认已启动" onclick="confirm_server_start();"></input>
</div>
<div id="confirm_start_server_ret" class="ret_div_style"></div>
