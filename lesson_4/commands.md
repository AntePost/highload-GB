# Commands for task 2

## Check network adapter on master & slave
`ip a`

## Edit my.cnf on master
`server-id = 1`  
`log_bin = mysql-bin.log`  
`binlog_do_db = highload`

## Create user on master for replication
Had to do it in two commands, because unified command threw SQL syntax error  
`CREATE USER 'slave_user'@'%' IDENTIFIED BY '***';`  
`GRANT REPLICATION SLAVE ON *.* TO 'slave_user'@'%';`

Didn't do locking tables on master and dump transfer on slave, because I cloned VM, so DBs should be identical.
I understand that in production you shouldn't do that, you should do a lock and a proper dump transfer between master and slave.

## Edit my.cnf on slave
`server-id = 2`  
`relay-log = mysql-relay-bin.log`  
`log_bin = mysql-bin.log`  
`replicate_do_db = highload`

## Turn on replication on slave
`CHANGE MASTER TO MASTER_HOST='10.0.2.4', MASTER_USER='slave_user', MASTER_PASSWORD='***', MASTER_LOG_FILE='mysql-bin.000001', MASTER_LOG_POS=1779;`  
`START SLAVE;`

After that the slave couldn't connect to master with the following error:
`Access denied for user 'slave_user'@'gateway'`  
Problem was solved by restarting both VMs.

Next the was an error due to DBs having identical UUID (becaused I cloned VMs).
Problem was solved by deleting auto.conf on slave and restarting DB.
