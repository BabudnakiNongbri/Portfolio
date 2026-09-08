<?php

include "db.php";

$sql = "SELECT * FROM employees ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee Records</title>

    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="container">

    <h1>Employee Records</h1>
    <p class="subtitle">All registered employees</p>

    <a href="index.php" class="add-button">+ Add Employee</a>

    <div class="table-container">

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Salary</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

                <?php

                if (mysqli_num_rows($result) > 0) {

                    while ($row = mysqli_fetch_assoc($result)) {

                ?>

                    <tr>

                        <td><?php echo $row['id']; ?></td>

                        <td><?php echo $row['employee_id']; ?></td>

                        <td><?php echo $row['name']; ?></td>

                        <td><?php echo $row['gender']; ?></td>

                        <td><?php echo $row['dob']; ?></td>

                        <td><?php echo $row['email']; ?></td>

                        <td><?php echo $row['phone']; ?></td>

                        <td><?php echo $row['department']; ?></td>

                        <td><?php echo $row['designation']; ?></td>

                        <td>₹<?php echo number_format($row['salary'], 2); ?></td>

                        <td><?php echo $row['address']; ?></td>

                        <td>
                          <a href="edit_employee.php?id=<?php echo $row['id']; ?>" class="edit-button">
        Edit
                             </a>
                        </td>

                    </tr>

                <?php

                    }

                } else {

                    echo "<tr>
                            <td colspan='11'>No employee records found.</td>
                          </tr>";

                }

                ?>

            </tbody>

        </table>

    </div>

</div>

</body>

</html>