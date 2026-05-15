<?php
// php/login.php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        echo "<script>alert('Please fill all fields!'); window.location.href='../login.html';</script>";
        exit();
    }

    $stmt = mysqli_prepare($conn, "SELECT id, fullname, password FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['user_id']   = $row['id'];
        $_SESSION['user_name'] = $row['fullname'];
        echo "<script>window.location.href='../index.html';</script>";
    } else {
        echo "<script>alert('Wrong email or password!'); window.location.href='../login.html';</script>";
    }
}
?>