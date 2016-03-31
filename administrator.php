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
</head>
<body>
<?php
		include_once 'includes/dbconnect.php';
		$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());
		
		echo ' 
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
			</div>'
			
		if (isset($_POST['user-enter'])) {
			$username = pg_escape_string($_POST['name']);
			$email = pg_escape_string($_POST['email']);
			$query = "SELECT name, email FROM member WHERE name='$username' AND email='$email'";
			$result = pg_query($dbconn, $query);			
		}
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
	                   <th>Username</th>
	                   <th>Email></th>
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
				echo '<td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>';
				echo '</tr>';
				$i = $i + 1;
			}
			pg_free_result($result);
				echo '</tbody></table>';
					
?>

	<div class="row">
	<div class="span12">
		<div class="row">
		<div class="span4">
			<div class="well">
			<?php
			$query = "SELECT COUNT(*) FROM members WHERE adminflag = 0";
			$result = pg_query($dbconn, $query);
			echo '<h3>USERS</h3>'
			echo '<h2>' . $result . '</h2>';
			pg_free_result($result);
			?>
			</div>
		</div>
		<div class="span4">
			<div class="well">
			<?php
			$query = "SELECT COUNT(*) FROM item";
			$result = pg_query($dbconn, $query);
			echo '<h3>Total Items</h3>'
			echo '<h2>' . $result . '</h2>';
			pg_free_result($result);
			?>
			</div>
		</div>
		<div class="span4">
			<div class="well">
			<?php
			$query = "SELECT COUNT(*) FROM loan";
			$result = pg_query($query);
			echo '<h3>Transactions</h3>'
			echo '<h2>' . $result . '</h2>';
			pg_free_result($result);
			?>
			</div>
		</div>
		</div>
	</div>
	</div>
	
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
		<a href="logout.php" class="btn btn-danger" role="button">Logout</a>
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