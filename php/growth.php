<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

//  SAVE
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dob = $_POST['dob'];
    $date = $_POST['date'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];

    $stmt = mysqli_prepare($conn, "INSERT INTO growth_tracker (user_id, dob, date, weight, height) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "issss", $user_id, $dob, $date, $weight, $height);
    mysqli_stmt_execute($stmt);

    header("Location: growth.php");
    exit();
}

//  FETCH
$res = mysqli_query($conn, "SELECT * FROM growth_tracker WHERE user_id='$user_id' ORDER BY date DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Growth Analysis</title>
<link rel="stylesheet" href="../css/growth.css">
</head>

<body>

<div class="top-buttons">
    <a href="../dashboard.html" class="dash-btn">← Back to Dashboard</a>
</div>

<h2>Growth Analysis</h2>

<table>
<tr>
<th>DOB</th>
<th>Date</th>
<th>Age</th>
<th>Weight</th>
<th>Height</th>
<th>Status</th>
<th>Suggestion</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($res)):

$dob = $row['dob'];
$date = $row['date'];
$weight = $row['weight'];
$height = $row['height'];

//  AGE CALCULATION
$d1 = new DateTime($dob);
$d2 = new DateTime($date);
$diff = $d1->diff($d2);
$age = ($diff->y * 12) + $diff->m;

// BMI
$h = $height / 100;
$bmi = $weight / ($h * $h);

//  ANALYSIS
if ($bmi < 14) {
    $status = "Underweight 😟";
    $suggestion = "Increase feeding";
} elseif ($bmi <= 18) {
    $status = "Normal 😊";
    $suggestion = "Good growth";
} else {
    $status = "Overweight ⚠️";
    $suggestion = "Control diet";
}
?>

<tr>
<td><?php echo $dob; ?></td>
<td><?php echo $date; ?></td>
<td><?php echo $age; ?> months</td>
<td><?php echo $weight; ?> kg</td>
<td><?php echo $height; ?> cm</td>
<td><?php echo $status; ?></td>
<td><?php echo $suggestion; ?></td>
</tr>

<?php endwhile; ?>

</table>

</body>
</html>