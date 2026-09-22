<?php

session_start();

include "db.php";

$message = "";
$messageType = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];


    if (empty($email) || empty($password)) {

        $message = "Please enter your email and password.";
        $messageType = "error";

    } else {

        $stmt = $conn->prepare(
            "SELECT
                id,
                name,
                email,
                password,
                role,
                content_access
             FROM users
             WHERE email = ?"
        );

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();


        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();


            if (password_verify($password, $user["password"])) {

                /*
                 * Store user information in session
                 */

                $_SESSION["user_id"] =
                    $user["id"];

                $_SESSION["name"] =
                    $user["name"];

                $_SESSION["email"] =
                    $user["email"];

                $_SESSION["role"] =
                    $user["role"];

                $_SESSION["content_access"] =
                    $user["content_access"];


                /*
                 * Login successful
                 */

                header("Location: dashboard.php");

                exit();


            } else {

                $message =
                    "Incorrect email or password.";

                $messageType = "error";
            }


        } else {

            $message =
                "Incorrect email or password.";

            $messageType = "error";
        }


        $stmt->close();
    }
}

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Login | MCA42
    </title>

    <link
        rel="stylesheet"
        href="style.css"
    >

</head>


<body>


<!-- =========================
     NAVBAR
========================= -->

<header class="navbar">

    <div class="logo">
        MCA<span>42</span>
    </div>


    <nav>

        <a href="index.php">
            Home
        </a>

        <a
            href="register.php"
            class="register-btn"
        >
            Register
        </a>

    </nav>

</header>


<!-- =========================
     LOGIN
========================= -->

<div class="auth-container">

    <div class="auth-card login-card">


        <div class="auth-logo">
            MCA<span>42</span>
        </div>


        <h1>
            Welcome Back
        </h1>


        <p class="auth-subtitle">
            Login to your MCA42 account
        </p>


        <?php if ($message != ""): ?>

            <div class="message <?php echo $messageType; ?>">

                <?php
                echo htmlspecialchars($message);
                ?>

            </div>

        <?php endif; ?>


        <form method="POST">


            <label for="email">
                Email Address
            </label>


            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
                required
            >


            <label for="password">
                Password
            </label>


            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
            >


            <button
                type="submit"
                class="primary-btn full-btn"
            >
                Login
            </button>


        </form>


        <p class="bottom-text">

            Don't have an account?

            <a href="register.php">
                Register here
            </a>

        </p>


    </div>

</div>


<!-- =========================
     FOOTER
========================= -->

<footer>

    <div class="copyright">

        © 2026 MCA42. All Rights Reserved.

    </div>

</footer>


</body>

</html>