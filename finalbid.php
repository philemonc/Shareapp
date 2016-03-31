<!DOCTYPE html>
<html>
	<header>
		<title>Confirmed Bids</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/biddingpage.css">
	</header>
	<body>
		<?php 
			include_once 'includes/dbconnect.php';
			session_start();
			
			$bidd = $_SESSION['bidarray'];
			var_dump($bidd);

			$chk =	$_SESSION['checkedboxes'];
			var_dump($chk);

			$chkboxAr = $_SESSION['bids'];
			var_dump($chkboxAr);
			$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());

			echo ' <div class="container">
				   <div class="row">

			       <section class="content">
			       <h1>Confirmed Bids</h1>

			       <div class="container">
					<div class="row">		
			       <div class="col-md-8 col-md-offset-2">
				   <div class="panel panel-default">
					  <div class="panel-body">
						<div class="table-container">
						<table class="table table-filter">
						<tbody>';
			
			echo '<form id="confirmbid-form" action="processbid.php" method="post" role="form" style="display: block;">';

			foreach ($chkboxAr as $value) {
	        /*
	        $updatequery = "INSERT INTO bidding (name, email, feeamount, itemid, itemname, datetime)
	        VALUES (SELECT m.name, m.email, '$value', i.itemid, i.itemname, now() as i.datetime
	        FROM item i, member m 
	        WHERE i.itemid = '$value' AND m.email = i.email AND m.email = '.$_SESSION['email'].)'"; 
	        $resultupdate = pg_query($updatequery);*/
	        $email = $_SESSION['email'];
	        $query = "SELECT i.itemid, i.itemname, i.availabledate, i.description, i.type 
	        FROM item i, member m 
	        WHERE i.itemid = '$value' AND m.email = i.email AND m.email = '$email'"; 

	        $result = pg_query($query); 
			//fetch all selected items
			while ($row = pg_fetch_assoc($result)) {
				echo '<tr data-status="'.$row["type"].'">
										<td>
											<input type="text" name="bid[]" value="" maxlength="50" style="width:50px;">
										</td>
										<td>
											<a href="javascript:;" class="star">
												<i class="glyphicon glyphicon-star"></i>
											</a>
										</td>
										<td>
											<div class="media">
												<a href="#" class="pull-left">
													<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo">
												</a>';	
				echo '<div class="media-body"><span class="media-meta pull-right">'.$row["availabledate"].'</span>';
				echo '<h4 class="title">'.$row["itemname"].'<span class="pull-right '.$row["type"].'">('.$row["type"].')</span></h4>';
				echo '<p class="summary">'.$row["description"].'</p></div></div></td></tr>';	
				}
			} 
			pg_free_result($result);
				echo '</tbody></table>';
		?>
				</form>
				</div>
				</div>
				</div>
				<div class="text-left">
					<p>	
						<a href="retrieveinfo.php" class="btn btn-primary" role="button">Your Shared Items</a>
						<a href="borrowed.php" class="btn btn-primary" role="button">Your Borrowed Items</a>
						<a href="logout.php" class="btn btn-danger" role="button">Logout</a>
					</p>
				</div>
			</div>
		</section>
	</div>
</div>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="js/biddingpage.js"></script>
	</body>	
</html>

