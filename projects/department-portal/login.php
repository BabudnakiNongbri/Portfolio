<?php

session_start();

include "config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("
        SELECT *
        FROM users
        WHERE email = :email
    ");

    $stmt->execute([
        ":email" => $email
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {

        if (password_verify($password, $user["password"])) {

            $_SESSION["user"] = $user["name"];

            echo "
            <script>
                alert('Login successful!');
                window.location.href = 'index.html';
            </script>
            ";

        } else {

            echo "
            <script>
                alert('Invalid password!');
                window.location.href = 'login.html';
            </script>
            ";

        }

    } else {

        echo "
        <script>
            alert('User not found!');
            window.location.href = 'login.html';
        </script>
        ";

    }
}

?>