<?php
include("db.php");

session_start();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    header("Location: ../login.html?error=empty");
    exit();
}

$sql = "SELECT id, password_hash FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id, $password_hash);

if (mysqli_stmt_fetch($stmt)) {
    if (password_verify($password, $password_hash)) {
        $_SESSION['user_id'] = $id;
        header("Location: ../dashboard.html");
        exit();
    } else {
        header("Location: ../login.html?error=wrongpassword");
        exit();
    }
} else {
    header("Location: ../login.html?error=nouser");
    exit();
}

mysqli_stmt_close($stmt);
?>