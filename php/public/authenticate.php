<?php
session_start();
$DATABASE_HOST = 'mysql';
$DATABASE_USER = 'debian-sys-maint';
$DATABASE_PASS = 'RYzSjLpIcxWKR45e';
$DATABASE_NAME = 'phplogin';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if ( !isset($_POST['username'], $_POST['password']) ) {
	header('Location: ./index.php?w=wp');
	exit('Please fill both the username and password fields!');
}

if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	$stmt->bind_param('s', mysqli_real_escape_string($con, $_POST['username']));
	$stmt->execute();
	$stmt->store_result();



    if ($stmt->num_rows > 0) {
  	$stmt->bind_result($id, $password);
  	$stmt->fetch();
  	if (password_verify(mysqli_real_escape_string($con, $_POST["password"]), $password)) {
  		session_regenerate_id();
  		$_SESSION['loggedin'] = TRUE;
  		$_SESSION['name'] = mysqli_real_escape_string($con, $_POST['username']);
  		$_SESSION['id'] = $id;
			header('Location: ./panel.php');
  		echo 'Welcome ' . $_SESSION['name'] . '!';
  	} else {
			header('Location: ./index.php?w=wp');
  		echo 'Incorrect password!';
  	}
  } else {
		header('Location: ./index.php?w=wp');
  	echo 'Incorrect password!';
  }
	$stmt->close();
}else{
	$error = $con->errno . ' ' . $con->error;
	echo $error; 
}

?>
