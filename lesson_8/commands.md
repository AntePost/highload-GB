In shell:  
`sudo rpm -Uvh https://repo.zabbix.com/zabbix/3.0/rhel/7/x86_64/zabbix-release-3.0-1.el7.noarch.rpm`  
`sudo yum install zabbix-server-mysql zabbix-web-mysql`  
`mysql -u root -p`  
`create database zabbix character set utf8 collate utf8_bin;`  
`create user 'zabbix'@'localhost' identified by 'xxx';`  
`grant all privileges on zabbix.* to 'zabbix'@'localhost';`  
`quit;`  
`sudo zcat /usr/share/doc/zabbix-server-mysql-3.0.*/create.sql.gz | mysql -uroot -p zabbix`  
`sudo nano /etc/zabbix/zabbix_server.conf`  
In /etc/zabbix/zabbix_server.conf:  
`DBHost=localhost`  
`DBPassword=xxx`  
In shell:  
`sudo systemctl start zabbix-server`  
`sudo systemctl enable zabbix-server`  
`sudo nano /etc/nginx/conf.d/mysite.local.conf`  
In /etc/nginx/conf.d/mysite.local.conf:  
Изменения согласно методичке.  
In shell:  
`sudo systemctl restart nginx`  
`sudo chown -R nginx:nginx /var/opt/remi/php72/lib/php/session`  
`sudo systemctl restart php72-php-fpm`  
`sudo yum install php72-php-mbstring php72-php-gd php72-php-snmp php72-php-pecl-mysql php72-php-bcmath php72-php-xml`  
`sudo systemctl restart php72-php-fpm`  
