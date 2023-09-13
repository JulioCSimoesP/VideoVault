<?php
require_once __DIR__ . '/vendor/autoload.php';

$pdo = \juliocsimoesp\PHPMVC1\Model\Infrastructure\Persistence\SqliteConnectionCreator::createConnection();
$readQuery = "SELECT * FROM videos WHERE id = 4;";
$statement = $pdo->prepare($readQuery);
$statement->execute();
$queryResult = $statement->fetch();
$userRepo = new \juliocsimoesp\PHPMVC1\Model\Infrastructure\Repository\PdoUserRepository($pdo);

var_dump(password_hash('1234654sdsd', PASSWORD_ARGON2ID));
//$video = new \juliocsimoesp\PHPMVC1\Model\Domain\Entity\Video('https://www.youtube.com/embed/QtXby3twMmI', 'asfdasdf');