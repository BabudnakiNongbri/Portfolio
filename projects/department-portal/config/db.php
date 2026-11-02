<?php

/*
 * Database connection - Department Portal
 *
 *  - Online hosting (DB_HOST is set): uses the cloud MySQL database
 *  - Local (no DB_HOST)             : uses a SQLite file, no setup needed
 */

try {

    $dbHost = getenv("DB_HOST");

    if ($dbHost) {

        $dbPort = getenv("DB_PORT") ?: 3306;
        $dbName = getenv("DB_NAME_DEPARTMENT") ?: "department_portal";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        // Cloud MySQL servers require an encrypted connection
        if (getenv("DB_SSL") !== "false") {
            $options[PDO::MYSQL_ATTR_SSL_CA] =
                getenv("DB_SSL_CA") ?: "/etc/ssl/certs/ca-certificates.crt";
            $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] =
                (bool) getenv("DB_SSL_CA");
        }

        $conn = new PDO(
            "mysql:host=$dbHost;port=$dbPort;charset=utf8mb4",
            getenv("DB_USER") ?: "root",
            getenv("DB_PASSWORD") ?: "",
            $options
        );

        $marker = sys_get_temp_dir() . "/schema_" . md5($dbHost . $dbName . "dept");

        if (!file_exists($marker)) {
            $conn->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4");
        }

        $conn->exec("USE `$dbName`");

        if (!file_exists($marker)) {
            $conn->exec("
                CREATE TABLE IF NOT EXISTS users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100) NOT NULL,
                    email VARCHAR(150) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) CHARACTER SET utf8mb4
            ");
            @touch($marker);
        }

    } else {

        $dbFolder = __DIR__ . "/../database";

        if (!is_dir($dbFolder)) {
            mkdir($dbFolder, 0777, true);
        }

        $conn = new PDO("sqlite:" . $dbFolder . "/department.db");

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL,
                registered_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

} catch (PDOException $e) {

    die("Database connection failed: " . $e->getMessage());

}

?>
