<!DOCTYPE html>

<?php
	session_start();
	
	if (!$_SESSION['email']) {
		header("Location: index.php");
	}
?>
<html>
<head>
	<title>Create Item</title>
	<link rel="stylesheet" type="text.css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text.css" href="css/style.css">
</head>
<body>
	<?php
		include_once 'includes/dbconnect.php';
		$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());
		
		/*echo '<h2>Create A New Item</h2>
			<form class="form-inline" role="form" method="post">
			<div class="dropdown">
				<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">Item Type
				<span class="caret"></span></button>
				<ul class="item-type" id="item-type">
					<li><a href="#">Appliance</li>
					<li><a href="#">Tool</li>
					<li><a href="#">Furniture</li>
					<li><a href="#">Books</li>
				</ul>
			</div>
			</form>
				';*/
		echo '<h2>Create A New Item</h2>
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<form id="createForm" method="post" role="form" style"display: none;">
							<div class="form-group">
								<input type="text" name="itemName" id="itemName" class="form-control" placeholder="Item Name" value="">
							</div>
							<div class="form-group row">
							<div class="col-sm-4">
								<label>Item Type:</label>
								<select name="itemType" required>
									<option value="appliances">Appliance</option>
									<option value="tools">Tool</option>
									<option value="furniture">Furniture</option>
									<option value="books">Books</option>
									<option value="others">Others</option>
								</select>
							</div>
							<div class="col-sm-4">
								<label> Need to Pay: </label>
								<select name="fee" required>
									<option value=1>Yes</option>
									<option value=0>No</option>
								</select>
							</div>
							</div>
							<div class="form-group">
								<p>Description</p>
								<textarea rows="4" cols="50" name="itemDesc" id="itemDesc" form="createForm" placeholder="No more than 100 characters"></textarea>
							</div>
							<div class="form-group">
								<label>Pick-Up Point</label>
								<input type="text" name="pickUp" id="pickUp" class="form-control" placeholder="Pick-Up Point" value="">
							</div>
							<div class="form-group">
								<label>Return Location</label>
								<input type="text" name="retL" id="retL" class="form-control" placeholder="Return Point" value="">
							</div>
							<div class="form-group">
								<input type="file" name="imagefile" accept="image/*" id="imagefile">
							</div>
							<div class="form-group">
								<input type="submit" name="itemSubmit" id="itemSubmit" class="form-control btn btn-success" value="Submit">
							</div>
						</form>
					</div>
				</div>
			</div>';
			
		if (isset($_POST['itemSubmit'])) {
			$itemName = $_POST['itemName'];
			$itemType = $_POST['itemType'];
			$feeFlag = $_POST['fee'];
			$itemDesc = $_POST['itemDesc'];
			//$itemImg = $_POST['imagefile'];
			$pickUp = $_POST['pickUp'];
			$retL = $_POST['retL'];
		}
		
		$itemID = mt_rand();
		$email = $_SESSION['email'];
		
		$cquery = "SELECT * FROM item WHERE itemid = '$itemID'";
		
		while (pg_query($dbconn, $cquery) == NULL) {
			$itemID = mt_rand();
		}
		
		$query = "INSERT INTO item VALUES ('$email','$itemType', '$itemID', '$feeFlag', '$itemName', '$pickUp', '$retL', now(), '$itemDesc', '1')";

		$result = pg_query($dbconn, $query);
	?>
	<div class="text-left">
		<a href="retrieveInfo.php" class="btn btn-success" role="button">Back to Main Page</a>
		<a href="logout.php" class="btn btn-danger" role="button">Logout</a>
	</div>
			
</body>