<?php
$whitelist = array(
    '127.0.0.1',
    '::1'
);
if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
  $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
  header($protocol . ' 404 Not Found');
  exit();
}else{
  if (!isset($_SESSION['loggedin'])) {
  	header('Location: index.html');
  	exit;
  }
  
  echo "Is you admin? hmmmmm....<br/>";
  echo "Welcome back masta! here you go ctf{thank_you_m@asta}";
}
?>
