<?php

/*
 * Database connection - Nexora / MCA42 Company Portal
 *
 *  - XAMPP / local : works as-is (host localhost, user root, no password)
 *  - Online hosting: set the DB_* environment variables (see DEPLOY.md)
 */

mysqli_report(MYSQLI_REPORT_OFF);

$dbOnline   = (bool) getenv("DB_HOST");
$dbHost     = getenv("DB_HOST") ?: "localhost";
$dbPort     = (int) (getenv("DB_PORT") ?: 3306);
$dbUser     = getenv("DB_USER") ?: "root";
$dbPassword = getenv("DB_PASSWORD") ?: "";
$dbName     = getenv("DB_NAME_NEXORA") ?: "nexora_company";

$conn = mysqli_init();
$dbFlags = 0;

// Cloud MySQL servers (Aiven, TiDB, ...) require an encrypted connection
if ($dbOnline && getenv("DB_SSL") !== "false") {
    $dbCa = getenv("DB_SSL_CA") ?: "/etc/ssl/certs/ca-certificates.crt";
    mysqli_ssl_set($conn, null, null, $dbCa, null, null);
    $dbFlags = MYSQLI_CLIENT_SSL;
    if (!getenv("DB_SSL_CA")) {
        $dbFlags |= MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT;
    }
}

if (!@mysqli_real_connect($conn, $dbHost, $dbUser, $dbPassword, null, $dbPort, null, $dbFlags)) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Create the database and table on first run (safe to repeat)
$dbMarker = sys_get_temp_dir() . "/schema_" . md5($dbHost . $dbName . "users");

if (!file_exists($dbMarker)) {
    mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4");
}

if (!mysqli_select_db($conn, $dbName)) {
    die("Could not open database '$dbName': " . mysqli_error($conn));
}

mysqli_set_charset($conn, "utf8mb4");

if (!file_exists($dbMarker)) {

    mysqli_query($conn, "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin','employee') NOT NULL DEFAULT 'employee',
            department VARCHAR(100) DEFAULT NULL,
            phone VARCHAR(30) DEFAULT NULL,
            content_access ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) CHARACTER SET utf8mb4
    ");

    // Online only: make sure there is one admin account to log in with.
    // (Your local XAMPP database is never touched.)
    if ($dbOnline) {

        $adminCheck = mysqli_query($conn, "SELECT id FROM users WHERE role = 'admin' LIMIT 1");

        if ($adminCheck && mysqli_num_rows($adminCheck) === 0) {

            $adminName  = "Administrator";
            $adminEmail = getenv("NEXORA_ADMIN_EMAIL") ?: "admin@mca42.com";
            $adminHash  = password_hash(getenv("NEXORA_ADMIN_PASSWORD") ?: "Admin@123", PASSWORD_DEFAULT);
            $adminDept  = "Administration";
            $adminPhone = "0000000000";

            $seed = mysqli_prepare(
                $conn,
                "INSERT INTO users (name, email, password, role, department, phone, content_access)
                 VALUES (?, ?, ?, 'admin', ?, ?, 'approved')"
            );

            mysqli_stmt_bind_param($seed, "sssss", $adminName, $adminEmail, $adminHash, $adminDept, $adminPhone);
            mysqli_stmt_execute($seed);
            mysqli_stmt_close($seed);
        }
    }

    @touch($dbMarker);
}

?>
