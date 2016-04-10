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
		$email = $_SESSION['email'];
		
		$pquery = "SELECT password FROM member WHERE email='{$_SESSION['email']}'";
		$password = pg_query($dbconn, $pquery);
		
		$aquery = "SELECT address FROM member WHERE email='{$_SESSION['email']}'";
		$address = pg_query($dbconn, $aquery);
		
		$cquery = "SELECT contactNumber FROM member WHERE email='{$_SESSION['email']}'";
		$contact = pg_query($dbconn, $cquery);
		
		echo '
			<h2 align="center">Your Profile</h2>
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<form id="editProfile" method="post" role="form" style"display: none;">
							<div class="form-group">
								<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="<?php echo $username; ?>">
							</div>
							<div class="form-group">
								<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="<?php echo $email; ?>">
							</div>
							<div class="form-group">
								<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" value="<?php echo $password; ?>">
							</div>
							<div class="form-group">
								<input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password" value="<?php echo $password; ?>">
							</div>
							<div class="form-group">
								<input type="address" name="address" id="address" tabindex="2" class="form-control" placeholder="Home Address" value="<?php echo $address; ?>">
							</div>
							<div class="form-group">
								<input type="contact" name="contact" id="contact" tabindex="2" class="form-control" placeholder="Contact Number" value="<?php echo $contact; ?>">
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-6 col-sm-offset-3">
										<input type="submit" name="profile-submit" id="profile-submit" tabindex="3" class="form-control btn btn-register" value="Update Profile">
									</div>
								</div>
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
			$email = pg_escape_string($_POST['email']); 
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
			
			$rquery = "Select * FROM member WHERE email='$email'";
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
				$result = pg_query("INSERT INTO member(name, email, password, address, contactNumber) VALUES('$username', '$email', '$password', '$address', '$contact')");
				pg_free_result($result);
			}
		}
		pg_close($dbconn);	
	?>
	
</body>
</html>