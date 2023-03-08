<?php
session_start();
if(isset($_SESSION['user'])){
	header("Location: home.php");
	exit();
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Daily Roar Login</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"><link rel="stylesheet" href="./style.css">
</head>

<body>
<div class="box-form">
	<div class="left">
		<div class="overlay">
		<h1>Daily Roar</h1>
		<h3>"Onward and Upward!"</h3>
		</div>
	</div>
		<div class="right">
		<h5>Login</h5>
		<p>To begin sending out opportunities, Please enter your log in credentials. </p>
		<form name="input" action="login.php" method="post">
		<div class="inputs">
			<input type="text" placeholder="user name" name ="login_id" required="required">
			<br>
			<input type="password" placeholder="password" name="password" required="required">
		</div>
			<br><br>
		<div class="remember-me--forget-password">
				<a href="forgotPassword.php">Forgot Password?</a>
		</div>
			<br>
			<button type="submit" value="login">Login</button>
		</form>
	</div>
</div>
</body>
</html>
