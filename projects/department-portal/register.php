<?php

include "config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $password = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $sql = "INSERT INTO users
            (name, email, password)
            VALUES
            ('$name', '$email', '$password')";

    if (mysqli_query($conn, $sql)) {

        echo "
        <script>
            alert('Registration successful!');
            window.location.href = 'login.html';
        </script>
        ";

    } else {

        echo "Registration failed: "
             . mysqli_error($conn);

    }

}

?>