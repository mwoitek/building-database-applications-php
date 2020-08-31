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
$test_autos_id = isset($_POST['autos_id']);
if ($test_make && $test_model && $test_year && $test_mileage && $test_autos_id) {

    // Check if every field was filled:
    $test_make = strlen($_POST['make']) < 1;
    $test_model = strlen($_POST['model']) < 1;
    $test_year = strlen($_POST['year']) < 1;
    $test_mileage = strlen($_POST['mileage']) < 1;
    if ($test_make || $test_model || $test_year || $test_mileage) {
        $_SESSION['error'] = 'All fields are required';
        header('Location: edit.php?autos_id=' . urlencode($_POST['autos_id']));
        return;

    // Check if year is numeric:
    } else if (!is_numeric($_POST['year'])) {
        $_SESSION['error'] = 'Year must be an integer';
        header('Location: edit.php?autos_id=' . urlencode($_POST['autos_id']));
        return;

    // Check if mileage is numeric:
    } else if (!is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = 'Mileage must be an integer';
        header('Location: edit.php?autos_id=' . urlencode($_POST['autos_id']));
        return;

    // Input passes validation:
    } else {
        // Save the changes:
        $sql = 'UPDATE autos '
             . 'SET make = :mk, model = :md, year = :yr, mileage = :mi '
             . 'WHERE autos_id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(
            array(
                ':mk' => $_POST['make'],
                ':md' => $_POST['model'],
                ':yr' => $_POST['year'],
                ':mi' => $_POST['mileage'],
                ':id' => $_POST['autos_id']
            )
        );
        $_SESSION['success'] = 'Record edited';
        header('Location: index.php');
        return;
    }

}

// Make sure that autos_id is present:
if (!isset($_GET['autos_id'])) {
    $_SESSION['error'] = 'Missing autos_id';
    header('Location: index.php');
    return;
}

// Retrieve info on the automobile:
$sql = 'SELECT make, model, year, mileage FROM autos WHERE autos_id = :id';
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':id' => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row === false) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header('Location: index.php');
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
<?php
require_once 'bootstrap.php';
?>
<title>Marcio Woitek Junior | Editing...</title>
</head>
<body>
<div class='container'>
<h1>Editing Automobile</h1>
<?php
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
<?php
echo '<input type="text" name="make" id="make" size="100" value="' . htmlentities($row['make']) . '"><br>' . "\n";
?>
<label for='model'>Model:</label>
<?php
echo '<input type="text" name="model" id="model" size="100" value="' . htmlentities($row['model']) . '"><br>' . "\n";
?>
<label for='year'>Year:</label>
<?php
echo '<input type="text" name="year" id="year" size="40" value="' . $row['year'] . '"><br>' . "\n";
?>
<label for='mileage'>Mileage:</label>
<?php
echo '<input type="text" name="mileage" id="mileage" size="40" value="' . $row['mileage'] . '"><br>' . "\n";
echo '<input type="hidden" name="autos_id" value="' . $_GET['autos_id'] . '">' . "\n";
?>
<input type='submit' value='Save'>
<input type='submit' name='cancel' value='Cancel'>
</form>
</div>
</body>
</html>
