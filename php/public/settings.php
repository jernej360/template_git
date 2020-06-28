<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
$DATABASE_HOST = 'mysql';
$DATABASE_USER = 'debian-sys-maint';
$DATABASE_PASS = 'RYzSjLpIcxWKR45e';
$DATABASE_NAME = 'phplogin';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$stmt = $con->prepare('SELECT password,profile_pic,email FROM accounts WHERE `username` = ? AND `id` = ? ');
$stmt->bind_param('si', mysqli_real_escape_string($con, $_SESSION['name']),mysqli_real_escape_string($con, $_SESSION['id']));
$stmt->execute();
$stmt->bind_result($password,$profile_pic, $email);
$stmt->fetch();
$stmt->close();

if(isset($_POST["submit"])){
  if(isset($_POST["picname"])){
    if($stmt1 = $con->prepare('UPDATE `accounts` SET `profile_pic` = ? WHERE `username` = ? AND `id` = ? ')){
      if($stmt1->bind_param('ssi', mysqli_real_escape_string($con, $_POST["picname"]), mysqli_real_escape_string($con, $_SESSION['name']),mysqli_real_escape_string($con, $_SESSION['id']))){
        $stmt1->execute();
        $stmt1->fetch();
        $profile_pic=$_POST["picname"];


        //save pic
        $url = $profile_pic;
        $img = base64_encode ($_SESSION['name'].$_SESSION['id']."savedForLaterHAHA");
        $ch = curl_init($url);
        $fp = fopen($img, 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

      }else {
        $error = $con->errno . ' ' . $con->error;
        echo $error;
      }
    }else {
      $error = $con->errno . ' ' . $con->error;
      echo $error;
    }
    $stmt1->close();
  }
}


function is_image($path)
{
	$a = getimagesize($path);
	$image_type = $a[2];

	if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
	{
		return true;
	}
	return false;
}


?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Settings</h1>
        <a href="panel.php"><i class="fas"></i>< Back</a>
				<a href="./settings.php"><i class="fas"><img src="<?=$profile_pic?>" height="20" width="20"/></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Username:</td>
						<td><?=htmlentities($_SESSION['name']);?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><?=htmlentities($password);?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=htmlentities($email);?></td>
					</tr>
          <tr>
            <td>Change your avatar:</td>
            <td>
              <form action="#" method="post">
                <input type="text" name="picname" placeholder="<?=htmlentities($profile_pic)?>">
                <input type="submit" name="submit" value="Set pic">
              </form>
            </td>
          </tr>
				</table>
			</div>
		</div>
	</body>
  <?php
  if(isset($_POST["submit"])){
    if(isset($_POST["picname"])){
      echo "  <script> $(function(){\$( '#dialog' ).dialog();});</script>";
      include("avatar_display.php");
    }
  }
  ?>
</html>
