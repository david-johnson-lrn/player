<?php

use Dotenv\Dotenv;

require 'vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo getenv('CONSUMER_KEY_DEMO');

echo "Hello";
