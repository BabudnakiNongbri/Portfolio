<?php

include "db.php";
include "auth.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

$result = mysqli_query(
    $conn,
    "SELECT * FROM contacts WHERE id = $id"
);

$contact = mysqli_fetch_assoc($result);

if (!$contact) {
    header("Location: index.php");
    exit();
}


if (isset($_POST['update_contact'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE contacts
         SET name=?, email=?, phone=?, address=?
         WHERE id=?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssssi",
        $name,
        $email,
        $phone,
        $address,
        $id
    );

    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Contact</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="form-container">

    <a href="index.php" class="back">← Back to Contacts</a>

    <div class="form-card">

        <span class="tag">EDIT CONTACT</span>

        <h1>Update Contact</h1>

        <p class="form-description">
            Update the contact information below.
        </p>


        <form method="POST">

            <label>Full Name *</label>

            <input
                type="text"
                name="name"
                value="<?php echo htmlspecialchars($contact['name']); ?>"
                required
            >


            <label>Email Address *</label>

            <input
                type="email"
                name="email"
                value="<?php echo htmlspecialchars($contact['email']); ?>"
                required
            >


            <label>Phone Number *</label>

            <input
                type="text"
                name="phone"
                value="<?php echo htmlspecialchars($contact['phone']); ?>"
                required
            >


            <label>Address</label>

            <textarea
                name="address"
                rows="3"
            ><?php echo htmlspecialchars($contact['address']); ?></textarea>


            <div class="form-actions">

                <a href="index.php" class="cancel">
                    Cancel
                </a>

                <button type="submit" name="update_contact">
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>