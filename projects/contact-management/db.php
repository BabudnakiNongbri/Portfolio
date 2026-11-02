<?php

/*
 * Database connection - Contact Management
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
$dbName     = getenv("DB_NAME_CONTACT") ?: "contact_manager";

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
$dbMarker = sys_get_temp_dir() . "/schema_" . md5($dbHost . $dbName . "contacts");

if (!file_exists($dbMarker)) {
    mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4");
}

if (!mysqli_select_db($conn, $dbName)) {
    die("Could not open database '$dbName': " . mysqli_error($conn));
}

mysqli_set_charset($conn, "utf8mb4");

if (!file_exists($dbMarker)) {

    mysqli_query($conn, "
        CREATE TABLE IF NOT EXISTS contacts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL,
            phone VARCHAR(30) NOT NULL,
            address TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) CHARACTER SET utf8mb4
    ");

    @touch($dbMarker);
}

?>
