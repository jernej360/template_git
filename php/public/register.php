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
			<form action="addUser.php" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
        <label for="email">
          <i class="fas fa-envelope"></i>
        </label>
        <input type="text" name="email" placeholder="Email" id="email" required>
				<input type="submit" value="Login">
			</form>

      <div>
        <?php if(isset($_GET['w'])){

            echo "<label for='username'>
                      <i class='fas fa-user'></i>
                      ".$_GET['w']."
                  </label>";

        }
        ?>
      </div>
		</div>
	</body>
</html>
