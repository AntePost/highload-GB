# Commands for task 1
`sudo yum install rabbitmq-server`  
`sudo rabbitmq-plugins enable rabbitmq_management`  
`sudo systemctl start rabbitmq-server`  
`sudo iptables -F`  
`sudo netstat -tupln`  
GUI RabbitMQ запускается успешно.

# Commands for task 3
`sudo yum install php72-php-mbstring`  
`sudo systemctl restart php72-php-fpm`  
Обновил руками composer.json, добавив туда "php-amqplib/php-amqplib": "^2.6" в блок "require"  
`sudo composer install`  
