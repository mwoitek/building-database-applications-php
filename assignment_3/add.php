<?php
session_start();

// Demand the 'name' parameter:
if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
}

// Check if the user clicked on the 'Cancel' button:
if (isset($_POST['cancel'])) {
    // Redirect the browser to index.php:
    header('Location: index.php');
    return;
}

require_once 'pdo.php';

// Check if we have some POST data:
$test_make = isset($_POST['make']);
$test_model = isset($_POST['model']);
$test_year = isset($_POST['year']);
$test_mileage = isset($_POST['mileage']);
if ($test_make && $test_model && $test_year && $test_mileage) {

    // Check if every field was filled:
    $test_make = strlen($_POST['make']) < 1;
    $test_model = strlen($_POST['model']) < 1;
    $test_year = strlen($_POST['year']) < 1;
    $test_mileage = strlen($_POST['mileage']) < 1;
    if ($test_make || $test_model || $test_year || $test_mileage) {
        $_SESSION['error'] = 'All fields are required';
        header('Location: add.php');
        return;

    // Check if year is numeric:
    } else if (!is_numeric($_POST['year'])) {
        $_SESSION['error'] = 'Year must be an integer';
        header('Location: add.php');
        return;

    // Check if mileage is numeric:
    } else if (!is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = 'Mileage must be an integer';
        header('Location: add.php');
        return;

    // Input passes validation:
    } else {
        // Add the automobile to the database:
        $stmt = $pdo->prepare(
            'INSERT INTO autos (make, model, year, mileage) VALUES (:mk, :md, :yr, :mi)'
        );
        $stmt->execute(
            array(
                ':mk' => $_POST['make'],
                ':md' => $_POST['model'],
                ':yr' => $_POST['year'],
                ':mi' => $_POST['mileage']
            )
        );
        $_SESSION['success'] = 'Record added';
        header('Location: index.php');
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
<label for='model'>Model:</label>
<input type='text' name='model' id='model' size='100'><br>
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
