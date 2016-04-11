<!DOCTYPE html>
	
<?php
	session_start();
	
	if (!$_SESSION['email']) {
		header("Location: index.php");
	}
?>
<html>
<head>
	<title>Adminstrator</title>
	<link rel="stylesheet" type="text.css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text.css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/biddingpage.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<style>
		h1, h4 {color: #6495ed;
			font-family: Segoe UI Light;
			display: inline;}
	</style>
</head>
<body>
<?php
		include_once 'includes/dbconnect.php';
		$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());
?>		
			<div class="row" align="center">
			<h1><b>Adminstrator</b></h1>
			</div>
			<br>
			<div class="container">
			<form class="form-inline" role="form" method="post">
				<div class="form-group">
					<input class="form-control" id="name" type="text" name="name" placeholder="Name of User" value="">
				</div>
				<div class="form-group">
					<input class="form-control" id="email" type="text" name="email" placeholder="Email of User" value="">
				</div>
				<div class="form-group">
					<input type="submit" name="user-enter" id="user-enter" class="form-control btn btn-success" value="Enter">
				</div>
			</form>
			</div>

			<div class="container">
			<div class="row">  
	        <div class="col-md-12">
	        <h4>Users</h4>
	        <div class="table-responsive">

	                
	              <table id="mytable" class="table table-bordred table-striped">
	                   
	                   <thead>
	                   
	                   <th><input type="checkbox" id="checkall" /></th>
	                   <th>Username</th>
	                   <th>Email</th>
	                   </thead>
		<?php
			if (isset($_POST['user-enter'])) {
			$username = pg_escape_string($_POST['name']);
			$email = pg_escape_string($_POST['email']);
				if ($username == '' && $email != '') {
					$query = "SELECT name, email FROM member WHERE email LIKE '%$email%'";
				} else if ($username != '' && $email == '') {
					$query = "SELECT name, email FROM member WHERE name LIKE '%$username%'";
				} else {
					$query = "SELECT name, email FROM member";
				}
				$result = pg_query($dbconn, $query);			
			}
			
			echo '<form id="edituser-form" action="processbid.php" method="post" role="form" style="display: block;">';
			while ($row = pg_fetch_assoc($result)) {
				echo '<tr data-status="'.$row["type"].'">
					<td>
						<input name="checkbox1[]" type="checkbox" value="'.$row["email"].'">
					</td>
					<td>
						'.$row["name"].'
					</td>
					<td>
						'.$row["email"].'
					</td>';
			}
			pg_free_result($result);
		?>
				</table>
			</div>
			
		<div class="form-group">
					<div class="row">
						<div class="col-sm-6 col-sm-offset-3">
							<input type="submit" name="select" id="select" tabindex="4" class="form-control btn btn-bid" value="Select User">
						</div>
					</div>
				</div>
		</form> <!-- End of Form -->
		<?php
	        $query = "SELECT itemname, pickuplocation, returnlocation FROM item"; 
	        //$dbconn->prepare($query);
	        $result = pg_query($query); 
			$i = 0;
			echo '
			</div>
			</div>
			</div>
			<div class="container">
			<div class="row">  
	        <div class="col-md-12">
	        <h4>All Items</h4>
	        <div class="table-responsive">
	                
	              <table id="mytable" class="table table-bordred table-striped">
	                   
	                   <thead>
	                   
	                   <th>Delete/Edit</th>
	                   <th>Item Name</th>
					   <th>Pick-Up Point</th>
					   <th>Return Point</th>
	                   </thead>
	    			   <tbody>';
				echo '<form id="edititem-form" action="processbid.php" method="post" role="form" style="display: block;">';
			while ($row = pg_fetch_assoc($result)) {
				echo '<tr data-status="'.$row["type"].'">
					<td>
						<input name="checkbox2[]" type="checkbox" value="'.$row["itemid"].'">
					</td>
					<td>
						'.$row["itemname"].'
					</td>
					<td>
						'.$row["pickuplocation"].'
					</td>
					<td>
						'.$row["returnlocation"].'
					</td>';
			}
			pg_free_result($result);
				echo '</tbody></table>';
		?>
		<div class="form-group">
					<div class="row">
						<div class="col-sm-6 col-sm-offset-3">
							<input type="submit" name="select2" id="select2" tabindex="4" class="form-control btn btn-bid" value="Select Item">
						</div>
					</div>
				</div>
		</form> <!-- End of Form -->
			

	<div class="row">
		<div class="col-sm-4">
			<div class="well">
			<?php
			$query = "SELECT COUNT(*) FROM member";
			$user = pg_query($dbconn, $query);
			$userd = pg_result($user, 0);
			echo '<h3>USERS</h3>';
			echo '<h2>' . $userd . '</h2>';
			pg_free_result($user);
			pg_free_result($userd);
			?>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="well">
			<?php
			$query = "SELECT COUNT(*) FROM item";
			$item = pg_query($dbconn, $query);
			$itemd = pg_result($item, 0);
			echo '<h3>Total Items</h3>';
			echo '<h2>' . $itemd . '</h2>';
			pg_free_result($item);
			pg_free_result($itemd);
			?>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="well">
			<?php
			$query = "SELECT COUNT(*) FROM loan";
			$loan = pg_query($query);
			$loand = pg_result($loan, 0);
			echo '<h3>Transactions</h3>';
			echo '<h2>' . $loand . '</h2>';
			pg_free_result($loan);
			pg_free_result($loand);
			?>
			</div>
		</div>
		</div>
	</div>
	</div>
	
	
	<div class="text-left">
		<a href="retrieveInfo.php" class="btn btn-primary" role="button">Back to Main Page</a>
		<a href="register.php" class="btn btn-primary" role="button">Create New User</a>
		<a href="logout.php" class="btn btn-danger" role="button">Logout</a>
	</div>
	
		<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="js/login.js"></script>
</body>
</html>