<?php

include "db.php";

include "auth.php";

$search = "";

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

if ($search != "") {

    $search_safe = mysqli_real_escape_string($conn, $search);

    $query = "SELECT * FROM contacts
              WHERE name LIKE '%$search_safe%'
              OR email LIKE '%$search_safe%'
              OR phone LIKE '%$search_safe%'
              ORDER BY id DESC";

} else {

    $query = "SELECT * FROM contacts ORDER BY id DESC";
}

$result = mysqli_query($conn, $query);

$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM contacts");
$total_data = mysqli_fetch_assoc($total_result);
$total_contacts = $total_data['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contactly | Dashboard</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<!-- =========================
     TOP NAVIGATION
========================= -->

<nav class="topbar">

    <a href="index.php" class="brand">

        <span class="brand-mark">◉</span>

        Contactly

    </a>


    <div class="nav-right">

        <a href="index.php" class="nav-link">
            Dashboard
        </a>

        <a href="#contacts" class="nav-link">
            Contacts
        </a>


        <div class="user-menu">

            <div class="user-avatar">
                A
            </div>

            <div class="user-info">

                <strong>Admin</strong>

                <span>Administrator</span>

            </div>

            <a href="logout.php" class="logout">
                Logout
            </a>

        </div>

    </div>

</nav>


<!-- =========================
     DASHBOARD
========================= -->

<main class="dashboard">


    <section class="hero">

        <div>

            <div class="hero-label">
                CONTACT MANAGEMENT
            </div>

            <h1>
                Good to see you, Admin.
            </h1>

            <p>
                Keep your contacts organized and within reach.
            </p>

        </div>


        <a href="add.php" class="primary-btn">
            + Add New Contact
        </a>

    </section>


    <!-- =========================
         STATISTICS
    ========================= -->

    <section class="stats">

        <div class="stat-card">

            <div class="stat-content">

                <span>Total Contacts</span>

                <strong>
                    <?php echo $total_contacts; ?>
                </strong>

            </div>

            <div class="stat-icon">
                ♟
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-content">

                <span>Contact List</span>

                <strong>
                    <?php echo $total_contacts > 0 ? "Active" : "Empty"; ?>
                </strong>

            </div>

            <div class="stat-icon">
                ✓
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-content">

                <span>Management</span>

                <strong>
                    CRUD
                </strong>

            </div>

            <div class="stat-icon">
                +
            </div>

        </div>

    </section>


    <!-- =========================
         CONTACTS
    ========================= -->

    <section class="contacts-section" id="contacts">


        <div class="section-header">

            <div>

                <h2>
                    Your Contacts
                </h2>

                <p>
                    View and manage everyone in your contact list.
                </p>

            </div>


            <a href="add.php" class="primary-btn">
                Add Contact
            </a>

        </div>


        <div class="search-wrapper">

            <form method="GET" class="search-box">

                <span class="search-icon">
                    ⌕
                </span>

                <input
                    type="text"
                    name="search"
                    placeholder="Search by name, email or phone..."
                    value="<?php echo htmlspecialchars($search); ?>"
                >

                <?php if ($search != ""): ?>

                    <a href="index.php" class="clear">
                        Clear
                    </a>

                <?php endif; ?>

            </form>

        </div>


        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>Contact</th>

                        <th>Email</th>

                        <th>Phone</th>

                        <th>Address</th>

                        <th>Actions</th>

                    </tr>

                </thead>


                <tbody>

                <?php if (mysqli_num_rows($result) > 0): ?>

                    <?php while ($row = mysqli_fetch_assoc($result)): ?>

                        <tr>

                            <td>

                                <div class="contact">

                                    <div class="avatar">

                                        <?php
                                        echo strtoupper(
                                            substr($row['name'], 0, 1)
                                        );
                                        ?>

                                    </div>


                                    <div>

                                        <strong>
                                            <?php
                                            echo htmlspecialchars(
                                                $row['name']
                                            );
                                            ?>
                                        </strong>

                                        <small>
                                            Contact #<?php echo $row['id']; ?>
                                        </small>

                                    </div>

                                </div>

                            </td>


                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $row['email']
                                );
                                ?>
                            </td>


                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $row['phone']
                                );
                                ?>
                            </td>


                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $row['address']
                                );
                                ?>
                            </td>


                            <td>

                                <div class="actions">

                                    <a
                                        href="edit.php?id=<?php echo $row['id']; ?>"
                                        class="edit"
                                    >
                                        Edit
                                    </a>

                                    <a
                                        href="delete.php?id=<?php echo $row['id']; ?>"
                                        class="delete"
                                        onclick="return confirmDelete()"
                                    >
                                        Delete
                                    </a>

                                </div>

                            </td>

                        </tr>

                    <?php endwhile; ?>


                <?php else: ?>

                    <tr>

                        <td colspan="5">

                            <div class="empty">

                                <div class="empty-icon">
                                    +
                                </div>

                                <h3>
                                    Your contact list is empty
                                </h3>

                                <p>
                                    Add your first contact to get started.
                                </p>

                            </div>

                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </section>


    <footer>

        Contactly · Contact Management System · PHP & MySQL

    </footer>

</main>


<script src="script.js"></script>

</body>

</html>