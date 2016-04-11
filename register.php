<!DOCTYPE html>

<?php
	session_start();
	
	if (!$_SESSION['email']) {
		header("Location: index.php");
	}
?>
<html>
<head>
	<title>Profile</title>
	<link rel="stylesheet" type="text.css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text.css" href="css/style.css">
	<style>
		h2 {color: #6495ed;
			font-family: Segoe UI Light;
			display: inline;}
	</style>
</head>
<body>
	<div class="row" align="center">
			<h2><b>Create New User</b></h2>
			</div>
			<br>
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<form id="editProfile" method="post" role="form" style"display: none;">
							<div class="form-group">
								<label>Username:</label>
								<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
							</div>
							<div class="form-group">
								<label>Email:</label>
								<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
							</div>
							<div class="form-group">
								<label>Password:</label>
								<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" value="">
							</div>
							<div class="form-group">
								<label>Confirm Password:</label>
								<input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password" value="">
							</div>
							<div class="form-group">
								<label>Address:</label>
								<input type="address" name="address" id="address" tabindex="2" class="form-control" placeholder="Home Address" value="">
							</div>
							<div class="form-group">
								<label>Contact Number:</label>
								<input type="contact" name="contact" id="contact" tabindex="2" class="form-control" placeholder="Contact Number" value="">
							</div>
							<div class="form-group text-center">
								<input type="checkbox" tabindex="3" class="" name="adminflag" id="adminflag" value="1">
								<label for="adminflag">Admininstrator</label>
							</div>
							<div class="form-group">
								<input type="submit" name="profile-submit" id="profile-submit" tabindex="3" class="form-control btn btn-success" value="Create">
							</div>
						</form>
						<div class="text-left">
							<a href="administrator.php" class="btn btn-primary" role="button">Back to Admin</a>
							<a href="logout.php" class="btn btn-danger" role="button">Logout</a>
						</div>
					</div>
				</div>
			</div>
			
	<?php
		include_once 'includes/dbconnect.php';
		$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());
		
		if(isset($_POST['profile-submit'])) {
			$username = pg_escape_string($_POST['username']);
			$email = pg_escape_string($_POST['email']); 
			$password = pg_escape_string($_POST['password']);
			$confirmpassword= pg_escape_string($_POST['confirm-password']);	
			$address = pg_escape_string($_POST['address']);
			$contact = pg_escape_string($_POST['contact']);
			$admin = pg_escape_string($_POST['adminflag']);
			
			if($username == '') {
				echo '
					<div class="alert alert-danger">
						<strong>Please enter a username</strong>
					</div>';
			}
			
			if($email == '') {
				echo '
					<div class="alert alert-danger">
						<strong>Please enter an email</strong>
					</div>';
			}
			
			if($password == '') {
				echo '
					<div class="alert alert-danger">
						<strong>Please enter a password</strong>
					</div>';
			}
			
			if($confirmpassword == '') {
				echo '
					<div class="alert alert-danger">
						<strong>Please confirm your password</strong>
					</div>';
			}
			
			$rquery = "Select * FROM member WHERE email='$email' AND email <> '{$_SESSION['email']}'";
			$rresult = pg_query($rquery);
			$rrst = pg_num_rows($rresult);
			if ($rrst > 0) {
				echo '
					<div class="alert alert-danger">
						<strong>The email is already in use</strong>
					</div>';
			}
			pg_free_result($rresult);
			pg_free_result($rquery);

			if ($password == $confirmpassword) {
				$uquery = "INSERT INTO member VALUES ('$username', '$email', '$password', '$address', '$contact', '$admin')";
				$result = pg_query($uquery);
				pg_free_result($result);
			}
		}
		pg_close($dbconn);	
	?>

</body>
</html>