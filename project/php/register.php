<?php

include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname         = trim($_POST['fullname']);
    $email            = trim($_POST['email']);
    $phone            = trim($_POST['phone']);
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Password Match Check
    if ($password != $confirm_password) {
        echo "<script>
                alert('Password does not match!');
                window.location.href='../register.html';
              </script>";
        exit();
    }

    // Password Hash
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepared Statement — SQL Injection থেকে সুরক্ষিত
    $stmt = mysqli_prepare($conn, "INSERT INTO users (fullname, email, phone, password) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $fullname, $email, $phone, $hashed_password);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "<script>
                alert('Registration Successful!');
                window.location.href='../login.html';
              </script>";
    } else {
        echo "<script>
                alert('Registration Failed! Email may already exist.');
                window.location.href='../register.html';
              </script>";
    }

    mysqli_stmt_close($stmt);
}

?>