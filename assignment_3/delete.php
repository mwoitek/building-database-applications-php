<?php
session_start();

// Demand the 'name' parameter:
if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
}

require_once 'pdo.php';

// Check if we have some POST data:
if (isset($_POST['delete']) && isset($_POST['autos_id'])) {

    // Delete automobile from the database:
    $sql = 'DELETE FROM autos WHERE autos_id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':id' => $_POST['autos_id']));

    // Redirect the browser to index.php:
    $_SESSION['success'] = 'Record deleted';
    header('Location: index.php');
    return;

}

// Retrieve info on the automobile:
$sql = 'SELECT autos_id, make FROM autos WHERE autos_id = :id';
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
<title>Marcio Woitek Junior | Deleting...</title>
</head>
<body>
<div class='container'>
<?php
echo '<p>Confirm: Deleting ' . htmlentities($row['make']) . "</p>\n";
?>
<form method='POST'>
<?php
echo '<input type="hidden" name="autos_id" value="' . $row['autos_id'] . '">' . "\n";
?>
<input type='submit' name='delete' value='Delete'>
<a href='index.php'>Cancel</a>
</form>
</div>
</body>
</html>
