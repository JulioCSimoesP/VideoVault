<?php

require_once  __DIR__ . '/../vendor/autoload.php';

use juliocsimoesp\PHPMVC1\Controller\Error404Controller;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Persistence\SqliteConnectionCreator;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Repository\PdoVideoRepository;

$pdo = SqliteConnectionCreator::createConnection();
$videoRepository = new PdoVideoRepository($pdo);

$requestPath =  $_SERVER['PATH_INFO'] ?? '/';
$requestMethod = $_SERVER['REQUEST_METHOD'];
$routes = require_once __DIR__ . './../config/routes.php';

$controllerClass = $routes["$requestMethod|$requestPath"] ?? Error404Controller::class;
$controller = new $controllerClass($videoRepository);
$controller->processRequest();
