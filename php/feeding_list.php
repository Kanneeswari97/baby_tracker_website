<?php
// php/feeding_list.php
include("db.php");

$result = mysqli_query($conn, "SELECT * FROM feeding_tracker ORDER BY id DESC");
?>
<!doctype html>
<html>
<head><title>Feeding Records</title></head>
<body>
<h2>Feeding Records</h2>
<table border="1" cellpadding="6">
<tr><th>Time</th><th>Food</th><th>Quantity</th><th>Notes</th></tr>
<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
<td><?=htmlspecialchars($row['time'])?></td>
<td><?=htmlspecialchars($row['food'])?></td>
<td><?=htmlspecialchars($row['quantity'])?></td>
<td><?=htmlspecialchars($row['notes'])?></td>
</tr>
<?php endwhile; ?>
</table>
<p><a href="../feeding.html">Back to add</a></p>
</body>
</html>