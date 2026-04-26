<?php
// includes/db.php

$host = 'localhost';
$db   = 'yesefersew_db';
$user = 'root'; // Change as needed
$pass = '';     // Change as needed
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // For local testing in environments without MySQL, you might want to use SQLite
     // throw new \PDOException($e->getMessage(), (int)$e->getCode());

     // Fallback to SQLite for the sake of this sandbox if needed,
     // but the primary target is MySQL as requested by SQL.
     try {
        $pdo = new PDO("sqlite:" . __DIR__ . "/../database.sqlite");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch (\PDOException $e2) {
        die("Connection failed: " . $e->getMessage());
     }
}
