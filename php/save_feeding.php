<?php
// php/save_feeding.php
include("db.php");

$time = $_POST['time'] ?? null;
$food = $_POST['food'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$notes = $_POST['notes'] ?? '';

$stmt = mysqli_prepare($conn, "INSERT INTO feeding_tracker (time, food, quantity, notes) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $time, $food, $quantity, $notes);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: ../php/feeding_list.php");
exit();
?>