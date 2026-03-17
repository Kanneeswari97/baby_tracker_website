<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vaccine = $_POST['vaccine'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO vaccination_tracker (vaccine, due_date, status) 
            VALUES ('$vaccine', '$date', '$status')";
    mysqli_query($conn, $sql);
}

$result = mysqli_query($conn, "SELECT * FROM vaccination_tracker ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vaccination Tracker</title>
    <link rel="stylesheet" href="css/vaccination.css">
</head>
<body>

<h2>Baby Vaccination Tracker</h2>



<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>Vaccine</th>
        <th>Due Date</th>
        <th>Status</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['vaccine']; ?></td>
        <td><?php echo $row['due_date']; ?></td>
        <td><?php echo $row['status']; ?></td>
    </tr>
    <?php } ?>

</table>

</body>
</html>