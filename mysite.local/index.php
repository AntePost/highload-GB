<?php

require_once('vendor/autoload.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

xdebug_start_trace();

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Src\MyLogger;

// create a log channel
$log = new Logger('MyApp');
$log->pushHandler(new StreamHandler('log/my.log', Logger::INFO));

$currentMemory = MyLogger::logCurrentMemory();
$log->info("Memory: $currentMemory[memoryUse] bytes at $currentMemory[currentDateTime]");

for ($i=0; $i < 1000000; $i++) {};

$currentMemory = MyLogger::logCurrentMemory();
$log->info("Memory: $currentMemory[memoryUse] bytes at $currentMemory[currentDateTime]");
$log->info(MyLogger::displayMemoryDifference(1));

echo xdebug_stop_trace();