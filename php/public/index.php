<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="style.css" rel="stylesheet" type="text/css">
  </head>
	<body>
		<div class="login">
			<h1>Login</h1>
			<form action="authenticate.php" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<input type="submit" value="Login">
			</form>
      <form action="register.php" method="post">
        <input type="submit" value="register">
      </form>

      <div>
        <?php if(isset($_GET['w'])){
          if($_GET['w']=="wp"){
            echo "<label for='username'>
                      <i class='fas fa-user'></i>
                      wrong password!
                  </label>";
          }
          if($_GET['w']=="lg"){
            echo "<label for='username'>
                      <i class='fas fa-user'></i>
                      logged out!
                  </label>";
          }
          if($_GET['w']=="rg"){
            echo "<label for='username'>
                      <i class='fas fa-user'></i>
                      you have been registerd now log in!
                  </label>";
          }

        }
        ?>
      </div>
		</div>
	</body>
</html>
