<?php

include "config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $hashedPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    try {

        $stmt = $conn->prepare("
            INSERT INTO users
            (name, email, password)
            VALUES
            (:name, :email, :password)
        ");

        $stmt->execute([
            ":name" => $name,
            ":email" => $email,
            ":password" => $hashedPassword
        ]);

        echo "
        <script>
            alert('Registration successful!');
            window.location.href = 'login.html';
        </script>
        ";

    } catch (PDOException $e) {

        if ($e->getCode() == 23000) {

            echo "
            <script>
                alert('Email already registered!');
                window.location.href = 'register.html';
            </script>
            ";

        } else {

            echo "Registration failed.";

        }
    }
}

?>