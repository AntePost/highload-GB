<?php
require_once('vendor/autoload.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPProtocolChannelException;
use PhpAmqpLib\Message\AMQPMessage;

// Это грубая реализация цепочки микросервисов, которые работают по принципу publish-subscribe.
// Часть "subscribe" реализована не была.

function publishInQueue($queueName, $message) {
    $isSuccess = false;
    try {
        // соединяемся с RabbitMQ
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest'); 
    
        // Создаем канал общения с очередью
        $channel = $connection->channel();
        $channel->queue_declare($queueName, false, true, false, false);
        
        // создаем сообщение
        $msg = new AMQPMessage($message);
        // размещаем сообщение в очереди
        $channel->basic_publish($msg, '', $queueName);
        
        // закрываем соединения
        $channel->close();
        $connection->close();
        $isSuccess = true;
    }
    catch (AMQPProtocolChannelException $e){
        echo $e->getMessage();
    }
    catch (AMQPException $e){
        echo $e->getMessage();
    }

    return $isSuccess;
}

function requestHandler()
{
    // Принимает запрос от клиента и обрабатывает его.
    $foodOrderData = "some food order data"; // В эту переменную записываются данные для микросервиса заказа еды.
    publishInQueue("food_order", "new food order request with $foodOrderData has been created");
}

// Запускается когда в очереди "food_order" появляется новое сообщение
function orderFood()
{
    // Логика заказа еды: обращение к соответствующему микросервису и т.п.
    $billingData = "some billing data"; // В эту переменную записываются данные для микросервиса оплаты.
    $isSuccess = true; // Значение присваевается в случае успеха работы микросервиса.
    if ($isSuccess) {
        publishInQueue("billing", "new billing request with $billingData has been created");
    }
}

// Запускается когда в очереди "billing" появляется новое сообщение
function billing()
{
    // Логика оплаты: обращение к соответствующему микросервису и т.п.
    $deliveryData = "some delivery data"; // В эту переменную записываются данные для микросервиса доставки.
    $isSuccess = true; // Значение присваевается в случае успеха работы микросервиса.
    if ($isSuccess) {
        publishInQueue("delivery", "new delivery request with $deliveryData has been created");
    }
}

// Запускается когда в очереди "delivery" появляется новое сообщение
function delivery()
{
    // Логика доставки: обращение к соответствующему микросервису и т.п.
    $reviewData = "some review data"; // В эту переменную записываются данные для микросервиса отзывов.
    $isSuccess = true; // Значение присваевается в случае успеха работы микросервиса.
    if ($isSuccess) {
        publishInQueue("review", "new review request with $reviewData has been created");
    }
}

// Запускается когда в очереди "review" появляется новое сообщение
function review()
{
    // Логика отзыва: обращение к соответствующему микросервису и т.п.
    $responseData = "some response data"; // В эту переменную записываются данные для обработчика ответа клиенту.
    $isSuccess = true; // Значение присваевается в случае успеха работы микросервиса.
    if ($isSuccess) {
        publishInQueue("response", "new response request with $responseData has been created");
    }
}

// Запускается когда в очереди "response" появляется новое сообщение
function responseHandler()
{
    // Логика ответа клиенту.
    $isSuccess = true; // Значение присваевается в случае успеха работы логики.
    if ($isSuccess) {
        publishInQueue("success", "request with id xxx has been successfully handled");
    }
}

// Демонстранция работы (в реальности отдельные функции будут запускаться в соответствии с паттерном publish-subscribe)
function demo()
{
    requestHandler();
    orderFood();
    billing();
    delivery();
    review();
    responseHandler();
}

demo();
