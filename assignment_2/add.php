<?php
session_start();

// Demand the 'name' parameter:
if (!isset($_SESSION['name'])) {
    die('Not logged in');
}

// Check if the user clicked on the 'Cancel' button:
if (isset($_POST['cancel'])) {
    // Redirect the browser to view.php:
    header('Location: view.php');
    return;
}

require_once 'pdo.php';

// Check if we have some POST data:
if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {

    // Check if the make is empty:
    if (strlen($_POST['make']) < 1) {
        $_SESSION['error'] = 'Make is required';
        header('Location: add.php');
        return;

    // Check if mileage and year are numeric:
    } else if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = 'Mileage and year must be numeric';
        header('Location: add.php');
        return;

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
        $_SESSION['success'] = 'Record inserted';
        header('Location: view.php');
        return;
    }

}
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
// Error message:
if (isset($_SESSION['error'])) {
    echo '<p style="color: red;">';
    echo $_SESSION['error'];
    echo "</p>\n";
    unset($_SESSION['error']);
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
<input type='submit' name='cancel' value='Cancel'>
</form>
</div>
</body>
</html>
