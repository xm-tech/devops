#!/bin/bash

main(){
    yestoday=$(date --date='1 days ago' +%Y%m%d)
    day_30_ago=$(date --date='30 days ago' +%Y%m%d)
    servers=$(ls /data/server/|grep -v server|grep -v s0)
    for s in ${servers}
    do
		bin_log_file=/exdisk/logs/${s}/bin/out.txt
		if [ -s ${bin_log_file} ]; then
			cd /exdisk/logs/${s}/bin
			\cp out.txt out.txt.${yestoday}
			>out.txt
			rm -f out.txt.${day_30_ago}
		fi
    done
}

main
