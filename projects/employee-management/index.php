<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>

    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <div class="container">

        <h1>Employee Details</h1>
        <p class="subtitle">Enter employee information</p>

        <form action="save_employee.php" method="POST">

            <div class="form-row">

                <div class="form-group">
                    <label>Employee ID</label>
                    <input type="text" name="employee_id" placeholder="Enter employee ID" required>
                </div>

                <div class="form-group">
                    <label>Employee Name</label>
                    <input type="text" name="name" placeholder="Enter employee name" required>
                </div>

            </div>


            <div class="form-row">

                <div class="form-group">
                    <label>Gender</label>

                    <select name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" required>
                </div>

            </div>


            <div class="form-row">

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter email address" required>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" placeholder="Enter phone number" required>
                </div>

            </div>


            <div class="form-row">

                <div class="form-group">
                    <label>Department</label>

                    <select name="department" required>
                        <option value="">Select Department</option>
                        <option value="IT">IT</option>
                        <option value="HR">Human Resources</option>
                        <option value="Finance">Finance</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Sales">Sales</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Designation</label>
                    <input type="text" name="designation" placeholder="Enter designation" required>
                </div>

            </div>


            <div class="form-row">

                <div class="form-group">
                    <label>Salary</label>
                    <input type="number" name="salary" placeholder="Enter salary" step="0.01" required>
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" placeholder="Enter employee address" required></textarea>
                </div>

            </div>


            <button type="submit">Save Employee</button>

        </form>

    </div>

</body>
</html>