<?php

session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php");
    exit();
}

$error = "";

$admin_email = "admin@contactly.com";
$admin_password = "admin123";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email === $admin_email && $password === $admin_password) {

        $_SESSION['logged_in'] = true;
        $_SESSION['admin_email'] = $email;

        header("Location: index.php");
        exit();

    } else {

        $error = "Invalid email or password.";

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Contactly</title>

    <link rel="stylesheet" href="style.css">

</head>

<body class="login-page">

    <div class="login-card">

        <div class="login-logo">
            ◉
        </div>

        <span class="tag">CONTACTLY</span>

        <h1>Welcome back</h1>

        <p class="login-subtitle">
            Sign in to manage your contacts.
        </p>

        <?php if ($error != ""): ?>

            <div class="login-error">
                <?php echo $error; ?>
            </div>

        <?php endif; ?>


        <form method="POST">

            <label>Email Address</label>

            <input
                type="email"
                name="email"
                placeholder="admin@contactly.com"
                required
            >


            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter your password"
                required
            >


            <button
                type="submit"
                name="login"
                class="login-button"
            >
                Sign In
            </button>

        </form>

        <p class="login-footer">
            Contact Management System
        </p>

    </div>

</body>

</html>