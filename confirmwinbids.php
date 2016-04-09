<!DOCTYPE html>
<html>
	<header>
		<title>Selected Winning Bids</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/biddingpage.css">
		<style>
			h2 {color: #6495ed;
				font-family: Segoe UI Light;
				display: inline;}
		</style>
	</header>
	<body>
		<?php 
			include_once 'includes/dbconnect.php';
			session_start();
			$email = $_SESSION['email'];
			$chkboxAr = $_SESSION['checkedwin'];
			$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());

			echo ' <div class="container">
				   <div class="row">

			       <section class="content">
			       <h1><b>Selected Winning Bids</b></h1>

			       <div class="container">
					<div class="row">		
			       <div class="col-md-8 col-md-offset-2">
				   <div class="panel panel-default">
					  <div class="panel-body">
						<div class="table-container">
						<table class="table table-filter">
						<tbody>';
			
			echo '<form id="confirmbid-form" action="processbid.php" method="post" role="form" style="display: block;">';

			
        
        //first_value is bidderemail, second_value is itemid
		foreach ($chkboxAr as $first_value => $tmpArray) {
			foreach($tmpArray as $second_value) {
 
	        $result = pg_query("SELECT DISTINCT b.name, b.itemname, i.type FROM bidding b, item i WHERE i.itemid = '$second_value' AND b.itemid = i.itemid AND b.email = '$first_value'"); 

	        //successbid = 1 means successful, 0 means unsuccessful
	        //pendingstatus = 1 means pending, 0 means not pending

	        //change item availability to 0
	        $updateitem = pg_query("UPDATE item SET availabilityflag = '0' WHERE itemid = '$second_value'");

	        //update bid in bidding table
	        $resultupdate = pg_query("UPDATE bidding SET successbid = '1', pendingstatus = '0' WHERE email ='$first_value' AND itemid = '$second_value'");

	        //add new entry to loan table
	        $result_insertLoan = pg_query("INSERT INTO loan VALUES ('$first_value','$email', '$second_value', now(), now() + interval '14' day)");

	        //set all the rest to successbid = 0, pending status = 0
	        $result_newPendStatus = pg_query("UPDATE bidding SET successbid = '0', pendingstatus = '0' WHERE email <> '$first_value' AND itemid = '$second_value'");
			
			//fetch all selected items
			while ($row = pg_fetch_assoc($result)) {
					echo '<tr data-status="'.$row["type"].'">
										<td>
  												<button type = "button" class = "btn btn-success">Successful</button>
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
					echo '<p class="summary">Bidder: '.$row["name"].'</p></div></div></td></tr>';	
				}
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

