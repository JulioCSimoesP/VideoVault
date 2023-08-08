<?php
return [
    'GET|/' => \juliocsimoesp\PHPMVC1\Controller\VideoListController::class,
    'GET|/remover-video' => \juliocsimoesp\PHPMVC1\Controller\DeleteVideoController::class,
    'GET|/editar-video' => \juliocsimoesp\PHPMVC1\Controller\VideoFormController::class,
    'POST|/editar-video' => \juliocsimoesp\PHPMVC1\Controller\UpdateVideoController::class,
    'GET|/novo-video' => \juliocsimoesp\PHPMVC1\Controller\VideoFormController::class,
    'POST|/novo-video' => \juliocsimoesp\PHPMVC1\Controller\NewVideoController::class,
    'GET|/login' => \juliocsimoesp\PHPMVC1\Controller\LoginFormController::class,
    'POST|/login' => \juliocsimoesp\PHPMVC1\Controller\LoginController::class
];