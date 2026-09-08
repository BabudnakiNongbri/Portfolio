<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["id"];
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

    $sql = "UPDATE employees SET
            employee_id = ?,
            name = ?,
            gender = ?,
            dob = ?,
            email = ?,
            phone = ?,
            department = ?,
            designation = ?,
            salary = ?,
            address = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssssddi",
        $employee_id,
        $name,
        $gender,
        $dob,
        $email,
        $phone,
        $department,
        $designation,
        $salary,
        $address,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {

        header("Location: view_employees.php");
        exit();

    } else {

        echo "Error updating employee: " . mysqli_error($conn);

    }
}

?>