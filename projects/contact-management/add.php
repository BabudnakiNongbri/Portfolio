<?php

include "db.php";
include "auth.php";

$message = "";

if (isset($_POST['add_contact'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if ($name == "" || $email == "" || $phone == "") {

        $message = "Please fill in all required fields.";

    } else {

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO contacts (name, email, phone, address)
             VALUES (?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssss",
            $name,
            $email,
            $phone,
            $address
        );

        mysqli_stmt_execute($stmt);

        header("Location: index.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Contact</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="form-container">

    <a href="index.php" class="back">← Back to Contacts</a>

    <div class="form-card">

        <span class="tag">NEW CONTACT</span>

        <h1>Add Contact</h1>

        <p class="form-description">
            Add a new person to your contact list.
        </p>

        <?php if ($message != ""): ?>

            <div class="error">
                <?php echo $message; ?>
            </div>

        <?php endif; ?>


        <form method="POST">

            <label>Full Name *</label>

            <input
                type="text"
                name="name"
                placeholder="Enter full name"
                required
            >


            <label>Email Address *</label>

            <input
                type="email"
                name="email"
                placeholder="name@example.com"
                required
            >


            <label>Phone Number *</label>

            <input
                type="text"
                name="phone"
                placeholder="Enter phone number"
                required
            >


            <label>Address</label>

            <textarea
                name="address"
                placeholder="Enter address"
                rows="3"
            ></textarea>


            <div class="form-actions">

                <a href="index.php" class="cancel">
                    Cancel
                </a>

                <button type="submit" name="add_contact">
                    Add Contact
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>