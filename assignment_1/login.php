<?php
// Check if the user clicked on the 'Cancel' button:
if (isset($_POST['cancel'])) {
    // Redirect the browser to index.php:
    header('Location: index.php');
    return;
}

$salt = 'XyZzy12*_';
// pw: php123
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

// If we have no POST data:
$failure = false;

// Check if we have some POST data:
if (isset($_POST['who']) && isset($_POST['pass'])) {
    // Check if email and password were provided by the user:
    if (strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1) {
        $failure = 'Email and password are required';
    // Check if the email contains an at-sign (@):
    } else if (strpos($_POST['who'], '@') == false) {
        $failure = 'Email must have an at-sign (@)';
    // Check if the password is correct:
    } else {
        $check = hash('md5', $salt . $_POST['pass']);
        if ($check == $stored_hash) {
            error_log('Login success ' . $_POST['who']);
            // Redirect the browser to autos.php:
            header('Location: autos.php?name=' . urlencode($_POST['who']));
            return;
        } else {
            error_log('Login fail ' . $_POST['who'] . " $check");
            $failure = 'Incorrect password';
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
// Check for errors. If necessary, print an error message.
if ($failure !== false) {
    echo '<p style="color: red;">' . htmlentities($failure) . "</p>\n";
}
?>
<form method='POST'>
<label for='email'>Email</label>
<input type='text' name='who' id='email'><br>
<label for='pw'>Password</label>
<input type='password' name='pass' id='pw'><br>
<input type='submit' value='Log In'>
<input type='submit' name='cancel' value='Cancel'>
</form>
</div>
</body>
</html>
