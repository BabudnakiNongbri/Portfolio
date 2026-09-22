<?php

session_start();

include "db.php";


/* =========================
   CHECK LOGIN
========================= */

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}


$role = $_SESSION["role"];
$name = $_SESSION["name"];


/* =========================
   ADMIN APPROVE / REJECT
========================= */

if ($role === "admin" && isset($_GET["action"]) && isset($_GET["id"])) {

    $action = $_GET["action"];
    $userId = intval($_GET["id"]);


    if ($action === "approve") {

        $stmt = $conn->prepare(
            "UPDATE users
             SET content_access = 'approved'
             WHERE id = ? AND role = 'employee'"
        );

        $stmt->bind_param("i", $userId);

        $stmt->execute();

        $stmt->close();


    } elseif ($action === "reject") {

        $stmt = $conn->prepare(
            "UPDATE users
             SET content_access = 'rejected'
             WHERE id = ? AND role = 'employee'"
        );

        $stmt->bind_param("i", $userId);

        $stmt->execute();

        $stmt->close();
    }


    /*
       Remove the query parameters from the URL
       after performing the action.
    */

    header("Location: dashboard.php");
    exit();
}


/* =========================
   GET CURRENT EMPLOYEE STATUS
========================= */

$contentAccess = "";

if ($role === "employee") {

    $stmt = $conn->prepare(
        "SELECT content_access
         FROM users
         WHERE id = ?"
    );

    $stmt->bind_param(
        "i",
        $_SESSION["user_id"]
    );

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        $contentAccess = $user["content_access"];

        /*
           Update the session as well.
        */

        $_SESSION["content_access"] = $contentAccess;
    }

    $stmt->close();
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
        Dashboard | MCA42
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


    <div class="user-nav">

        <span>
            Welcome,
            <?php echo htmlspecialchars($name); ?>
        </span>


        <a
            href="index.php"
            class="login-btn"
        >
            Home
        </a>


        <a
            href="logout.php"
            class="register-btn"
        >
            Logout
        </a>

    </div>

</header>


<!-- =========================
     DASHBOARD
========================= -->

<main class="dashboard">


<?php if ($role === "admin"): ?>


    <!-- =========================
         ADMIN DASHBOARD
    ========================= -->

    <div class="dashboard-header">

        <div>

            <p class="dashboard-label">
                ADMIN PORTAL
            </p>

            <h1>
                Employee Management
            </h1>

            <p>
                Manage employee accounts and control access
                to restricted MCA42 company information.
            </p>

        </div>


        <div class="role-badge">
            Administrator
        </div>

    </div>


    <section class="data-section">

        <h2>
            Registered Employees
        </h2>

        <p class="section-description">

            Review employee registrations and approve
            or reject access to restricted company content.

        </p>


        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Name
                        </th>

                        <th>
                            Email
                        </th>

                        <th>
                            Department
                        </th>

                        <th>
                            Phone
                        </th>

                        <th>
                            Access
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>


                <?php

                $employees = $conn->query(
                    "SELECT
                        id,
                        name,
                        email,
                        department,
                        phone,
                        content_access
                     FROM users
                     WHERE role = 'employee'
                     ORDER BY id DESC"
                );


                if ($employees->num_rows > 0):

                    while (
                        $employee =
                        $employees->fetch_assoc()
                    ):

                ?>


                    <tr>


                        <td>

                            <?php
                            echo $employee["id"];
                            ?>

                        </td>


                        <td>

                            <strong>

                                <?php
                                echo htmlspecialchars(
                                    $employee["name"]
                                );
                                ?>

                            </strong>

                        </td>


                        <td>

                            <?php
                            echo htmlspecialchars(
                                $employee["email"]
                            );
                            ?>

                        </td>


                        <td>

                            <?php
                            echo htmlspecialchars(
                                $employee["department"]
                            );
                            ?>

                        </td>


                        <td>

                            <?php
                            echo htmlspecialchars(
                                $employee["phone"]
                            );
                            ?>

                        </td>


                        <!-- STATUS -->

                        <td>

                            <?php

                            if (
                                $employee["content_access"]
                                === "approved"
                            ):

                            ?>

                                <span class="status approved">
                                    Approved
                                </span>


                            <?php

                            elseif (
                                $employee["content_access"]
                                === "rejected"
                            ):

                            ?>

                                <span class="status rejected">
                                    Rejected
                                </span>


                            <?php else: ?>

                                <span class="status pending">
                                    Pending
                                </span>

                            <?php endif; ?>

                        </td>


                        <!-- ACTION -->

                        <td class="action-buttons">


                            <?php

                            if (
                                $employee["content_access"]
                                !== "approved"
                            ):

                            ?>

                                <a
                                    href="dashboard.php?action=approve&id=<?php echo $employee["id"]; ?>"
                                    class="approve-btn"
                                    onclick="return confirm('Approve this employee?');"
                                >
                                    Approve
                                </a>

                            <?php endif; ?>


                            <?php

                            if (
                                $employee["content_access"]
                                !== "rejected"
                            ):

                            ?>

                                <a
                                    href="dashboard.php?action=reject&id=<?php echo $employee["id"]; ?>"
                                    class="reject-btn"
                                    onclick="return confirm('Reject access for this employee?');"
                                >
                                    Reject
                                </a>

                            <?php endif; ?>


                        </td>

                    </tr>


                <?php

                    endwhile;

                else:

                ?>


                    <tr>

                        <td
                            colspan="7"
                            class="empty-table"
                        >

                            No employees have registered yet.

                        </td>

                    </tr>


                <?php endif; ?>


                </tbody>

            </table>

        </div>

    </section>


<?php else: ?>


    <!-- =========================
         EMPLOYEE DASHBOARD
    ========================= -->


    <div class="dashboard-header">

        <div>

            <p class="dashboard-label">
                EMPLOYEE PORTAL
            </p>

            <h1>

                Welcome,
                <?php
                echo htmlspecialchars($name);
                ?>

            </h1>

            <p>
                Your MCA42 employee account.
            </p>

        </div>


        <div class="role-badge">
            Employee
        </div>

    </div>


    <?php if ($contentAccess === "approved"): ?>


        <!-- =========================
             APPROVED EMPLOYEE
        ========================= -->


        <div class="access-approved">

            <div class="access-icon">
                ✓
            </div>

            <div>

                <h2>
                    Access Approved
                </h2>

                <p>
                    Your administrator has approved your
                    access to restricted MCA42 information.
                </p>

            </div>

        </div>


        <!-- ADMIN DETAILS -->

        <section class="data-section">

            <h2>
                Administrator Details
            </h2>

            <p class="section-description">
                MCA42 administration team.
            </p>


            <div class="admin-grid">


            <?php

            $admins = $conn->query(
                "SELECT
                    name,
                    email,
                    department,
                    phone
                 FROM users
                 WHERE role = 'admin'
                 ORDER BY name"
            );


            if ($admins->num_rows > 0):

                while (
                    $admin =
                    $admins->fetch_assoc()
                ):

            ?>


                <div class="admin-card">


                    <div class="admin-avatar">

                        <?php

                        echo strtoupper(
                            substr(
                                $admin["name"],
                                0,
                                1
                            )
                        );

                        ?>

                    </div>


                    <h3>

                        <?php

                        echo htmlspecialchars(
                            $admin["name"]
                        );

                        ?>

                    </h3>


                    <span class="admin-role">
                        Administrator
                    </span>


                    <div class="admin-info">

                        <p>

                            📧

                            <?php

                            echo htmlspecialchars(
                                $admin["email"]
                            );

                            ?>

                        </p>


                        <p>

                            🏢

                            <?php

                            echo htmlspecialchars(
                                $admin["department"]
                            );

                            ?>

                        </p>


                        <p>

                            📞

                            <?php

                            echo htmlspecialchars(
                                $admin["phone"]
                            );

                            ?>

                        </p>

                    </div>

                </div>


            <?php

                endwhile;

            endif;

            ?>


            </div>

        </section>


        <!-- COMPANY CONTENT -->

        <section class="restricted-dashboard-content">

            <div class="content-title">

                <p>
                    RESTRICTED MCA42 CONTENT
                </p>

                <h2>
                    Welcome to the MCA42 Community
                </h2>

            </div>


            <div class="content-cards">


                <div class="content-card">

                    <div>
                        💻
                    </div>

                    <h3>
                        Our Projects
                    </h3>

                    <p>
                        Explore the technology projects
                        and solutions developed by MCA42.
                    </p>

                </div>


                <div class="content-card">

                    <div>
                        🚀
                    </div>

                    <h3>
                        Our Vision
                    </h3>

                    <p>
                        MCA42 aims to create innovative
                        technology that solves real-world
                        problems.
                    </p>

                </div>


                <div class="content-card">

                    <div>
                        🤝
                    </div>

                    <h3>
                        Our Community
                    </h3>

                    <p>
                        We believe collaboration and
                        knowledge sharing are essential
                        for innovation.
                    </p>

                </div>


            </div>

        </section>


    <?php elseif ($contentAccess === "rejected"): ?>


        <!-- =========================
             REJECTED
        ========================= -->


        <div class="access-rejected">

            <div class="access-icon">
                !
            </div>

            <h2>
                Access Not Approved
            </h2>

            <p>
                Your request to access restricted
                MCA42 company information has been rejected.
            </p>

            <p>
                Please contact an administrator if you
                believe this was done in error.
            </p>

        </div>


    <?php else: ?>


        <!-- =========================
             PENDING
        ========================= -->


        <div class="access-pending">

            <div class="access-icon">
                ⏳
            </div>

            <h2>
                Approval Pending
            </h2>

            <p>
                Your employee account has been created
                successfully.
            </p>

            <p>
                An MCA42 administrator must approve your
                account before you can access restricted
                company information.
            </p>

            <div class="pending-status">
                Waiting for administrator approval
            </div>

        </div>


    <?php endif; ?>


<?php endif; ?>


</main>


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