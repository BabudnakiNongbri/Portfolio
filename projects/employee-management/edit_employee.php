<?php

include "db.php";

if (!isset($_GET['id'])) {
    die("Employee ID not provided.");
}

$id = $_GET['id'];

$sql = "SELECT * FROM employees WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$employee = mysqli_fetch_assoc($result);

if (!$employee) {
    die("Employee not found.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Employee</title>

    <link rel="stylesheet" href="assets/style.css">

</head>

<body>

<div class="container">

    <h1>Edit Employee</h1>
    <p class="subtitle">Update employee information</p>

    <form action="update_employee.php" method="POST">

        <input type="hidden" name="id" value="<?php echo $employee['id']; ?>">

        <div class="form-row">

            <div class="form-group">
                <label>Employee ID</label>

                <input
                    type="text"
                    name="employee_id"
                    value="<?php echo htmlspecialchars($employee['employee_id']); ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label>Employee Name</label>

                <input
                    type="text"
                    name="name"
                    value="<?php echo htmlspecialchars($employee['name']); ?>"
                    required
                >
            </div>

        </div>


        <div class="form-row">

            <div class="form-group">

                <label>Gender</label>

                <select name="gender" required>

                    <option value="">Select Gender</option>

                    <option value="Male"
                        <?php if ($employee['gender'] == 'Male') echo 'selected'; ?>>
                        Male
                    </option>

                    <option value="Female"
                        <?php if ($employee['gender'] == 'Female') echo 'selected'; ?>>
                        Female
                    </option>

                    <option value="Other"
                        <?php if ($employee['gender'] == 'Other') echo 'selected'; ?>>
                        Other
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>Date of Birth</label>

                <input
                    type="date"
                    name="dob"
                    value="<?php echo $employee['dob']; ?>"
                    required
                >

            </div>

        </div>


        <div class="form-row">

            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    value="<?php echo htmlspecialchars($employee['email']); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>Phone Number</label>

                <input
                    type="tel"
                    name="phone"
                    value="<?php echo htmlspecialchars($employee['phone']); ?>"
                    required
                >

            </div>

        </div>


        <div class="form-row">

            <div class="form-group">

                <label>Department</label>

                <select name="department" required>

                    <option value="">Select Department</option>

                    <option value="IT"
                        <?php if ($employee['department'] == 'IT') echo 'selected'; ?>>
                        IT
                    </option>

                    <option value="HR"
                        <?php if ($employee['department'] == 'HR') echo 'selected'; ?>>
                        Human Resources
                    </option>

                    <option value="Finance"
                        <?php if ($employee['department'] == 'Finance') echo 'selected'; ?>>
                        Finance
                    </option>

                    <option value="Marketing"
                        <?php if ($employee['department'] == 'Marketing') echo 'selected'; ?>>
                        Marketing
                    </option>

                    <option value="Sales"
                        <?php if ($employee['department'] == 'Sales') echo 'selected'; ?>>
                        Sales
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>Designation</label>

                <input
                    type="text"
                    name="designation"
                    value="<?php echo htmlspecialchars($employee['designation']); ?>"
                    required
                >

            </div>

        </div>


        <div class="form-row">

            <div class="form-group">

                <label>Salary</label>

                <input
                    type="number"
                    name="salary"
                    value="<?php echo $employee['salary']; ?>"
                    step="0.01"
                    required
                >

            </div>


            <div class="form-group">

                <label>Address</label>

                <textarea
                    name="address"
                    required
                ><?php echo htmlspecialchars($employee['address']); ?></textarea>

            </div>

        </div>


        <button type="submit">Update Employee</button>

        <a href="view_employees.php" class="cancel-button">
            Cancel
        </a>

    </form>

</div>

</body>

</html>