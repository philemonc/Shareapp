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
	</head>
	<body>
		<div class="container">
		<div class="row">  
		<div class="col-md-12">
		<?php 
			include_once 'includes/dbconnect.php';
			$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());

			$user = current(pg_fetch_row(pg_query($dbconn, "SELECT name FROM member WHERE email = '{$_SESSION['email']}'")));
			echo '<h1> Welcome ' . $user. '</h1>';
		 
	        $query = "SELECT i.type, i.itemid, i.feeflag, m.name,  i.itemname, pickuplocation, returnlocation FROM item i, loan l, member m WHERE i.email = '{$_SESSION['email']}' AND l.borrower = m.email AND l.lender = i.email"; 
	        //$dbconn->prepare($query);
	        $result = pg_query($query); 
			$i = 0;
			echo '
			</table>
			</div>
			<div class="container">
			<div class="row">  
	        <div class="col-md-12">
	        <h4>Your Shared Items</h4>
	        <div class="table-responsive">

	                
	              <table id="mytable" class="table table-bordred table-striped">
	                   
	                   <thead>
	                   
	                   <th><input type="checkbox" id="checkall" /></th>
	                   <th>Type</th>
	                   <th>Item ID</th>
	                   <th>Fee</th>
	                   <th>Borrower Name</th>
	                   <th>Item Name</th>
	                   <th>Pick Up Location</th>
	                   <th>Return Location</th>
	                   <th>Edit</th>
	                   <th>Delete</th>
	                   </thead>
	    			   <tbody>';

			while ($row = pg_fetch_row($result)) 
			{
				echo '<tr>';
				echo '<td><input type="checkbox" class="checkthis" /></td>';
				$count = count($row);
				$y = 0;
				while ($y < $count)
				{
					$c_row = current($row);
					echo '<td>' . $c_row . '</td>';
					next($row);
					$y = $y + 1;
				}
				echo '<td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" ><span class="glyphicon glyphicon-pencil"></span></button></p></td>
	    			<td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>';
				echo '</tr>';
				$i = $i + 1;
			}
			pg_free_result($result);
				echo '</tbody></table>';
	?>
	<div class="clearfix"></div>
	<ul class="pagination pull-right">
	  <li class="disabled"><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
	  <li class="active"><a href="#">1</a></li>
	  <li><a href="#">2</a></li>
	  <li><a href="#">3</a></li>
	  <li><a href="#">4</a></li>
	  <li><a href="#">5</a></li>
	  <li><a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
	</ul>
	<div class="text-left">
		<a href="borrowed.php" class="btn btn-primary" role="button">Borrowed Items</a>
		<a href="createItem.php" class="btn btn-primary" role="button">Create New Item</a>
		<a href="bidding.php" class="btn btn-primary" role="button">Bidding Page</a>
		<a href="administrator.php" class = "btn btn-primary" role="button">Administrator</a>
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
	<?php
		/*$query = "SELECT id FROM item";
		$result = pg_query($query);
		$i = 0;
		while ($row = pg_fetch_assoc($result)) {
			$id = $row['id'];
			echo '<div class="modal fade" id="delete' . $id . '" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
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
								<form action="process.php" method="post">
									<input type="hidden" name="id" id="id" value="' . $id . '">
									<button type="submit" name="delete-submit" id="delete-submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
									<button type="button" name="no-delete-submit" id="no-delete-submit" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove" action="retrieveinfo.php"></span> No</button>
								</form>
							</div>
						</div>
								<!-- /.modal-content --> 
					</div>
						<!-- /.modal-dialog --> 
				</div>';
			$i = $i + 1;
		}*/
	?>

	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/login.js"></script>
	</body>
	</html>