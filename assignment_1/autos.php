<?php
require_once 'pdo.php';

// Demand the 'name' parameter:
if (!isset($_GET['name']) || strlen($_GET['name']) < 1) {
    die('Name parameter missing');
}

// Check if the user clicked on the 'Logout' button:
if (isset($_POST['logout'])) {
    // Redirect the browser to index.php:
    header('Location: index.php');
    return;
}

// If we have no POST data:
$message = false;

// Check if we have some POST data:
if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    // Check if the make is empty:
    if (strlen($_POST['make']) < 1) {
        $message = 'Make is required';
        $success = false;
    // Check if mileage and year are numeric:
    } else if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $message = 'Mileage and year must be numeric';
        $success = false;
    // Input passes validation:
    } else {
        // Add the automobile to the database:
        $stmt = $pdo->prepare(
            'INSERT INTO autos (make, year, mileage) VALUES (:mk, :yr, :mi)'
        );
        $stmt->execute(
            array(
                ':mk' => $_POST['make'],
                ':yr' => $_POST['year'],
                ':mi' => $_POST['mileage']
            )
        );
        $message = 'Record inserted';
        $success = true;
    }
}

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
echo '<h1>Tracking Autos for ' . htmlentities($_GET['name']) . "</h1>\n";
if ($message !== false) {
    if ($success === false) {
        $begin = '<p style="color: red;">';
    } else {
        $begin = '<p style="color: green;">';
    }
    echo "$begin$message</p>\n";
}
?>
<form method='POST'>
<label for='make'>Make:</label>
<input type='text' name='make' id='make' size='100'><br>
<label for='year'>Year:</label>
<input type='text' name='year' id='year' size='40'><br>
<label for='mileage'>Mileage:</label>
<input type='text' name='mileage' id='mileage' size='40'><br>
<input type='submit' value='Add'>
<input type='submit' name='logout' value='Logout'>
</form>
<h2>Automobiles</h2>
<?php
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
</div>
</body>
</html>
