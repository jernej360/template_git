<?php
$DATABASE_HOST = 'mysql';
$DATABASE_USER = 'debian-sys-maint';
$DATABASE_PASS = 'RYzSjLpIcxWKR45e';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
  header('Location: ./register.php?w=try later!');
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());

}
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
  header('Location: ./register.php?w=Please complete the registration form!');
	exit('Please complete the registration form!');
}
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
  header('Location: ./register.php?w=Please complete the registration form!');
	exit('Please complete the registration form');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  header('Location: ./register.php?w=Please dont! Valid email only');
	exit('Email is not valid!');
}

if (preg_match('/[A-Za-z0-9]+/', $_POST['username']) == 0) {
    header('Location: ./register.php?w=Please dont! Only normal chars');
    exit('Username is not valid!');
}

if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
  header('Location: ./register.php?w=Password must be between 5 and 20 characters long!');
	exit('Password must be between 5 and 20 characters long!');
}

if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
    header('Location: ./register.php?w=Username exists, please choose another!');
		echo 'Username exists, please choose another!';
	} else {
    if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, profile_pic) VALUES (?, ?, ?,"https://upload.wikimedia.org/wikipedia/commons/7/7e/Circle-icons-profile.svg")')) {
    	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    	$stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
    	$stmt->execute();
      header('Location: ./index.php?w=rg');
    	echo 'You have successfully registered, you can now login!';
    } else {
      header('Location: ./register.php?w=Stop it! Its not going to help!');
    	echo 'Could not prepare statement!';
    }
	}
	$stmt->close();
} else {
  header('Location: ./register.php?w=Stop it! Its not going to help!');
	echo 'Could not prepare statement!';
}
$con->close();
?>
