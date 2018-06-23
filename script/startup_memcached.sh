#!/bin/bash

main(){
	/usr/local/bin/memcached -d -m 1024 -u root -l 127.0.0.1 -p 11211 -P /tmp/memcached.pid		
}

#sid=$(echo $1|cut -c 2-)
#main ${sid}
main
