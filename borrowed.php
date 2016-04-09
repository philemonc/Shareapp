	<!DOCTYPE html>
	
	<?php
		session_start();
		
		if(!$_SESSION['email']) {
			header("Location: index.php");
		}
	?>
	<html>
	<head>
		<title>Borrowed Items</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
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

	        $query = "SELECT DISTINCT m2.name, i.itemname, l.borrowdate, l.returndate, i.pickuplocation, i.returnlocation FROM loan l, item i, member m1, member m2 WHERE m1.email = '{$_SESSION['email']}' AND i.email = l.lender AND l.lender = m2.email AND m1.email = l.borrower"; 
	        
	        $result = pg_query($query); 
			$i = 0;
			echo '
			</table>
			</div>
			<div class="container">
			<div class="row">  
	        <div class="col-md-12">
	        <h2>Your Borrowed Items</h2>
	        <div class="table-responsive">

	                
	              <table id="mytable" class="table table-bordred table-striped">
	                   
	                   <thead>
	                   <th>Lender Name</th>
	                   <th>Item Name</th>
	                   <th>Borrow Date</th>
	                   <th>Return Date</th>
	                   <th>Pick Up Location</th>
	                   <th>Return Location</th>
	                   </thead>
	    			   <tbody>';

			while ($row = pg_fetch_assoc($result)) {
				echo '<tr>';
				echo '<td>
						'.$row['name'].'
					  </td>
					  <td>
						'.$row['itemname'].'
					  </td>
					  <td>
						'.$row['borrowdate'].'
					  </td>
					  <td>
						'.$row['returndate'].'
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
		<a href="retrieveInfo.php" class="btn btn-primary" role="button">Back to Main Page</a>
		<a href="logout.php" class="btn btn-danger" role="button">Logout</a>
	</div>	                
	    

	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/login.js"></script>
	</body>
	</html>