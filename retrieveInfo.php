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
	        $query = "SELECT DISTINCT i.type, i.availabilityflag, i.feeflag, m.name,  i.itemname, i.pickuplocation, i.returnlocation FROM bidding b, item i, loan l, member m WHERE i.email = '{$_SESSION['email']}' AND l.borrower = m.email AND l.lender = i.email AND i.itemid = b.itemid AND b.successbid = '1' AND b.pendingstatus = '0'"; 
	        
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
	                   <th>Availability</th>
	                   <th>Fee</th>
	                   <th>Borrower Name</th>
	                   <th>Item Name</th>
	                   <th>Pick Up Location</th>
	                   <th>Return Location</th>
	                   <th>Edit</th>
	                   <th>Delete</th>
	                   </thead>
	    			   <tbody>';

			while ($row = pg_fetch_assoc($result)) 
			{
				echo '<tr>';
				echo '<td>
						'.$row['type'].'
					  </td>
					  <td>
						'.$row['availabilityflag'].'
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
				echo '<td>
						<p data-placement="top" data-toggle="tooltip" title="Edit">
							<button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" >
								<span class="glyphicon glyphicon-pencil"></span>
							</button>
						</p>
					</td>
    				<td>
    					<p data-placement="top" data-toggle="tooltip" title="Delete">
    						<button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" >
    							<span class="glyphicon glyphicon-trash"></span>
    						</button>
    					</p>
    				</td>';
				echo '</tr>';
			}
			pg_free_result($result);
			echo '</tbody></table>';
	?>
	<div class="text-left">
		<a href="borrowed.php" class="btn btn-primary" role="button">Borrowed Items</a>
		<a href="createItem.php" class="btn btn-primary" role="button">Create New Item</a>
		<a href="bidding.php" class="btn btn-success" role="button">Bidding Page</a>
		<a href="selectbids.php" class="btn btn-info" role="button">Select Bids</a>
		<a href="viewbids.php" class="btn btn-info" role="button">View Bids</a>
		<a href="administrator.php" class = "btn btn-warning" role="button">Administrator</a>
		<a href="logout.php" class="btn btn-danger" role="button">Logout</a>
	</div>

	<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      	<div class="modal-dialog">
    		<div class="modal-content">
          		<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        			<h4 class="modal-title custom_align" id="Heading">Edit Your Detail</h4>
      			</div>
          		<div class="modal-body">
          			<div class="form-group">
        				<input class="form-control " type="text" placeholder="Pick Up Location">
        			</div>
        			<div class="form-group">
        				<input class="form-control " type="text" placeholder="Return Location">
        			</div>
      			</div>
          		<div class="modal-footer ">
        			<button type="submit" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
      			</div>
        	</div><!-- /.modal-content --> 
  		</div><!-- /.modal-dialog --> 
    </div>
    
    
    
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      	<div class="modal-dialog">
    		<div class="modal-content">
          		<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        			<h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
      			</div>
      			<form action = "process.php" method="post" id = "yesbuttonf">
          		<div class="modal-body">
       				<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>
       			</div>
        		<div class="modal-footer ">
        			<button type="submit" name= "yesbutton" id= "yesbutton" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
        			<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
      			</div>
      			</form>
        	</div><!-- /.modal-content --> 
  		</div><!-- /.modal-dialog --> 
    </div>

	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/login.js"></script>
	</body>
	</html>