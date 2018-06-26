<?php
$db_host   = "10.161.135.237";
// database name
$db_name   = "zabbix";
// database username
$db_user   = "zabbix";
// database password
$db_pass   = "zabbix@";

$db = new PDO('mysql:host='.$db_host.';dbname='.$db_name,$db_user,$db_pass);
$db->query("set names utf8");

$db1_host   = "10.168.79.161";
// database name
$db1_name   = "demoserver";
// database username
$db1_user   = "ppgames";
// database password
$db1_pass   = "IDFS(7";

$db1 = new PDO('mysql:host='.$db1_host.';dbname='.$db1_name,$db1_user,$db1_pass);
$db1->query("set names utf8");

?>
