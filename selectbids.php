<!DOCTYPE html>
<html>
	<header>
		<title>Your winning bids</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/biddingpage.css">
		<link rel="stylesheet" type="text/css" href="css/login.css">
		<style>
			h1 {color: #6495ed;
				font-family: Segoe UI Light;
				display: inline;}
		</style>
	</header>
	<body>
		<div class="container">
				   <div class="row">

			       <section class="content">
			       <div class="row" align="center">
			       <h1><b>Select Winning Bids</b></h1>
			       </div>
			       <br>
			       <div class="container">
			        <div class="col-md-8 col-md-offset-2">
				    <div class="panel panel-default">
					  <div class="panel-body">
						<div class="pull-right">
							<div class="btn-group">
								<button type="button" class="btn btn-success btn-filter" data-target="tools">Tools</button>
								<button type="button" class="btn btn-warning btn-filter" data-target="appliances">Appliances</button>
								<button type="button" class="btn btn-danger btn-filter" data-target="furnitures">Furniture</button>
								<button type="button" class="btn btn-primary btn-filter" data-target="books">Books</button>
								<button type="button" class="btn btn-default btn-filter" data-target="all">All</button>
							</div>
						</div>
						<div class="table-container">
						<table class="table table-filter">
						<tbody>
		<?php 
			include_once 'includes/dbconnect.php';
			$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());
			
			session_start();
			$email = $_SESSION['email'];

			//find all items that belong to user
			//retrieve all bids

			$queryappliances = "SELECT DISTINCT b.name, b.email, b.feeamount, i.itemname, i.availabledate, i.description, i.type, i.itemid 
	        FROM item i, bidding b 
	        WHERE b.successbid = '0' AND b.pendingstatus = '1' AND i.itemid = b.itemid AND i.type = 'appliances' AND i.itemid IN (SELECT i.itemid FROM item i WHERE i.email = '$email')"; 

	       	//user A's items that are out for bidding 
	        $querytools = "SELECT DISTINCT b.name, b.email, b.feeamount, i.itemname, i.availabledate, i.description, i.type, i.itemid 
	        FROM item i, bidding b 
	        WHERE b.successbid = '0' AND b.pendingstatus = '1' AND i.itemid = b.itemid AND i.type = 'tools' AND i.itemid IN (SELECT i.itemid FROM item i WHERE i.email = '$email')"; 

	        $queryfurnitures = "SELECT DISTINCT b.name, b.email, b.feeamount, i.itemname, i.availabledate, i.description, i.type, i.itemid 
	        FROM item i, bidding b 
	        WHERE b.successbid = '0' AND b.pendingstatus = '1' AND i.itemid = b.itemid AND i.type = 'furnitures' AND i.itemid IN (SELECT i.itemid FROM item i WHERE i.email = '$email')"; 

	        $querybooks = "SELECT DISTINCT b.name, b.email, b.feeamount, i.itemname, i.availabledate, i.description, i.type, i.itemid 
	        FROM item i, bidding b 
	        WHERE b.successbid = '0' AND b.pendingstatus = '1' AND i.itemid = b.itemid AND i.type = 'books' AND i.itemid IN (SELECT i.itemid FROM item i WHERE i.email = '$email')"; 



	        $result_appliances = pg_query($queryappliances); 
	        $result_tools = pg_query($querytools); 
	        $result_furnitures = pg_query($queryfurnitures); 
	        $result_books = pg_query($querybooks); 

			//start of form
			echo '<form id="winbid-form" action="processbid.php" method="post" role="form" style="display: block;">';
			
			//fetch all tools
			while ($row = pg_fetch_assoc($result_tools)) {
				echo '<tr data-status="tools">
										<td>
											
  												<input name="winbids['.$row["email"].'][]"  type="checkbox" value="'.$row["itemid"].'">
  										
										</td>
										<td>
											<p><b>Bid: '.$row['feeamount'].'</b></p>
										</td>
										<td>
											<div class="media">
												<a href="#" class="pull-left">
													<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo">
												</a>';
				echo '<div class="media-body"><span class="media-meta pull-right">'.$row["availabledate"].'</span>';
				echo '<h4 class="title">'.$row["itemname"].'<span class="pull-right tools">(tools)</span></h4>';
				echo '<p class="summary">Bidder: '.$row["name"].'</p></div></div></td></tr>';
				
			} 
			while ($row = pg_fetch_assoc($result_appliances)) {
				echo '<tr data-status="appliances">
										<td>
											
  												<input name="winbids['.$row["email"].'][]" type="checkbox" value="'.$row["itemid"].'">
  											
										</td>
										<td>
											<p><b>Bid: '.$row['feeamount'].'</b></p>
										</td>										
										<td>
											<div class="media">
												<a href="#" class="pull-left">
													<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo">
												</a>';	
				echo '<div class="media-body"><span class="media-meta pull-right">'.$row["availabledate"].'</span>';
				echo '<h4 class="title">'.$row["itemname"].'<span class="pull-right appliances">(appliances)</span></h4>';
				echo '<p class="summary">Bidder: '.$row["name"].'</p></div></div></td></tr>';
				
				
			}
			//fetch all furnitures
			while ($row = pg_fetch_assoc($result_furnitures)) {
				echo '<tr data-status="furnitures">
										<td>
											
  												<input name="winbids['.$row["email"].'][]" type="checkbox" value="'.$row["itemid"].'">
  											
										</td>
										<td>
											<p><b>Bid: '.$row['feeamount'].'</b></p>
										</td>
										<td>
											<div class="media">
												<a href="#" class="pull-left">
													<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo">
												</a>';	
				echo '<div class="media-body"><span class="media-meta pull-right">'.$row["availabledate"].'</span>';
				echo '<h4 class="title">'.$row["itemname"].'<span class="pull-right furnitures">(furnitures)</span></h4>';
				echo '<p class="summary">Bidder: '.$row["name"].'</p></div></div></td></tr>';
				
				
			}
			//fetch all book
			while ($row = pg_fetch_assoc($result_books)) {
				echo '<tr data-status="books">
										<td>
											
  												<input name="winbids['.$row["email"].'][]" type="checkbox" value="'.$row["itemid"].'">
  											
										</td>
										<td>
											<p><b>Bid: '.$row['feeamount'].'</b></p>
										</td>
									
										<td>
											<div class="media">
												<a href="#" class="pull-left">
													<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo">
												</a>';	
				echo '<div class="media-body"><span class="media-meta pull-right">'.$row["availabledate"].'</span>';
				echo '<h4 class="title">'.$row["itemname"].'<span class="pull-right books">(books)</span></h4>';
				echo '<p class="summary">Bidder: '.$row["name"].'</p></div></div></td></tr>';
			}

			echo '</tbody></table>';
			pg_free_result($result);
			pg_free_result($result_books);
			pg_free_result($result_furnitures);
			pg_free_result($result_appliances);
			
		?>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6 col-sm-offset-3">
							<input type="submit" name="winbid" id="winbid" tabindex="4" class="form-control btn btn-bid" value="Select Winning Bid">
						</div>
					</div>
				</div>
		</form> <!-- End of Form -->
		</div>
		</div>

	</div>
				
				<div class="text-left">
					<p>	
						<a href="retrieveInfo.php" class="btn btn-primary" role="button">Back to Main Page</a>
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
	<script type="text/javascript" src="js/login.js"></script>
	</body>	
</html>

