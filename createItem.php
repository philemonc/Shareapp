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
			<form id="createForm" method="post" role="form" style"display: none;">
			<div class="form-group">
				<input type="text" name="itemName" id="itemName" class="form-control" placeholder="Item Name" value="">
			</div>
			<div class="form-group row">
				<label> Type of Item: </label>
				<select name="itemType" required>
					<option value="appliances">Appliance</option>
					<option value="tools">Tool</option>
					<option value="furniture">Furniture</option>
					<option value="books">Books</option>
					<option value="others">Others</option>
				</select>
				<label> Need to Pay: </label>
				<select name="fee" required>
					<option value=1>Yes</option>
					<option value=0>No</option>
				</select>
			</div>
			<div class="form-group">
				<label for="desc">Description</label>
				<textarea name="itemDesc" id="itemDesc" form="createForm" maxlength="100" placeholder="No more than 100 characters"></textarea>
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
			</form>'
			
		if (isset($_POST[Submit])) {
			$itemName = $_POST['itemName'];
			$itemType = $_POST['itemType'];
			$feeFlag = $_POST['fee'];
			$itemDesc = $_POST['itemDesc'];
			$itemImg = $_POST['imagefile'];
			$pickUp = $_POST['pickUp'];
			$retL = $_POST['retL'];
		}
		
		$itemID = mt_rand();
		$today = getdate();
		
		$cquery = "SELECT * FROM item WHERE itemID = '$itemID'";
		
		while (pg_query($dbconn, $cquery) != NULL)
			$itemID = mt_rand();
		
		$query = 'INSERT INTO item (email, type, itemID, feeFlag, itemName, pickupLocation, returnLocation, availableDate, description, availabilityFlag)
					VALUES ('{$_SESSION['email']}', '$itemType', '$itemID', '$feeFlag', '$itemName', '$pickUp', '$retL', '$today', '$itemDesc', 0)';

		pg_query($dbconn, $query);
		}
		
	?>	
			
</body>