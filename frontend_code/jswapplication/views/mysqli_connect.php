<?php

define('DB_USER', 'web');
define('DB_PASSWORD', 'W3bU$er!89');
define('DB_HOST', 'localhost');
define('DB_NAME', 'suvetracg');

class Connection {
    public static function getConnection(): PDO {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        return new PDO($dsn, DB_USER, DB_PASSWORD, $options);
    }
}
