<?php
session_start();

$salt = 'XyZzy12*_';
// pw: php123
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

// Check if we have some POST data:
if (isset($_POST['email']) && isset($_POST['pass'])) {

    // Logout current user:
    unset($_SESSION['name']);

    // Check if user name and password were provided by the user:
    if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
        $_SESSION['error'] = 'User name and password are required';
        header('Location: login.php');
        return;

    // Check if the password is correct:
    } else {
        $check = hash('md5', $salt . $_POST['pass']);
        if ($check == $stored_hash) { // CORRECT
            // Redirect the browser to index.php:
            $_SESSION['name'] = $_POST['email'];
            header('Location: index.php');
            return;
        } else { // INCORRECT
            $_SESSION['error'] = 'Incorrect password';
            header('Location: login.php');
            return;
        }
    }

}
?>

<!DOCTYPE html>
<html>
<head>
<?php require_once 'bootstrap.php'; ?>
<title>Marcio Woitek Junior | Login Page</title>
</head>
<body>
<div class='container'>
<h1>Please Log In</h1>
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
<label for='user_name'>User Name</label>
<!-- The weird 'name' wasn't my choice. -->
<input type='text' name='email' id='user_name'><br>
<label for='pw'>Password</label>
<input type='password' name='pass' id='pw'><br>
<input type='submit' value='Log In'>
<a href='index.php'>Cancel</a>
</form>
</div>
</body>
</html>
