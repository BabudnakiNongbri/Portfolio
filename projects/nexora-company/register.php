<?php

include "db.php";

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $department = trim($_POST["department"]);
    $phone = trim($_POST["phone"]);

    // Basic validation
    if (
        empty($name) ||
        empty($email) ||
        empty($password)
    ) {

        $message = "Please fill in all required fields.";
        $messageType = "error";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";
        $messageType = "error";

    } elseif (strlen($password) < 6) {

        $message = "Password must contain at least 6 characters.";
        $messageType = "error";

    } else {

        // Check whether email already exists
        $check = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $check->bind_param("s", $email);

        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "An account with this email already exists.";
            $messageType = "error";

        } else {

            // Securely hash password
            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // All public registrations are employees
            $role = "employee";

            // New employees need admin approval
            $contentAccess = "pending";

            // Insert user into database
            $stmt = $conn->prepare(
                "INSERT INTO users
                (name, email, password, role, department, phone, content_access)
                VALUES (?, ?, ?, ?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "sssssss",
                $name,
                $email,
                $hashedPassword,
                $role,
                $department,
                $phone,
                $contentAccess
            );

            if ($stmt->execute()) {

                $message =
                    "Registration successful! Your account is waiting for admin approval.";

                $messageType = "success";

            } else {

                $message =
                    "Registration failed. Please try again.";

                $messageType = "error";
            }

            $stmt->close();
        }

        $check->close();
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

    <title>Register | MCA42</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>


<!-- ================= NAVBAR ================= -->

<header class="navbar">

    <div class="logo">
        MCA<span>42</span>
    </div>

    <nav>

        <a href="index.php">
            Home
        </a>

        <a href="index.php#about">
            About
        </a>

        <a href="index.php#works">
            Our Works
        </a>

        <a href="index.php#testimonials">
            Testimonials
        </a>

        <a href="login.php" class="login-btn">
            Login
        </a>

    </nav>

</header>


<!-- ================= REGISTRATION ================= -->

<div class="auth-container">

    <div class="auth-card">

        <div class="auth-logo">
            MCA<span>42</span>
        </div>

        <h1>
            Create Your Account
        </h1>

        <p class="auth-subtitle">
            Register as an MCA42 employee
        </p>


        <?php if ($message != ""): ?>

            <div class="message <?php echo $messageType; ?>">

                <?php
                echo htmlspecialchars($message);
                ?>

            </div>

        <?php endif; ?>


        <form
            method="POST"
            id="registerForm"
        >

            <!-- NAME -->

            <label for="name">
                Full Name
            </label>

            <input
                type="text"
                id="name"
                name="name"
                placeholder="Enter your full name"
                required
            >


            <!-- EMAIL -->

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


            <!-- PHONE -->

            <label for="phone">
                Phone Number
            </label>

            <input
                type="text"
                id="phone"
                name="phone"
                placeholder="Enter your phone number"
            >


            <!-- DEPARTMENT -->

            <label for="department">
                Department
            </label>

            <select
                id="department"
                name="department"
            >

                <option value="">
                    Select Department
                </option>

                <option value="IT">
                    Information Technology
                </option>

                <option value="HR">
                    Human Resources
                </option>

                <option value="Finance">
                    Finance
                </option>

                <option value="Marketing">
                    Marketing
                </option>

                <option value="Operations">
                    Operations
                </option>

            </select>


            <!-- PASSWORD -->

            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Create a password"
                required
            >


            <!-- CONFIRM PASSWORD -->

            <label for="confirmPassword">
                Confirm Password
            </label>

            <input
                type="password"
                id="confirmPassword"
                name="confirmPassword"
                placeholder="Confirm your password"
                required
            >


            <button
                type="submit"
                class="primary-btn full-btn"
            >
                Create Employee Account
            </button>

        </form>


        <div class="approval-note">

             <strong>Admin Approval Required</strong>

            <p>
                After registration, your account will be reviewed
                by an MCA42 administrator before you can access
                restricted company information.
            </p>

        </div>


        <p class="bottom-text">

            Already have an account?

            <a href="login.php">
                Login here
            </a>

        </p>

    </div>

</div>


<script src="script.js"></script>

</body>

</html>