<!DOCTYPE html>
<html>
	<header>
		<title>View Bids</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/biddingpage.css">
		<link rel="stylesheet" type="text/css" href="css/login.css">
	</header>
	<body>
		<div class="container">
				   <div class="row">

			       <section class="content">
			       <h1><b>View Bids</b></h1>

			       
				    <br>
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

			$queryappliances = "SELECT DISTINCT b.feeamount, i.itemname, i.availabledate, i.description, i.type, i.itemid 
	        FROM item i, member m, bidding b 
	        WHERE b.email = m.email AND m.email = '$email' AND i.itemid = b.itemid AND i.type = 'appliances'"; 
	        $querytools = "SELECT DISTINCT b.feeamount, i.itemname, i.availabledate, i.description, i.type, i.itemid 
	        FROM item i, member m, bidding b 
	        WHERE b.email = m.email AND m.email = '$email' AND i.itemid = b.itemid AND i.type = 'tools'"; 
	        $queryfurnitures = "SELECT DISTINCT b.feeamount, i.itemname, i.availabledate, i.description, i.type, i.itemid 
	        FROM item i, member m, bidding b 
	        WHERE b.email = m.email AND m.email = '$email' AND i.itemid = b.itemid AND i.type = 'furnitures'"; 
	        $querybooks = "SELECT DISTINCT b.feeamount, i.itemname, i.availabledate, i.description, i.type, i.itemid 
	        FROM item i, member m, bidding b 
	        WHERE b.email = m.email AND m.email = '$email' AND i.itemid = b.itemid AND i.type = 'books'"; 

	        $result_appliances = pg_query($queryappliances); 
	        $result_tools = pg_query($querytools); 
	        $result_furnitures = pg_query($queryfurnitures); 
	        $result_books = pg_query($querybooks); 
	        
			//start of form
			echo '<form id="bid-form" action="processbid.php" method="post" role="form" style="display: block;">';
			
			//fetch all tools
			while ($row = pg_fetch_assoc($result_tools)) {
				echo '<tr data-status="tools">
										<td>
  												<button type = "button" class = "btn btn-success">Successful</button>
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
				echo '<p class="summary">'.$row["description"].'</p></div></div></td></tr>';
				
			} 
			while ($row = pg_fetch_assoc($result_appliances)) {
				echo '<tr data-status="appliances">
										<td>
											
  												<button type = "button" class = "btn btn-success">Successful</button>
  											
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
				echo '<p class="summary">'.$row["description"].'</p></div></div></td></tr>';
				
				
			}
			//fetch all furnitures
			while ($row = pg_fetch_assoc($result_furnitures)) {
				echo '<tr data-status="furnitures">
										<td>
											
  												<button type = "button" class = "btn btn-success">Successful</button>
  											
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
				echo '<p class="summary">'.$row["description"].'</p></div></div></td></tr>';
				
				
			}
			//fetch all book
			while ($row = pg_fetch_assoc($result_books)) {
				echo '<tr data-status="books">

										<td>
											
  												<button type = "button" class = "btn btn-success">Successful</button>
  											
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
				echo '<p class="summary">'.$row["description"].'</p></div></div></td></tr>';
			}

			echo '</tbody></table>';

        
			pg_free_result($result);
			pg_free_result($result_books);
			pg_free_result($result_furnitures);
			pg_free_result($result_appliances);
			
		?>
		</form> <!-- End of Form -->

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
	<script type="text/javascript" src="js/login.js"></script>
	</body>	
</html>

