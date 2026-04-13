<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$today = date("Y-m-d");

$result = mysqli_query($conn, "SELECT * FROM vaccination_tracker WHERE user_id='$user_id' ORDER BY due_date ASC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Vaccination Records</title>
<link rel="stylesheet" href="../css/vaccination.css">
</head>

<body>

<div class="top-buttons">
    <a href="../dashboard.html" class="dash-btn">← Back to Dashboard</a>
</div>

<h2> Vaccination Schedule</h2>

<div class="data-box">

<table>
<tr>
<th>Vaccine</th>
<th>Due Date</th>
<th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)): 

$due = $row['due_date'];

//  STATUS CHECK
if ($row['status'] == "Done") {
    $status = " Done";
} elseif ($due < $today) {
    $status = " Missed";
} else {
    $status = " Upcoming";
}
?>

<tr>
<td><?php echo $row['vaccine_name']; ?></td>
<td><?php echo $due; ?></td>
<td><?php echo $status; ?></td>
</tr>

<?php endwhile; ?>

</table>

</div>

<div class="bottom-buttons">
    <a href="../vaccination.html" class="btn"> Add Vaccine</a>
</div>

</body>
</html>