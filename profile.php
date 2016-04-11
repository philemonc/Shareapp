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
	<?php
		include_once 'includes/dbconnect.php';
		$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());
		
		$nquery = "SELECT name FROM member WHERE email='{$_SESSION['email']}'";
		$username = pg_query($dbconn, $nquery);
		$usernamed = pg_result($username, 0);
		$email = $_SESSION['email'];
		
		$pquery = "SELECT password FROM member WHERE email='{$_SESSION['email']}'";
		$password = pg_query($dbconn, $pquery);
		$passwordd = pg_result($password, 0);
		
		$aquery = "SELECT address FROM member WHERE email='{$_SESSION['email']}'";
		$address = pg_query($dbconn, $aquery);
		$addressd = pg_result($address, 0);
		
		$cquery = "SELECT contactNumber FROM member WHERE email='{$_SESSION['email']}'";
		$contact = pg_query($dbconn, $cquery);
		$contactd = pg_result($contact, 0);
		
		echo '
			<div class="row" align="center">
			<h2><b>Your Profile</b></h2>
			</div>
			<br>
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<form id="editProfile" method="post" role="form" style"display: none;">
							<div class="form-group">
								<label>Username:</label>
								<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="'.htmlspecialchars($usernamed).'" />
							</div>
							<div class="form-group">
								<label>Email:</label>
								<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="'.htmlspecialchars($email).'" />
							</div>
							<div class="form-group">
								<label>Password:</label>
								<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" value="'.htmlspecialchars($passwordd).'" />
							</div>
							<div class="form-group">
								<label>Confirm Password:</label>
								<input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password" value="'.htmlspecialchars($passwordd).'" />
							</div>
							<div class="form-group">
								<label>Address:</label>
								<input type="address" name="address" id="address" tabindex="2" class="form-control" placeholder="Home Address" value="'.htmlspecialchars($addressd).'" />
							</div>
							<div class="form-group">
								<label>Contact Number:</label>
								<input type="contact" name="contact" id="contact" tabindex="2" class="form-control" placeholder="Contact Number" value="'.htmlspecialchars($contactd).'" />
							</div>
							<div class="form-group">
								<input type="submit" name="profile-submit" id="profile-submit" tabindex="3" class="form-control btn btn-success" value="Update Profile">
							</div>
						</form>
						<div class="text-left">
							<a href="retrieveInfo.php" class="btn btn-primary" role="button">Back to Main Page</a>
							<a href="logout.php" class="btn btn-danger" role="button">Logout</a>
						</div>
					</div>
				</div>
			</div>';
		
		if(isset($_POST['profile-submit'])) {
			$username = pg_escape_string($_POST['username']);
			$cemail = pg_escape_string($_POST['email']); 
			$password = pg_escape_string($_POST['password']);
			$confirmpassword= pg_escape_string($_POST['confirm-password']);	
			$address = pg_escape_string($_POST['address']);
			$contact = pg_escape_string($_POST['contact']);
			
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
				$uquery = "Update member SET name='$username', email='$cemail', password='$password', address='$address', contactNumber='$contact' WHERE email='$email'";
				$result = pg_query($uquery);
				pg_free_result($result);
			}
		}
		pg_close($dbconn);	
	?>
	
</body>
</html>