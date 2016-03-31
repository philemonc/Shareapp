<!DOCTYPE html>
<html>
<head>
	<?php
	include_once 'includes/dbconnect.php';
	$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());
	if(isset($_SESSION['email']) != "") {
		header("Location: retrieveinfo.php");
	}
	?>
	<title> Share App </title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
<div class="container">
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<h1 align="center"><b>Edit Item<b></h1>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<?php
									if(isset($_POST['edit'])) {
										$id = intval(pg_escape_string($_POST['edit']));
									}
									$query = "SELECT * FROM item WHERE id = ". $id;
									$result = pg_fetch_assoc(pg_query($query));
									$type = trim($result['type']);
									$fee = trim($result['fee']);
									$name = trim($result['name']);
									$pickup = trim($result['pickup']);
									$return = trim($result['return']);
									$date = trim($result['date']);
									$description = trim($result['description']);
								?>
								<form action = "process.php" method="post" role="form" >
									<div class="form-group">
										<?php
											echo '<input type="text" name="name" id="name" tabindex="1" class="form-control" placeholder="Item name" value="' . $name . '">';
										?>
									</div>
									<div class="form-group">
										<select class="form-control" name="type">
											<?php 
											if ($type == "furnitures"){
											
												echo '<option value="furnitures" selected>Furniture</option>
												<option value="tools">Tools</option>
												<option value="appliances">Appliances</option>
												<option value="books">Books</option>';
											} else if ($type == "tools"){
											
												echo '<option value="furnitures">Furniture</option>
												<option value="tools" selected>Tools</option>
												<option value="appliances">Appliances</option>
												<option value="books">Books</option>';
											} else if ($type == "appliances"){
											
												echo '<option value="furnitures">Furniture</option>
												<option value="tools">Tools</option>
												<option value="appliances" selected>Appliances</option>
												<option value="books">Books</option>';
											} else if ($type == "books"){
											
												echo '<option value="furnitures">Furniture</option>
												<option value="tools">Tools</option>
												<option value="appliances">Appliances</option>
												<option value="books" selected>Books</option>';
											}
											?>
										</select>
									</div>
									<div class="form-group">
										<?php
											echo '<input type="text" name="pickup" id="pickup" tabindex="2" class="form-control" placeholder="Pick Up Location" value="' . $pickup .'">';
										?>
									</div>
									<div class="form-group">
										<?php
											echo '<input type="text" name="return" id="return" tabindex="2" class="form-control" placeholder="Return Location" value="' . $return . '">';
										?>
									</div>
									<div class="form-group">
										<?php
											echo '<input type="date" name="availableDate" id="availableDate" tabindex="2" class="form-control" placeholder="Available Date dd/mm/yy" value="'. $date .'">';
										?>
									</div>

									<div class="form-group">
										<?php
											echo '<input type="text" name="description" id="description" tabindex="2" class="form-control" placeholder="Description"value="' . $description . '">';
										?>
									</div>
									<div class="form-group">
										<?php
											echo '<input type="text" name="fee" id="fee" tabindex="2" class="form-control" placeholder="Fee" value="' . $fee . '">';
										?>
									</div>
									<?php
										echo '<input type="hidden" name="id" id="id" value="' . $id . '">';
									?>
									<div class="modal-footer ">
										<button type="submit" name="edit-submit" id="edit-submit" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
pg_close($dbconn);
?>


	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/login.js"></script>
</body>
</html>