# Commands for task 2
`sudo yum install memcached php72-php-pecl-memcached`  
`/opt/remi/php72/root/usr/sbin/php-fpm -m | grep memcached`  
`sudo systemctl restart php72-php-fpm`  
`sudo systemctl start memcached`  
`sudo netstat -tap | grep memcached`  
`sudo nano /etc/opt/remi/php72/php.ini`  
В php.ini:  
session.save_handler = memcache  
session.save_path = "localhost:11211?persistent=1&weight=1&timeout=1&retry_interval=15"  
Далее возникла проблема с тем, что php.ini отказывался обновляться.  
Проблема заключалась в том, что конфиг php-fpm перетирал настройки php.ini.  
`sudo nano /etc/opt/remi/php72/php-fpm.d/www.conf`  
В www.conf:  
; php_value[session.save_handler] = files  
; php_value[session.save_path]    = /var/opt/remi/php72/lib/php/session  

# Commands for task 3
`sudo ln -s /var/www/mysite.local/ /var/www/mysite.local2`  
`sudo nano /etc/nginx/conf.d/mysite.local.conf`  
В mysite.local.conf:  
root /var/www/mysite.local2;  
`sudo systemctl restart nginx`  
В моем случае все завелось сразу.  
Если же в настройках nginx прописать disable_symlinks on;, то сервер предсказуемо выдает 404.  