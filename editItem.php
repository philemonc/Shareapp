<!DOCTYPE html>
<html>
<head>
	<title>Edit Item</title>
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
		session_start();
		$itemid = $_SESSION['checkedboxes2'];
		var_dump($itemid);
		include_once 'includes/dbconnect.php';
		$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());
		
		$nquery = "SELECT itemname FROM item WHERE itemid='$itemid'";
		$username = pg_query($dbconn, $nquery);
		$usernamed = pg_result($username, 0);
		
		$pquery = "SELECT pickuplocation FROM item WHERE itemid='$itemid'";
		$password = pg_query($dbconn, $pquery);
		$passwordd = pg_result($password, 0);
		
		$aquery = "SELECT returnlocation FROM item WHERE itemid='$itemid'";
		$address = pg_query($dbconn, $aquery);
		$addressd = pg_result($address, 0);
		
		echo '
			<div class="row" align="center">
			<h2><b>Edit Item</b></h2>
			</div>
			<br>
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<form id="editProfile" method="post" role="form" style"display: none;">
							<div class="form-group">
								<label>Item Name</label>
								<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="'.htmlspecialchars($usernamed).'" />
							</div>
							<div class="form-group">
								<label>Pick-Up Location</label>
								<input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="'.htmlspecialchars($passwordd).'" />
							</div>
							<div class="form-group">
								<label>Return Location</label>
								<input type="text" name="address" id="address" tabindex="2" class="form-control" placeholder="Home Address" value="'.htmlspecialchars($addressd).'" />
							</div>
							<div class="form-group">
								<input type="submit" name="profile-submit" id="profile-submit" tabindex="3" class="form-control btn btn-success" value="Edit">
							</div>
							<div class="form-group">
								<input type="submit" name="itemDelete" id="itemDelete" tabindex="3" class="form-control btn btn-danger" value="Delete">
							</div>
						</form>
						<div class="text-left">
							<a href="retrieveInfo.php" class="btn btn-primary" role="button">Back to Main Page</a>
							<a href="administrator.php" class="btn btn-warning" role="button">Administrator</a>
							<a href="logout.php" class="btn btn-danger" role="button">Logout</a>
						</div>
					</div>
				</div>
			</div>';
		
		if(isset($_POST['profile-submit'])) {
			$username = pg_escape_string($_POST['username']);
			$password = pg_escape_string($_POST['email']); 	
			$address = pg_escape_string($_POST['address']);
			
			if($username == '') {
				echo '
					<div class="alert alert-danger">
						<strong>Please enter a item name</strong>
					</div>';
			}
			
			if($password == '') {
				echo '
					<div class="alert alert-danger">
						<strong>Please enter a pick-up location</strong>
					</div>';
			}
			

			$uquery = "Update item SET itemname='$username', pickuplocation='$password', returnlocation='$address' WHERE itemid='$itemid'";
			$result = pg_query($uquery);
			pg_free_result($result);
		}
		
		if (isset($_POST['itemDelete'])) {
			$email = $_POST['email'];
			$query = "DELETE FROM item WHERE itemid='$itemid'";
			pg_query($dbconn, $query);
		}
		pg_close($dbconn);	
	?>
	
</body>
</html>