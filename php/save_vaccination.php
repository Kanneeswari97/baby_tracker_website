<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$vaccine = $_POST['vaccine'];
$due_date = $_POST['due_date'];
$status = "Pending";

$stmt = mysqli_prepare($conn, "INSERT INTO vaccination (user_id, vaccine_name, due_date, status) VALUES (?, ?, ?, ?)");

mysqli_stmt_bind_param($stmt, "isss", $user_id, $vaccine, $due_date, $status);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>
    alert('Vaccine Added Successfully');
     window.location.href='view_vaccination.php';
     </script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>