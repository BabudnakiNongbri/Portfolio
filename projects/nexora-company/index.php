<?php

session_start();

$isLoggedIn = isset($_SESSION["user_id"]);
$isApproved = false;
$isAdmin = false;
$userName = "";

if ($isLoggedIn) {

    $isApproved = isset($_SESSION["content_access"])
        && $_SESSION["content_access"] === "approved";

    $isAdmin = isset($_SESSION["role"])
        && $_SESSION["role"] === "admin";

    $userName = $_SESSION["name"] ?? "";
}

$canViewContent = $isAdmin || $isApproved;

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>MCA42 | Technology & Innovation</title>

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

        <?php if ($canViewContent): ?>

            <a href="#about">
                About
            </a>

            <a href="#works">
                Our Works
            </a>

            <a href="#testimonials">
                Testimonials
            </a>

        <?php endif; ?>


        <?php if (!$isLoggedIn): ?>

            <a href="login.php" class="login-btn">
                Login
            </a>

            <a href="register.php" class="register-btn">
                Register
            </a>

        <?php else: ?>

            <a href="dashboard.php" class="login-btn">
                Dashboard
            </a>

            <a href="logout.php" class="register-btn">
                Logout
            </a>

        <?php endif; ?>

    </nav>

</header>


<!-- ================= HERO ================= -->

<section class="hero" id="home">

    <div class="hero-content">

        <p class="hero-tag">
            TECHNOLOGY • INNOVATION • PEOPLE
        </p>

        <h1>
            Building ideas that
            <span>shape tomorrow.</span>
        </h1>

        <p class="hero-description">

            Welcome to MCA42, a technology-driven organization
            focused on innovation, digital solutions and
            building a better future through technology.

        </p>


        <?php if (!$isLoggedIn): ?>

            <div class="hero-buttons">

                <a href="register.php"
                   class="primary-btn">

                    Register

                </a>

                <a href="login.php"
                   class="secondary-btn">

                    Login

                </a>

            </div>


        <?php elseif (!$canViewContent): ?>

            <div class="access-message">

                🔒 Your account is awaiting administrator approval.

                <br>

                <span>
                    Additional MCA42 content will become available
                    after your account is approved.
                </span>

            </div>


        <?php else: ?>

            <div class="hero-buttons">

                <a href="#about"
                   class="primary-btn">

                    Explore MCA42

                </a>

                <a href="dashboard.php"
                   class="secondary-btn">

                    Open Dashboard

                </a>

            </div>

        <?php endif; ?>

    </div>

</section>


<?php if ($canViewContent): ?>


<!-- ================= ABOUT ================= -->

<section class="about-section" id="about">

    <div class="section-heading">

        <p>WHO WE ARE</p>

        <h2>
            Technology with a purpose.
        </h2>

    </div>


    <div class="about-content">

        <div class="about-text">

            <h3>
                Creating solutions that make a difference.
            </h3>

            <p>
                MCA42 brings together technology,
                creativity and people to develop practical
                digital solutions for modern challenges.
            </p>

            <p>
                From software development and digital
                platforms to business solutions, our team
                focuses on building reliable and
                user-friendly technology.
            </p>

            <p>
                We believe that great technology begins
                with great people working together.
            </p>

        </div>


        <div class="about-cards">

            <div class="mini-card">

                <div class="mini-icon">
                    💡
                </div>

                <h3>Innovation</h3>

                <p>
                    Turning ideas into useful digital solutions.
                </p>

            </div>


            <div class="mini-card">

                <div class="mini-icon">
                    👥
                </div>

                <h3>People</h3>

                <p>
                    Building teams that learn, create and grow.
                </p>

            </div>


            <div class="mini-card">

                <div class="mini-icon">
                    🚀
                </div>

                <h3>Growth</h3>

                <p>
                    Continuously improving through technology.
                </p>

            </div>


            <div class="mini-card">

                <div class="mini-icon">
                    🔐
                </div>

                <h3>Trust</h3>

                <p>
                    Keeping information secure and accessible.
                </p>

            </div>

        </div>

    </div>

</section>


<!-- ================= WORKS ================= -->

<section class="works-section" id="works">

    <div class="section-heading">

        <p>WHAT WE DO</p>

        <h2>
            Our Works
        </h2>

        <span>
            Some of the areas where MCA42 creates
            technology solutions.
        </span>

    </div>


    <div class="works-grid">

        <div class="work-card">

            <div class="work-number">01</div>

            <div class="work-icon">💻</div>

            <h3>
                Web Development
            </h3>

            <p>
                Designing responsive and modern websites
                that provide excellent user experiences.
            </p>

        </div>


        <div class="work-card">

            <div class="work-number">02</div>

            <div class="work-icon">📱</div>

            <h3>
                Application Solutions
            </h3>

            <p>
                Developing applications that help
                organizations manage their digital
                operations efficiently.
            </p>

        </div>


        <div class="work-card">

            <div class="work-number">03</div>

            <div class="work-icon">☁️</div>

            <h3>
                Digital Solutions
            </h3>

            <p>
                Helping businesses adopt modern digital
                technologies and connected workflows.
            </p>

        </div>


        <div class="work-card">

            <div class="work-number">04</div>

            <div class="work-icon">📊</div>

            <h3>
                Data & Management
            </h3>

            <p>
                Creating systems that organize information
                and make business management easier.
            </p>

        </div>

    </div>

</section>


<!-- ================= STATISTICS ================= -->

<section class="stats-section">

    <div class="stat">

        <h2>25+</h2>
        <p>Projects</p>

    </div>


    <div class="stat">

        <h2>15+</h2>
        <p>Team Members</p>

    </div>


    <div class="stat">

        <h2>10+</h2>
        <p>Solutions</p>

    </div>


    <div class="stat">

        <h2>95%</h2>
        <p>Client Satisfaction</p>

    </div>

</section>


<!-- ================= TESTIMONIALS ================= -->

<section
    class="testimonials-section"
    id="testimonials"
>

    <div class="section-heading">

        <p>WHAT PEOPLE SAY</p>

        <h2>
            Testimonials
        </h2>

    </div>


    <div class="testimonial-grid">


        <div class="testimonial-card">

            <div class="quote">
                "
            </div>

            <p>
                MCA42 helped us transform our idea into
                a practical digital solution. Their team
                was professional and easy to work with.
            </p>

            <div class="testimonial-person">

                <div class="person-avatar">
                    A
                </div>

                <div>

                    <h4>
                        Arjun Mehta
                    </h4>

                    <span>
                        Business Client
                    </span>

                </div>

            </div>

        </div>


        <div class="testimonial-card">

            <div class="quote">
                "
            </div>

            <p>
                The team understood our requirements and
                delivered a clean and efficient system.
                We were impressed with the results.
            </p>

            <div class="testimonial-person">

                <div class="person-avatar">
                    S
                </div>

                <div>

                    <h4>
                        Sarah Thomas
                    </h4>

                    <span>
                        Project Partner
                    </span>

                </div>

            </div>

        </div>


        <div class="testimonial-card">

            <div class="quote">
                "
            </div>

            <p>
                Working with MCA42 gave us a better
                understanding of how technology can
                simplify everyday business processes.
            </p>

            <div class="testimonial-person">

                <div class="person-avatar">
                    R
                </div>

                <div>

                    <h4>
                        Rahul Sharma
                    </h4>

                    <span>
                        Technology Partner
                    </span>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ================= CTA ================= -->

<section class="cta-section">

    <div>

        <p>
            MCA42 EMPLOYEE PORTAL
        </p>

        <h2>
            Welcome to MCA42.
        </h2>

        <span>
            You are viewing restricted company content
            available to approved users.
        </span>

    </div>


    <a href="dashboard.php"
       class="primary-btn">

        Dashboard

    </a>

</section>


<?php endif; ?>


<!-- ================= FOOTER ================= -->

<footer>

    <div class="footer-content">

        <div>

            <div class="logo">
                MCA<span>42</span>
            </div>

            <p>
                Technology. Innovation. People.
            </p>

        </div>


        <div class="footer-links">

            <a href="index.php">
                Home
            </a>

            <?php if ($canViewContent): ?>

                <a href="#about">
                    About
                </a>

                <a href="#works">
                    Our Works
                </a>

            <?php endif; ?>

            <a href="login.php">
                Login
            </a>

        </div>

    </div>


    <div class="copyright">

        © 2026 MCA42. All Rights Reserved.

    </div>

</footer>


</body>

</html>