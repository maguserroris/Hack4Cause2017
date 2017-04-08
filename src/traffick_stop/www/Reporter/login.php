		<?php
		include("config.php");
		session_start();
   
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			// username and password sent from form 
      
			$username = mysqli_real_escape_string($db,$_POST['username']);
			$password = mysqli_real_escape_string($db,$_POST['password']);
			$password_hash = password_hash($password, PASSWORD_DEFAULT);
			$password_hash = mysqli_real_escape_string($db,$password_hash);
      
			$sql = "SELECT username, password_hash FROM users WHERE username = '$username'";
			$result = mysqli_query($db,$sql);
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			//$active = $row['active'];
      		$password_hash_db = $row['password_hash'];
			$count = mysqli_num_rows($result);
      
			// If result matched $myusername and $mypassword, table row must be 1 row
		
			if($count == 1 && password_verify($password,$password_hash_db)) {
				$_SESSION['login_reporter'] = $username;
         		header("location: index.php");
			}else {
				$error = "Your Login Name or Password is invalid";
				echo $error;
				echo $password;
				echo $password_hash_db;
			}
		}
		?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1" name="viewport"><!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Login</title><!-- Bootstrap -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"><!-- Theme -->
	<link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
	<div class="container" id="login_form">
		<div class=col-md-3></div>
		<div class=col-md-6>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="center">
			<div class="form-group"><input name="username" class="form-control" placeholder="Username" type="text" required></div>
			<div class="form-group"><input name="password" class="form-control" placeholder="Password" type="password" required></div>
			<div class="form-group"><input type="submit" class="btn btn-info" value="Log In"></div>
		</form>
		</div>
		<div class=col-md-3></div>
	</div><!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">
	</script> <!-- Latest compiled and minified JavaScript -->
	 
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js">
	</script>
</body>
</html>