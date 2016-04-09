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

	        $query = "SELECT m2.name, i.itemname, l.borrowdate, l.returndate, i.pickuplocation, i.returnlocation FROM loan l, item i, member m1, member m2 WHERE m1.email = '{$_SESSION['email']}' AND i.email = l.lender AND l.lender = m2.email AND m1.email = l.borrower"; 
	        
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

			while ($row = pg_fetch_row($result)) 
			{
				echo '<tr>';
				
				$count = count($row);
				$y = 0;
				while ($y < $count)
				{
					$c_row = current($row);
					echo '<td>' . $c_row . '</td>';
					next($row);
					$y = $y + 1;
				}
				echo '</tr>';
				$i = $i + 1;
			}
			pg_free_result($result);
			echo '</tbody></table>';
	?>
	<div class="text-left">
		<a href="retrieveInfo.php" class="btn btn-primary" role="button">Back to Main Page</a>
		<a href="logout.php" class="btn btn-danger" role="button">Logout</a>
	</div>
	                
	<!-- Edit Button in Prompt -->
	<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
	      <div></div>
		  <div class="modal-dialog">
	    		<div class="modal-content">
	          		<div class="modal-header">
	        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
	        			<h4 class="modal-title custom_align" id="Heading">Edit Your Item Details</h4>
	      			</div>
	          		
	          		<div class="modal-body">
	          			<div class="form-group">
	       					<input class="form-control " type="text" placeholder="Type">
	        			</div>
	        		
	        			<div class="form-group">
	        				<input class="form-control " type="text" placeholder="Fee">
	        			</div>
	        			
	        			<div class="form-group">
	        				<input class="form-control " type="text" placeholder="Item Name">
	        			</div>

	        			<div class="form-group">
	        				<input class="form-control " type="text" placeholder="Pick Up Location">
	        			</div>
	        			
	        			<div class="form-group">
	        				<textarea rows="1" class="form-control" placeholder="Return Location"></textarea>        
	        			</div>
	      			</div>
	          
	          		<div class="modal-footer ">
	        			<button type="button" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
	      			</div>
	        	</div>
	    		<!-- /.modal-content --> 
	  		</div>
	      	<!-- /.modal-dialog --> 
	</div>
	    
	    
	<!-- Delete Button in Prompt -->    
	<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
	      <div class="modal-dialog">
	    		<div class="modal-content">
	          		<div class="modal-header">
	        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
	        			<h4 class="modal-title custom_align" id="Heading">Delete this item entry</h4>
	      			</div>
	          	
	          	<div class="modal-body">
	       				<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>	       
	      		</div>
	        		<div class="modal-footer ">
	        			<button type="button" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
	        			<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove" action='retrieveinfo.php'></span> No</button>
	      			</div>
	        	</div>
	    <!-- /.modal-content --> 
	  		</div>
	      <!-- /.modal-dialog --> 
	</div>

	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/login.js"></script>
	</body>
	</html>