<?php

namespace juliocsimoesp\PHPMVC1\Model\Infrastructure\Persistence;

use PDO;

class SqliteConnectionCreator
{
    private static string $DATABASE_PATH = __DIR__ . '/../../../../database.sqlite';

    public static function createConnection(): PDO
    {
        $path = self::$DATABASE_PATH;
        $pdo = new PDO("sqlite:$path");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }
}