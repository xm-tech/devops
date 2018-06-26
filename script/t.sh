#!/bin/bash
source /data/script/common.sh

say(){
	echo $1
}

get_ip(){
    echo $1
}

cmd=$1

case ${cmd} in
	say)
		say $2
	;;
	getip)
		getip
	;;
	get_in_ip)
		get_in_ip
	;;
	now)
		now
	;;
	*)
	exit
esac
