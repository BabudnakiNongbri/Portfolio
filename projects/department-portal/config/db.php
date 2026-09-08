<?php

$dbFolder = __DIR__ . "/../database";

if (!is_dir($dbFolder)) {
    mkdir($dbFolder, 0777, true);
}

$dbPath = $dbFolder . "/department.db";

try {

    $conn = new PDO("sqlite:" . $dbPath);

    $conn->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $conn->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            registered_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

} catch (PDOException $e) {

    die("Database connection failed: " . $e->getMessage());

}

?>