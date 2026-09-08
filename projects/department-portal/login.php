<?php

session_start();

include "config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users
            WHERE email = '$email'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify(
            $password,
            $user["password"]
        )) {

            $_SESSION["user"] = $user["name"];

            echo "
            <script>
                alert('Login successful!');
                window.location.href = 'index.html';
            </script>
            ";

        } else {

            echo "Invalid password.";

        }

    } else {

        echo "User not found.";

    }

}

?>