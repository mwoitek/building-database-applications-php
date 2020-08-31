<?php
// Check if there's someone logged:
session_start();
if (isset($_SESSION['name'])) {
    // Someone logged, then run a SQL query to get the list of automobiles:
    require_once 'pdo.php';
    $stmt = $pdo->query('SELECT * FROM autos');
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once 'bootstrap.php'; ?>
<title>Marcio Woitek Junior | Autos Database</title>
</head>
<body>
<div class='container'>
<h1>Welcome to the Automobiles Database</h1>
<?php
// If necessary, print a flash message:
// Error message:
if (isset($_SESSION['error'])) {
    echo '<p style="color: red;">';
    echo $_SESSION['error'];
    echo "</p>\n";
    unset($_SESSION['error']);
}
// Success message:
if (isset($_SESSION['success'])) {
    echo '<p style="color: green;">';
    echo $_SESSION['success'];
    echo "</p>\n";
    unset($_SESSION['success']);
}
?>
<?php
// Not logged in:
if (!isset($_SESSION['name'])) {
    echo '<p><a href="login.php">Please log in</a></p>' . "\n";
    echo '<p>Attempt to go to <a href="add.php">add.php</a> without logging in.' . "\n";
    echo 'It should fail with an error message.</p>' . "\n";
    echo '<p>Attempt to go to <a href="edit.php">edit.php</a> without logging in.' . "\n";
    echo 'It should fail with an error message.</p>' . "\n";

// Logged in:
// Print the list of automobiles (if it isn't empty):
} else if (empty($rows)) {
    echo "<p>No rows found</p>\n";
    echo '<p><a href="add.php">Add New Entry</a></p>' . "\n";
    echo '<p><a href="logout.php">Logout</a></p>' . "\n";
} else {
    echo '<table border="1">' . "\n";
    echo "<tr>\n";
    echo '<th style="text-align: center;">Make</th>' . "\n";
    echo '<th style="text-align: center;">Model</th>' . "\n";
    echo '<th style="text-align: center;">Year</th>' . "\n";
    echo '<th style="text-align: center;">Mileage</th>' . "\n";
    echo '<th style="text-align: center;">Action</th>' . "\n";
    echo "</tr>\n";
    foreach ($rows as $row) {
        echo "<tr>\n";
        echo '<td>' . htmlentities($row['make']) . "</td>\n";
        echo '<td>' . htmlentities($row['model']) . "</td>\n";
        echo '<td>' . $row['year'] . "</td>\n";
        echo '<td>' . $row['mileage'] . "</td>\n";
        echo '<td><a href="edit.php?autos_id=' . urlencode($row['autos_id']) . '">Edit</a> / ';
        echo '<a href="delete.php?autos_id=' . urlencode($row['autos_id']) . '">Delete</a>';
        echo "</td>\n";
        echo "</tr>\n";
    }
    echo "</table>\n";
    echo '<p><a href="add.php">Add New Entry</a></p>' . "\n";
    echo '<p><a href="logout.php">Logout</a></p>' . "\n";
}
?>
</div>
</body>
</html>
