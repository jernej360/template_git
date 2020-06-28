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
$stmt = $con->prepare('SELECT password,profile_pic,email FROM accounts WHERE username = ? AND id = ? ');
$stmt->bind_param('si', mysqli_real_escape_string($con, $_SESSION['name']),mysqli_real_escape_string($con, $_SESSION['id']));
$stmt->execute();
$stmt->bind_result($password,$profile_pic, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Welcome back, <?=htmlentities($_SESSION['name'])?>!</h1>
				<a href="./settings.php"><i class="fas"><img src="<?=htmlentities($profile_pic)?>" height="20" width="20"/></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
    <br/>
    <div id="myDIV" class="content header">
     <h1>My To Do List</h1>
     <input type="text" id="myInput" placeholder="Title...">
     <span onclick="newElement()" class="addBtn">Add</span>
    </div>

    <ul id="myUL" class="content">
     <li>Hit the gym</li>
     <li class="checked">Pay bills</li>
     <li>Meet George</li>
     <li>Buy eggs</li>
     <li>Read a book</li>
     <li>Organize office</li>
    </ul>
	</body>
<script>
var myNodelist = document.getElementsByTagName("LI");
var i;
for (i = 0; i < myNodelist.length; i++) {
  var span = document.createElement("SPAN");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  myNodelist[i].appendChild(span);
}

var close = document.getElementsByClassName("close");
var i;
for (i = 0; i < close.length; i++) {
  close[i].onclick = function() {
    var div = this.parentElement;
    div.style.display = "none";
  }
}

var list = document.querySelector('ul');
list.addEventListener('click', function(ev) {
  if (ev.target.tagName === 'LI') {
    ev.target.classList.toggle('checked');
  }
}, false);

function newElement() {
  var li = document.createElement("li");
  var inputValue = document.getElementById("myInput").value;
  var t = document.createTextNode(inputValue);
  li.appendChild(t);
  if (inputValue === '') {
    alert("You must write something!");
  } else {
    document.getElementById("myUL").appendChild(li);
  }
  document.getElementById("myInput").value = "";

  var span = document.createElement("SPAN");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  li.appendChild(span);

  for (i = 0; i < close.length; i++) {
    close[i].onclick = function() {
      var div = this.parentElement;
      div.style.display = "none";
    }
  }
}
</script>
</html>
