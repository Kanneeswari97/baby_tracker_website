<?php
include("db.php");

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    die("Email and Password are required.");
}

$sql = "SELECT id, password_hash FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id, $password_hash);

if (mysqli_stmt_fetch($stmt)) {
    if (password_verify($password, $password_hash)) {
        session_start();
        $_SESSION['user_id'] = $id;
        header("Location: ../dashboard.html");
        exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "User not found.";
}

mysqli_stmt_close($stmt);
?>