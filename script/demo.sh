#!/bin/bash

source /data/script/common.sh

game_conf(){
	svn up /data/server/s0/bin/ || die "svn up fail"
	cp -rf /data/server/s0/ /data/server/s${1}/
	game_conf_file=/data/server/s${1}/bin/conf/config.properties
	log4j_conf_file=/data/server/s${1}/bin/conf/log4j.properties

	sed -i "s/Server.id=0/Server.id=${1}/" ${game_conf_file}
	sed -i "s/Server.manager.port=10000/Server.manager.port=$[10000+${1}]/" ${game_conf_file}
	sed -i "s/Server.port=9000/Server.port=$[9000+${1}]/" ${game_conf_file}
	sed -i "s/Server.jetty.port=6000/Server.jetty.port=$[6000+${1}]/" ${game_conf_file}
	sed -i "s/Server.manager.port=10000/Server.manager.port=$[10000+${1}]/" ${game_conf_file}
	sed -i "s/demo_0/demo_${1}/" ${game_conf_file}
	sed -i "s/s0/s${1}/" ${log4j_conf_file}
	sed -i "s/s0/s${1}/" /data/server/s${1}/bin/startup.sh
	sed -i "s/-Dsid=0/-Dsid=${1}/" /data/server/s${1}/bin/startup.sh
	sed -i "s/s0/s$1/" /data/server/s${1}/bin/tlog.sh
	show "game_conf ok"
}

memcache_conf(){
	mem_port=$[11211+${1}]
	mem_conf_file=/data/server/s${1}/bin/conf/config.properties
	sed -i "s/memcache.Addr=127.0.0.1:11211/memcache.Addr=127.0.0.1:${mem_port}/" ${mem_conf_file}
	# /usr/local/bin/memcached -d -m 1024 -u root -p ${mem_port} -P /tmp/memcached_${1}.pid
	show "memcache_conf ok"
}

mysql_conf(){
	create_sql_file=/data/server/s0/bin/demo_new.sql
	update_sql_file=/data/server/s0/bin/demo_update.sql
	if [ -s ${create_sql_file} ];then
		# TODO 封装MySQL操作
		/usr/local/mysql/bin/mysql -uroot -p'DFDF900' -e "create database demo_$1;use demo_$1;source ${create_sql_file};"
		/usr/local/mysql/bin/mysql -uroot -p'DFDF900' -e "GRANT ALL ON demo_$1.* to ppgames@'%' IDENTIFIED BY 'xdfdfdfdfd';FLUSH PRIVILEGES;"
	fi
	if [ -s ${update_sql_file} ];then
		#/usr/local/mysql/bin/mysql -uroot -p'DFDF900' -e "use demo_$1;source ${update_sql_file};"
		echo "exec update sql"
	fi
    show "mysql_conf ok"
}

gen_new_sid(){
	maxsid=$(/usr/local/mysql/bin/mysql -uppgames -p'IDFS(7' -h10.168.79.161 demoserver -sse "SELECT MAX(sid) msid FROM t_server")
	if [ "${maxsid}" == "NULL" ]; then
		maxsid=100;
	else
		maxsid=$[$maxsid+1]
	fi
	httport=$[6000+${maxsid}]
	gameport=$[9000+${maxsid}]
	sname="${maxsid}服"
	insert_sql="INSERT INTO t_server(sid,sname,createtime,opentime,closetime,ip,inip,httpport,gameport,state) VALUES(${maxsid},'"${sname}"',$(date +%s),0,0,'"$(getip)"','"$(get_in_ip)"',${httport},${gameport},0)"
	/usr/local/mysql/bin/mysql -uppgames -p'IDFS(7' -h10.168.79.161 demoserver -e "${insert_sql}" || die "gen_new_sid fail"
	return ${maxsid}
}

main(){
	show "begin"
	gen_new_sid
	sid=$?
	game_conf ${sid} || die "game_conf fail"
	#memcache_conf ${sid} || die "memcache_conf fail"
	mysql_conf ${sid} || die "mysql_conf fail"
	show "deploy ${sid} ok"
}

main
