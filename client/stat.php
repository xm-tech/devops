<?php
require_once('conn/config.php');

$sql="select * from t_server order by state";
$query=$db1->query($sql);
$result=$query->fetchAll(PDO::FETCH_ASSOC); 

?>
<link href="css/bootstrap.min.css" rel="stylesheet">
<script src="js/custom.js"></script>
	<table class="table table-bordered" id="tblSort">
		<thead>
			<tr>
				<th onclick="sortTable('tblSort',0);" style="cursor:pointer">服务器ID</th>
				<th onclick="sortTable('tblSort',1);" style="cursor:pointer">服务器名称</th>
				<th onclick="sortTable('tblSort',2,'date');" style="cursor:pointer">创建时间</th>
				<th onclick="sortTable('tblSort',5,'float');" style="cursor:pointer">内网IP</th>
				<th onclick="sortTable('tblSort',5,'float');" style="cursor:pointer">外网IP</th>
				<th onclick="sortTable('tblSort',6,'int');" style="cursor:pointer">gameport</th>
				<th onclick="sortTable('tblSort',7,'int');" style="cursor:pointer">代码版本</th>
				<th onclick="sortTable('tblSort',8,'int');" style="cursor:pointer">SQL版本</th>
				<th onclick="sortTable('tblSort',9,'int');" style="cursor:pointer">代码更新时间</th>
				<th onclick="sortTable('tblSort',10,'int');" style="cursor:pointer">SQL更新时间</th>
				<th onclick="sortTable('tblSort',0);" style="cursor:pointer">状态</th>
			</tr>
		</thead>
		<tbody style="font-size:12px;">
			<?php 
				foreach($result as $k=>$v){
					$code_up_time=0;
					if($v['code_up_time']!=0){
						$code_up_time=date('Y-m-d H:i:s',$v['code_up_time']);
					}
					$createtime=0;
					if($v['createtime']!=0){
						$createtime=date('Y-m-d H:i:s',$v['createtime']);
					}
					$sql_up_time=0;
					if($v['sql_up_time']!=0){
						$sql_up_time=date('Y-m-d H:i:s',$v['sql_up_time']);
					}
					$sname=$v['sname'];
					echo "<tr>
							<td>".$v['sid']."</td>
							<td>".$sname."</td>
							<td>".$createtime."</td>
							<td>".$v['inip']."</td>
							<td>".$v['ip']."</td>
							<td>".$v['gameport']."</td>
							<td>".$v['codever']."</td>
							<td>".$v['upsqlver']."</td>
							<td>".$code_up_time."</td>
							<td>".$sql_up_time."</td>
							<td>";
								if($v['state'] == 1){ echo "<font style='color:green'>开启</font></td></tr>"; } else { echo "<font style='color:red'>关闭</font>
							</td>
						</tr>";}
			}?>
		</tbody>
	</table>
