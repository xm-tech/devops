#/bin/bash

########################################################
# 进程监控脚本,扫描应当运行的服务器,若没运行则启动
########################################################

source /data/script/common.sh

inip=$(get_in_ip)
main(){
	while [[ true ]]; do
		runing_sids=`ps axu|grep java|grep -v cloudmonitor|grep -v jmxremote|grep -v grep|awk -F'sid=' '{print $2}'`

		conf_sids_sql="SELECT sid FROM t_server WHERE state=1 and inip = '${inip}'"
		conf_sids=$(/usr/local/mysql/bin/mysql -uppgames -p'IDFS(7^%x#2' -h121.40.207.204 supergirlserver -sse "${conf_sids_sql}")

		for csid in ${conf_sids};do
    		# assume not running
			runing=0
			for rsid in ${runing_sids};do
				if [ ${rsid} -eq ${csid} ];then
            		runing=1
            		break
				fi
			done

			if [ ${runing} -eq 0 ];then
				cd /data/server/s${csid}/bin
				#echo "start ${csid} ... " 
				sh startup.sh &
			fi
		done

		sleep 1

		# foreach all running sids , if should not run, stop it
		runing_pid_sids=$(ps axu|grep java|grep -v cloudmonitor|grep -v grep|awk '{print $2$17}'|awk -F'-Dsid=' '{print $1","$2}')
		for rps in ${runing_pid_sids}; do
			eval $(echo ${rps}|awk -F',' '{print "_pid="$1";_sid="$2}')
			should_run=0
			for csid in ${conf_sids}; do
				if [ ${_sid} -eq ${csid} ]; then
					should_run=1
					break
				fi
			done
			if [ ${should_run} -eq 0 ]; then
				# should not run, stop it	
				kill -15 ${_pid} &
			fi
		done		

		sleep $1
	done
}

main $1
