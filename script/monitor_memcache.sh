#!/bin/bash

main(){
	while [[ true ]]; do
		num=$(ps axu|grep memcached|grep -v grep|wc -l)
		if [ ${num} -eq 0 ];then
			sh startup_memcached.sh >/dev/null 2>&1 &
		fi
		sleep 5
	done
}

main
