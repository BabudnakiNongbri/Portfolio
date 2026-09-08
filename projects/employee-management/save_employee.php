<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $employee_id = $_POST["employee_id"];
    $name = $_POST["name"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $department = $_POST["department"];
    $designation = $_POST["designation"];
    $salary = $_POST["salary"];
    $address = $_POST["address"];

    $sql = "INSERT INTO employees 
            (employee_id, name, gender, dob, email, phone, department, designation, salary, address)
            VALUES 
            ('$employee_id', '$name', '$gender', '$dob', '$email', '$phone', '$department', '$designation', '$salary', '$address')";

    if (mysqli_query($conn, $sql)) {

        echo "<h2>Employee details saved successfully!</h2>";
        echo "<a href='index.php'>Add Another Employee</a>";

    } else {

        echo "Error: " . mysqli_error($conn);

    }
}

?>