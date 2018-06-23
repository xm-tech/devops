<?php
require_once('conn/config.php');
$sql="select itemid,key_,value_type,hostid from items where hostid in (select hostid from hosts_groups where groupid = 8) and key_ in ('system.cpu.util[,idle]','system.cpu.load[percpu,avg5]','vm.memory.size[available]','net.if.out[eth1]','vfs.fs.size[/,pfree]','vfs.fs.size[/exdisk,pfree]','system.users.num','agent.ping')";
$query=$db->query($sql);
$result=$query->fetchAll(PDO::FETCH_ASSOC); 

$sql="select hostid,name from hosts where available = 1";
$query=$db->query($sql);
$hostName=$query->fetchAll(PDO::FETCH_ASSOC);

$name = array(); //主机ID对应主机外网IP
foreach($hostName as $k=>$v){
	$name[$v['hostid']] = $v['name'];
}

$hostidArray = array(); 
$typeArray = array();
foreach($result as $k=>$v){
	$hostidArray[$v['hostid']][$v['key_']] = $v['itemid'];$v['key_'];
	$typeArray[$v['value_type']][] = $v['itemid'];
}
//print_r($hostidArray);
//print_r($typeArray);

$param = array();
foreach($typeArray as $k=>$v){
	$itemids = implode(',',$v);
	if($k == 0){
		$table = 'history';
	}elseif($k == 3){
		$table = 'history_uint';
	}else{
		$talbe = 'history_str';
	}
	$sql = "select h.itemid,h.`value` from $table as h, (select itemid,max(clock) as c,`value`,ns from $table where itemid in ($itemids) group by itemid) as t where h.itemid=t.itemid and h.clock=t.c";
	$query=$db->query($sql);
	$param[]=$query->fetchAll(PDO::FETCH_ASSOC);
}
//print_r($param);

$params = array();
foreach($param as $k=>$v){
	foreach($v as $key=>$value){
		$params[$value['itemid']] = $value['value'];
	}

}
//print_r($params);

$finParm = array();
foreach($hostidArray as $k=>$v){
	foreach($v as $key=>$value){
		$finParm[$name[$k]][$key] = $params[$value];
	}
	 
}
//print_r($finParm);

/*
(
    [114.55.72.240] =&gt; Array
        (
            [agent.ping] =&gt; 1
            [system.cpu.load[percpu,avg5]] =&gt; 0.0000
            [system.cpu.util[,idle]] =&gt; 99.3576
            [system.users.num] =&gt; 3
            [vm.memory.size[available]] =&gt; 11652567040
            [net.if.out[eth1]] =&gt; 14160
            [vfs.fs.size[/,pfree]] =&gt; 72.8806
            [vfs.fs.size[/exdisk,pfree]] =&gt; 99.3856
        )

    [114.55.90.118] =&gt; Array
        (
            [agent.ping] =&gt; 1
            [system.cpu.load[percpu,avg5]] =&gt; 0.0000
            [system.cpu.util[,idle]] =&gt; 99.7164
            [system.users.num] =&gt; 2
            [vm.memory.size[available]] =&gt; 12999643136
            [net.if.out[eth1]] =&gt; 256
            [vfs.fs.size[/,pfree]] =&gt; 81.2473
            [vfs.fs.size[/exdisk,pfree]] =&gt; 99.7249
        )

)
*/
?>
<link href="css/bootstrap.min.css" rel="stylesheet">
<script src="js/custom.js"></script>
	<table class="table table-bordered" id="tblSort">
		<thead>
			<tr>
				<th onclick="sortTable('tblSort',0);" style="cursor:pointer">主机</th>
				<th onclick="sortTable('tblSort',0);" style="cursor:pointer">空闲CPU</th>
				<th onclick="sortTable('tblSort',0);" style="cursor:pointer">系统负载(5分钟)</th>
				<th onclick="sortTable('tblSort',0);" style="cursor:pointer">可用内存(GB)</th>
				<th onclick="sortTable('tblSort',0);" style="cursor:pointer">外网出流量(Kbps)</th>
				<th onclick="sortTable('tblSort',0);" style="cursor:pointer">/分区空闲率</th>
				<th onclick="sortTable('tblSort',0);" style="cursor:pointer">/exdisk分区空闲率</th>
				<th onclick="sortTable('tblSort',1,'int');" style="cursor:pointer">当前登陆用户数</th>
				<th onclick="sortTable('tblSort',0);" style="cursor:pointer">机器状态</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($finParm as $k=>$v){
				echo "<tr><td>".$k."</td><td>".round($v['system.cpu.util[,idle]'],2)."%</td><td>".$v['system.cpu.load[percpu,avg5]']."</td><td>".round($v['vm.memory.size[available]']/1024/1024/1024,2)."</td><td>".round($v['net.if.out[eth1]']/1024,2)."</td><td>".round($v['vfs.fs.size[/,pfree]'],2)."%</td><td>".round($v['vfs.fs.size[/exdisk,pfree]'],2)."%</td><td>".$v['system.users.num']."</td><td>";
				if($v['agent.ping'] == 1){ echo "正常</td></tr>"; } else { echo "异常</td></tr>";}
			}?>
		</tbody>
	</table>
