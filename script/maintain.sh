#!/bin/bash

source /data/script/common.sh

ip=$(get_in_ip)

backup_all_db(){
	cd /exdisk/mysqlback/
	find ./ -mtime +10 -name "*.sql.gz" -exec rm -rf {} \;

	sids=$(/usr/local/mysql/bin/mysql -uroot -p'DFDF900((#$$roo@' -h127.0.0.1 -e "show databases;"|grep supergirl)
	for dbname in ${sids}
	do
    	/usr/local/mysql/bin/mysqldump -uroot -p'DFDF900((#$$roo@' -h127.0.0.1 ${dbname} | gzip > /exdisk/mysqlback/${dbname}_$(date +%Y-%m-%d-%H-%M).sql.gz
	done
	
	(su backup -c "/usr/bin/scp -P 3930 -o StrictHostKeyChecking=no /exdisk/mysqlback/supergirl_*_$(date +%Y-%m-%d-%H)* backup@10.25.234.86:/data/backup/${ip}/")

}

backup_one_db(){
	dbname="supergirl_$1"
	/usr/local/mysql/bin/mysqldump -uroot -p'DFDF900((#$$roo@' -h127.0.0.1 ${dbname} | gzip > /exdisk/mysqlback/${dbname}_$(date +%Y-%m-%d-%H-%M).sql.gz
	if [ $? -eq 0 ];then
		echo "backup ${1}'s db succ"
	else
		echo "backup ${1}'s db fail"
	fi
}

update_one_server_code(){
	sid="$1"
    cd /data/server/s${sid}/bin
    oldsvnrev=$(svn info supergirl.jar|grep -e "Rev:"|awk -F':' '{print $2}'|sed s/[[:space:]]//g)
    svnupret=$(svn up supergirl.jar)
	newsvnrev=$(svn info supergirl.jar|grep -e "Rev:"|awk -F':' '{print $2}'|sed s/[[:space:]]//g)
	# test
	#oldsvnrev="54"
	if [ "${oldsvnrev}" != "${newsvnrev}" ];then
		changelist=$(svn diff supergirl.jar -c${newsvnrev} --summarize)
		/usr/local/mysql/bin/mysql -uppgames -p'IDFS(7^%x#2' -h10.168.79.161 supergirlserver -sse "UPDATE t_server SET codever=${newsvnrev},code_up_time=$(now) WHERE sid=${1}"
		echo "oldver:${oldsvnrev},newver:${newsvnrev},changelist:${changelist}"
	else
		echo "no change"
    fi 
	chmod +x supergirl.jar
}

update_one_server_db(){
	update_sql_file=/data/server/s${1}/bin/superGirl_update.sql
	svn up ${update_sql_file} 2>&1 >/dev/null 
	if [ -s ${update_sql_file} ]; then
		svn_ver_indb=$(/usr/local/mysql/bin/mysql -uppgames -p'IDFS(7^%x#2' -h10.168.79.161 supergirlserver -sse "SELECT upsqlver FROM t_server WHERE sid=${1}")
		svn_ver_local=$(svn info ${update_sql_file}|grep -e "Rev:"|awk -F':' '{print $2}'|sed s/[[:space:]]//g)
		if [ "${svn_ver_local}" != "${svn_ver_indb}" ]; then
			/usr/local/mysql/bin/mysql -uppgames -p'IDFS(7^%x#2' -h10.168.79.161 supergirlserver -sse "UPDATE t_server SET upsqlver=${svn_ver_local},sql_up_time=$(now) WHERE sid=${1}" || die "update t_server fail, plz check"
			/usr/local/mysql/bin/mysql -uroot -p'DFDF900((#$$roo@' -e "use supergirl_${1};source ${update_sql_file};" 2>&1 >/dev/null 
			echo "${1} exec superGirl_update.sql succ, sqlver: ${svn_ver_local}";
		else
			echo "no change"
		fi	
	else
		echo "no superGirl_update.sql, plz continue."
	fi
}

start_one_server(){
	id=$1
	runing_sids=$(ps -ef |grep java|grep -v grep|awk '{print $2,$14}'|awk -F'-Dsid=' '{print $2}'|sed s/[[:space:]]/,/g|sed s/,,/,/g)
	for sid in ${runing_sids}
	do
		if [ ${sid} -eq ${id} ]; then
			echo "${sid} is running"
		    return	
		fi
	done

	cd /data/server/s${id}/bin && sh startup.sh &

	if [ $? -eq 0 ]; then
		/usr/local/mysql/bin/mysql -uppgames -p'IDFS(7^%x#2' -h10.168.79.161 supergirlserver -e "update t_server set state=1 where sid=${id}"
		echo "${id} start succ"
	else
		echo "${id} start fail,plz check"
	fi
}

stop_one_server(){
	# FIXME should pid save in t_server ?
	sid="$1"
	runing_pid_sid=$(ps -ef |grep java|grep -v grep|awk '{print $2,$14}'|awk -F'-Dsid=' '{print $1,$2}'|sed s/[[:space:]]/,/g|sed s/,,/,/g)
    for pid_sid in ${runing_pid_sid}
    do
		psid=$(echo ${pid_sid}|cut -d, -f2)
        pid=$(echo ${pid_sid}|cut -d, -f1)
        #show "s${psid},${sid},${pid}"
        if [ "s${sid}" == "s${psid}" ]; then
			sudo kill -15 ${pid} 
			if [ $? -eq 0 ]; then
				/usr/local/mysql/bin/mysql -uppgames -p'IDFS(7^%x#2' -h10.168.79.161 supergirlserver -e "update t_server set state=0 where sid=${sid}" 
			fi
			sleep 1
			break;
		fi
    done
	echo "${sid} stopped" 
}

confirm_one_server_stop(){
	sid="$1"
	runing_sids=$(ps -ef |grep java|grep -v grep|awk '{print $2,$14}'|grep -v cloud|grep -v classpath|awk -F'-Dsid=' '{print $2}'|sed s/[[:space:]]/,/g|sed s/,,/,/g)
	for s in ${runing_sids}
	do
		if [ "s${s}" == "s${sid}" ]; then
			echo "no, plz wait"
			return
		fi
	done
	echo "yes,stopped" && return
}

confirm_one_server_start(){
	sid="$1"
    runing_sids=$(ps -ef |grep java|grep -v grep|awk '{print $2,$14}'|grep -v cloud|grep -v classpath|awk -F'-Dsid=' '{print $2}'|sed s/[[:space:]]/,/g|sed s/,,/,/g)
    for s in ${runing_sids}
    do
        if [ "s${s}" == "s${sid}" ]; then
            echo "yes, started"
            return
        fi
    done
    echo "no,plz wait" && return
}

stop_one_server_now(){
    sid="$1"
    runing_pid_sid=$(ps -ef |grep java|grep -v grep|awk '{print $2,$14}'|awk -F'-Dsid=' '{print $1,$2}'|sed s/[[:space:]]/,/g|sed s/,,/,/g)
    for pid_sid in ${runing_pid_sid}
    do
        psid=$(echo ${pid_sid}|cut -d, -f2)
        pid=$(echo ${pid_sid}|cut -d, -f1)
        if [ "s${sid}" == "s${psid}" ]; then
            sudo kill -9 ${pid}
            if [ $? -eq 0 ]; then
				/usr/local/mysql/bin/mysql -uppgames -p'IDFS(7^%x#2' -h10.168.79.161 supergirlserver -e "update t_server set state=0 where sid=${sid}"
            fi
			sleep 1
            break;
        fi
    done
    echo "${sid} stopped" 
}

case "$1" in
	backup_all_db)
		backup_all_db
	;;
	backup_one_db)
		backup_one_db $2
	;;
	update_one_server_code)
		update_one_server_code $2
	;;
	update_one_server_db)
		update_one_server_db $2
	;;
	stop_one_server)
		stop_one_server $2
	;;
	confirm_one_server_stop)
		confirm_one_server_stop $2
	;;
	confirm_one_server_start)
		confirm_one_server_start $2
	;;
	start_one_server)
		start_one_server $2
	;;
	stop_one_server_now)
		stop_one_server_now $2
	;;
	*)
	exit
esac
