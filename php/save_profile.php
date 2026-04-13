<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$name = $_POST['name'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$weight = $_POST['weight'];
$height = $_POST['height'];
$blood = $_POST['blood'];
$parent = $_POST['parent'];

// IMAGE UPLOAD
$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];
move_uploaded_file($tmp, "../uploads/" . $image);

// INSERT
mysqli_query($conn, "INSERT INTO baby_profile 
(user_id, baby_name, dob, gender, weight, height, blood_group, parent_name, image) 
VALUES 
('$user_id','$name','$dob','$gender','$weight','$height','$blood','$parent','$image')");

//  AFTER SAVE → VIEW PAGE
header("Location: view_profile.php");
exit();
?>