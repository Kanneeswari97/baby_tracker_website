<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$time = $_POST['time'];
$food = $_POST['food'];
$quantity = $_POST['quantity'];
$notes = $_POST['notes'];

//  CURRENT DATE
$date = date("Y-m-d");

$stmt = mysqli_prepare($conn, "INSERT INTO feeding_tracker (user_id, date, time, food, quantity, notes) VALUES (?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "isssss", $user_id, $date, $time, $food, $quantity, $notes);
mysqli_stmt_execute($stmt);

header("Location: feeding_list.php");
exit();
?>