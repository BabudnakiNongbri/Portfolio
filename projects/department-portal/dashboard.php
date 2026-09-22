<?php

session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.html");
    exit();
}

$user = $_SESSION["user"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Department Portal</title>

    <link rel="stylesheet" href="css/style.css">

    <style>

        .dashboard {
            min-height: calc(100vh - 80px);
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: #eef2f7;
            padding: 40px;
        }

        .dashboard-card {
            background: white;
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 100%;
        }

        .dashboard-card h1 {
            color: #111827;
            margin-bottom: 15px;
        }

        .dashboard-card p {
            color: #555;
            margin-bottom: 30px;
            font-size: 18px;
        }

        .dashboard-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .dashboard-buttons a {
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
        }

        .home-btn {
            background: #38bdf8;
            color: white;
        }

        .logout-btn {
            background: #ef4444;
            color: white;
        }

    </style>

</head>

<body>

    <nav class="navbar">

        <div class="logo">
            🎓 Department Portal
        </div>

        <ul class="nav-links">

            <li>
                <a href="index.html">Home</a>
            </li>

            <li>
                <a href="about.html">About Us</a>
            </li>

            <li>
                <a href="dashboard.php">Dashboard</a>
            </li>

            <li>
                <a href="logout.php">Logout</a>
            </li>

        </ul>

    </nav>


    <section class="dashboard">

        <div class="dashboard-card">

            <h1>Welcome, <?php echo htmlspecialchars($user); ?>! 🎉</h1>

            <p>
                You have successfully logged in to the Department Portal.
            </p>

            <div class="dashboard-buttons">

                <a href="index.html" class="home-btn">
                    Back to Home
                </a>

                <a href="logout.php" class="logout-btn">
                    Logout
                </a>

            </div>

        </div>

    </section>

</body>

</html>