<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'] ?? '';
    $weight = $_POST['weight'] ?? '';
    $height = $_POST['height'] ?? '';

    if (!empty($date) && !empty($weight) && !empty($height)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO growth_tracker (date, weight, height) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $date, $weight, $height);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    header("Location: growth.php");
    exit();
}

$res = mysqli_query($conn, "SELECT * FROM growth_tracker ORDER BY date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Growth Tracker</title>
    <link rel="stylesheet" href="../css/growth.css">
</head>
<body>

    <div class="top-buttons">
        <a href="../dashboard.html" class="dash-btn">← Back to Dashboard</a>
    </div>

    <h2>Baby Growth Tracker</h2>

    <form action="" method="POST">
        <input type="date" name="date" required>
        <input type="text" name="weight" placeholder="Weight (kg)" required>
        <input type="text" name="height" placeholder="Height (cm)" required>
        <button type="submit">Add Record</button>
    </form>

    <table>
        <tr>
            <th>Date</th>
            <th>Weight</th>
            <th>Height</th>
        </tr>

        <?php while ($r = mysqli_fetch_assoc($res)) : ?>
        <tr>
            <td><?php echo htmlspecialchars($r['date']); ?></td>
            <td><?php echo htmlspecialchars($r['weight']); ?></td>
            <td><?php echo htmlspecialchars($r['height']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>