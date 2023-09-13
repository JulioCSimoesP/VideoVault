<?php
session_start();

require_once  __DIR__ . '/../vendor/autoload.php';

use juliocsimoesp\PHPMVC1\Controller\Error404Controller;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Persistence\SqliteConnectionCreator;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Repository\PdoUserRepository;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Repository\PdoVideoRepository;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Service\RedirectionManager;

$pdo = SqliteConnectionCreator::createConnection();
$videoRepository = new PdoVideoRepository($pdo);
$userRespository = new PdoUserRepository($pdo);

$requestPath =  $_SERVER['PATH_INFO'] ?? '/';
$requestMethod = $_SERVER['REQUEST_METHOD'];
$routes = require_once __DIR__ . './../config/routes.php';
$logged = $_SESSION['logado'] ?? false;

if (!$logged && $requestPath !== '/login') {
    RedirectionManager::redirect('login', ['erro' => 2]);
}

$controllerClass = $routes["$requestMethod|$requestPath"] ?? Error404Controller::class;
$controller = new $controllerClass($videoRepository, $userRespository);
$controller->processRequest();
