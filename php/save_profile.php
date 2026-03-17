<?php
// php/save_profile.php
include("db.php");

$name   = $_POST['name'] ?? '';
$dob    = $_POST['dob'] ?? null;
$gender = $_POST['gender'] ?? '';
$weight = $_POST['weight'] ?? '';
$height = $_POST['height'] ?? '';
$blood  = $_POST['blood'] ?? '';
$parent = $_POST['parent'] ?? '';

$image_name = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $tmp = $_FILES['image']['tmp_name'];
    $orig = basename($_FILES['image']['name']);
    $ext = pathinfo($orig, PATHINFO_EXTENSION);
    // sanitize extension & name
    $allowed = ['jpg','jpeg','png','gif','webp','jfif'];
    if (!in_array(strtolower($ext), $allowed)) {
        die("Invalid file type.");
    }
    // generate unique filename
    $image_name = time() . '_' . bin2hex(random_bytes(5)) . '.' . $ext;
    $dest = __DIR__ . '/../uploads/' . $image_name;
    if (!move_uploaded_file($tmp, $dest)) {
        die("Failed to move uploaded file. Make sure /uploads is writable.");
    }
}

// prepared statement
$stmt = mysqli_prepare($conn, "INSERT INTO baby_profile (baby_name, dob, gender, weight, height, blood_group, parent_name, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sssssiss", $name, $dob, $gender, $weight, $height, $blood, $parent, $image_name);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: ../dashboard.html");
exit();
?>