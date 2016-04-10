	<!DOCTYPE html>
	<html>
	<head>
		<title>Your New Items</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/biddingpage.css">
		<link rel="stylesheet" type="text/css" href="css/login.css">
		<style>
			h1 {color: #6495ed;
				font-family: Segoe UI Light;
				display: inline;}
		</style>
	</head>
	<body>
	<?php 
			session_start();
			$email = $_SESSION['email'];
			include_once 'includes/dbconnect.php';
			$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());
	        $query = "SELECT i.itemname, i.pickuplocation, i.returnlocation, i.availabledate, i.description FROM item i WHERE i.email = '$email' AND i.itemid NOT IN (SELECT itemid FROM loan)"; 
	        
	        $result = pg_query($query); 
			$i = 0;
			echo '
			</table>
			</div>
			<div class="container">
			<div class="row">  
	        <div class="col-md-12">
	        <h1>Your New Items</h1>
	        <div class="table-responsive">

	                
	              <table id="mytable" class="table table-bordred table-striped">
	                   
	                   <thead>
	                   <th>Item Name</th>
	                   <th>Pick Up Location</th>
	                   <th>Return Location</th>
	                   <th>Available Date</th>
	                   <th>Description</th>
	                   </thead>
	    			   <tbody>';

			while ($row = pg_fetch_assoc($result)) {
				echo '<tr>';
				echo '
					  <td>
						'.$row['itemname'].'
					  </td>
					  <td>
						'.$row['pickuplocation'].'
					  </td>
					  <td>
						'.$row['returnlocation'].'
					  </td>
					   <td>
						'.$row['availabledate'].'
					  </td>
					   <td>
						'.$row['description'].'
					  </td>
					  ';
				echo '</tr>';
			}
			pg_free_result($result);
			echo '</tbody></table>';
	?>
	<div class="text-left">
		<a href="retrieveInfo.php" class="btn btn-primary" role="button">Back to Main Page</a>
		<a href="logout.php" class="btn btn-danger" role="button">Logout</a>
	</div>	                
	    

	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="js/biddingpage.js"></script>
	<script type="text/javascript" src="js/login.js"></script>
	</body>
	</html>