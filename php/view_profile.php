<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$res = mysqli_query($conn, "SELECT * FROM baby_profile WHERE user_id='$user_id'");
$data = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html>
<head>
<title>Baby Profile</title>
<link rel="stylesheet" href="../css/profile.css">
</head>

<body>

<div class="top-buttons">
    <a href="../dashboard.html" class="dash-btn">← Back to Dashboard</a>
</div>

<h2>Baby Profile</h2>

<?php if ($data): ?>

<div class="profile-box">

<div class="img-box">
<img src="../uploads/<?php echo $data['image']; ?>">
</div>

<p><b>Name:</b> <?php echo $data['baby_name']; ?></p>
<p><b>DOB:</b> <?php echo $data['dob']; ?></p>
<p><b>Gender:</b> <?php echo $data['gender']; ?></p>
<p><b>Weight:</b> <?php echo $data['weight']; ?></p>
<p><b>Height:</b> <?php echo $data['height']; ?></p>
<p><b>Blood:</b> <?php echo $data['blood_group']; ?></p>
<p><b>Parent:</b> <?php echo $data['parent_name']; ?></p>

</div>

<?php else: ?>

<p>No profile found</p>
<a href="../profile.html">Create Profile</a>

<?php endif; ?>

</body>
</html>