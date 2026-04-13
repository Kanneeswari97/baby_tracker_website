<?php
session_start();
include("db.php");

$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn, "SELECT * FROM vaccination WHERE user_id='$user_id'");
?>

<!DOCTYPE html>
<html>
<head>
<title>View Vaccination</title>
<link rel="stylesheet" href="css/vaccination.css">
</head>

<body>

<div class="container">
<h2> Vaccination List</h2>

<table border="1" width="100%">
<tr>
    <th>Vaccine</th>
    <th>Due Date</th>
    <th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['vaccine_name']; ?></td>
    <td><?php echo $row['due_date']; ?></td>
    <td><?php echo $row['status']; ?></td>
</tr>
<?php } ?>

</table>

<br>
<a href="../dashboard.html">⬅ Back</a>
</div>

</body>
</html>