<script src="jquery-1.9.1.js"></script>
<script>

	function up_res(){
		var env=$("#select_server").val();
        var envname=$("#select_server").find("option:selected").text();
        if(env==""){
            alert("请选择环境");
            return;
        }
		if(confirm("确认更新 "+envname+" 的服务端资源")){
			var params={};
			$.ajax({
				type:"POST",
				dataType:"text",
				url:"update_resource.php?env="+env,
				data:params,
				timeout : 120000,
       			 
				success: function(data){
					alert("succ");
                	document.getElementById("select_server_ret").innerHTML=data;
            	},
				error: function(data){
                	alert("数据超时或者异常!");
				},
			});
		}
	}


</script>

<style type="text/css">
	.select_div_style {margin-left:100px;width:350px;height:50px;float:center;}
	.button_div_style {margin-left:100px;width:280px;height:50px;float:left;}
	.button_style {width:150px;height:25px;margin-top:12px;}
	.ret_div_style {margin-left:400px;height:50px;padding-top:15px;color:red}
</style>
<div class="select_div_style">
	<select id="select_server" name="servers" style="width:200px;">
    	<option value="">选择环境</option>
    	<option value="beta">运营测试</option>
    	<option value="prod">生产环境</option>
	</select>
	<input type="button" value="更新" onclick="up_res();" style="width:100px;"></input>
</div>
<div id="select_server_ret" class="ret_div_style"></div>
