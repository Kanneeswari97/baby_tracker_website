<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$today = date("Y-m-d");

//  TODAY RECORDS
$result = mysqli_query($conn, "SELECT * FROM feeding_tracker 
WHERE user_id='$user_id' AND date='$today' ORDER BY time DESC");

//  TOTAL + COUNT
$total = 0;
$count = 0;

$rows = [];

while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;

    $qty = (int) filter_var($row['quantity'], FILTER_SANITIZE_NUMBER_INT);
    $total += $qty;
    $count++;
}

//  STATUS
if ($total < 500) {
    $status = "Low Feeding 😟";
} elseif ($total <= 900) {
    $status = "Normal Feeding 😊";
} else {
    $status = "Over Feeding ⚠️";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Feeding Records</title>
<link rel="stylesheet" href="../css/feeding.css">
</head>

<body>

<!-- 🔝 TOP -->
<div class="top-buttons">
    <a href="../dashboard.html" class="dash-btn">← Back to Dashboard</a>
</div>

<h2>🍼 Baby Feeding Tracker</h2>

<!-- 🔥 COMBINED BOX -->
<div class="data-box">

    <!-- 📊 SUMMARY -->
    <h3>📊 Today's Summary</h3>

    <div class="summary-box">
        <p><b>Total Feeding:</b> <?php echo $total; ?> ml</p>
        <p><b>Feeding Times:</b> <?php echo $count; ?></p>
        <p><b>Status:</b> <?php echo $status; ?></p>
    </div>

    <!-- 📋 TABLE -->
    <h3>📋 Feeding Records</h3>

    <table>
        <tr>
            <th>Time</th>
            <th>Food</th>
            <th>Quantity</th>
            <th>Notes</th>
        </tr>

        <?php foreach ($rows as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['time']) ?></td>
            <td><?= htmlspecialchars($row['food']) ?></td>
            <td><?= htmlspecialchars($row['quantity']) ?></td>
            <td><?= htmlspecialchars($row['notes']) ?></td>
        </tr>
        <?php endforeach; ?>

    </table>

</div>

<!-- 🔘 BUTTONS -->
<div class="bottom-buttons">
    <a href="../feeding.html" class="btn">➕ Add New</a>
    <a href="../dashboard.html" class="btn back">🏠 Dashboard</a>
</div>

</body>
</html>