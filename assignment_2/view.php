<?php
session_start();

// Demand the 'name' parameter:
if (!isset($_SESSION['name'])) {
    die('Not logged in');
}

// Run a SQL query to get the list of automobiles:
require_once 'pdo.php';
$stmt = $pdo->query('SELECT make, year, mileage FROM autos');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<?php
require_once 'bootstrap.php';
?>
<title>Marcio Woitek Junior | Autos Database</title>
</head>
<body>
<div class='container'>
<?php
echo '<h1>Tracking Autos for ' . htmlentities($_SESSION['name']) . "</h1>\n";
// If necessary, print a flash message:
// Success message:
if (isset($_SESSION['success'])) {
    echo '<p style="color: green;">';
    echo $_SESSION['success'];
    echo "</p>\n";
    unset($_SESSION['success']);
}
?>
<h2>Automobiles</h2>
<?php
// Print the list of automobiles (if it isn't empty):
if (!empty($rows)) {
    echo "<ul>\n";
    foreach ($rows as $row) {
        echo '<li>' . $row['year'];
        echo ' ' . htmlentities($row['make']);
        echo ' / ' . $row['mileage'] . "</li>\n";
    }
    echo "</ul>\n";
}
?>
<p><a href='add.php'>Add New</a> | <a href='logout.php'>Logout</a></p>
</div>
</body>
</html>
