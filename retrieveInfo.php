	<!DOCTYPE html>
	
	<?php
		session_start();
		
		if(!$_SESSION['email']) {
			header("Location: index.php");
		}
	?>
	<html>
	<head>
		<title>Retrieve Item Information</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/biddingpage.css">
		<link rel="stylesheet" type="text/css" href="css/login.css">
		<style>
			h2 {color: #6495ed;
				font-family: Segoe UI Light;
				display: inline;}
		</style>
	</head>
	<body>
		<div class="container">
		<div class="row">  
		<div class="col-md-12">
		<?php 
			include_once 'includes/dbconnect.php';
			$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());

			$user = current(pg_fetch_row(pg_query($dbconn, "SELECT name FROM member WHERE email = '{$_SESSION['email']}'")));
			echo '<h1><b> Welcome ' . $user. ' !</b></h1>';
		?>
		 
			<?php
	        $query = "SELECT DISTINCT i.itemid, i.type, i.feeflag, m.name,  i.itemname, i.pickuplocation, i.returnlocation 
	        FROM item i, loan l, member m 
	        WHERE i.email = '{$_SESSION['email']}' AND l.borrower = m.email AND l.lender = i.email AND l.itemid = i.itemid"; 
	        
	        $result = pg_query($query); 
			$i = 0;
			echo '
			</table>
			</div>
			<div class="container">
			<div class="row">  
	        <div class="col-md-12">
	        <h2>Your Shared Items</h2>
	        <div class="table-responsive">

	                
	              <table id="mytable" class="table table-bordred table-striped">
	                   
	                   <thead>
	                   <th>Type</th>
	                   <th>Fee</th>
	                   <th>Borrower Name</th>
	                   <th>Item Name</th>
	                   <th>Pick Up Location</th>
	                   <th>Return Location</th>
	                   </thead>
	    			   <tbody>';
	
			while ($row = pg_fetch_assoc($result)) 
			{
				echo '<tr>';
				echo '
					 <td>
						'.$row['type'].'
					 </td>
					 <td>
						'.$row['feeflag'].'
					 </td>
					 <td>
						'.$row['name'].'
					 </td>
					 <td>
						'.$row['itemname'].'
					 </td>
					 <td>
						'.$row['pickuplocation'].'
					 </td>
					 <td>
						'.$row['returnlocation'].'
					 </td>
					  ';
				echo '</tr>';
			}
			pg_free_result($result);
			echo '</tbody></table>';
	?>
	<div class="text-left">
		<a href="profile.php" class="btn btn-primary" role="button">Profile</a>
		<a href="newitems.php" class="btn btn-primary" role="button">New Items</a>
		<a href="borrowed.php" class="btn btn-primary" role="button">Borrowed Items</a>
		<a href="createItem.php" class="btn btn-primary" role="button">Create New Item</a>
		<a href="bidding.php" class="btn btn-success" role="button">Bidding Page</a>
		<a href="selectbids.php" class="btn btn-info" role="button">Select Bids</a>
		<a href="viewbids.php" class="btn btn-info" role="button">View Bids</a>
		<?php
			$query = "SELECT adminFlag FROM member WHERE email='{$_SESSION['email']}'";
			if (pg_query($query) == 1) {
				echo '<a href="administrator.php" class = "btn btn-warning" role="button">Administrator</a>';
			}
		?>
		<a href="logout.php" class="btn btn-danger" role="button">Logout</a>
	</div>    
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="js/biddingpage.js"></script>
	<script type="text/javascript" src="js/login.js"></script>
	</body>
	</html>