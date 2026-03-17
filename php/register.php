<?php
include("db.php");

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($name) || empty($email) || empty($password)) {
    die("All fields are required.");
}

$check_sql = "SELECT id FROM users WHERE email = ?";
$check_stmt = mysqli_prepare($conn, $check_sql);

if (!$check_stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($check_stmt, "s", $email);
mysqli_stmt_execute($check_stmt);
mysqli_stmt_store_result($check_stmt);

if (mysqli_stmt_num_rows($check_stmt) > 0) {
    mysqli_stmt_close($check_stmt);
    die("Email already registered.");
}

mysqli_stmt_close($check_stmt);

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password_hash);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header("Location: ../login.html");
    exit();
} else {
    echo "Registration failed.";
}

mysqli_stmt_close($stmt);
?>