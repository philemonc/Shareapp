<!DOCTYPE html>
<html>
	<header>
		<title>Bidding Page</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/biddingpage.css">
		<link rel="stylesheet" type="text/css" href="css/login.css">
		<style>
			h2 {color: #6495ed;
				font-family: Segoe UI Light;
				display: inline;}
		</style>
	</header>
	<body>
		<div class="container">
				   <div class="row">

			       <section class="content">
			       <div class="row" align="center">
			       <h2><b>Items up for bidding</b></h2>
			       </div>
			       <div class="container">
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
			//1 means available, 0 means not available
	        $queryappliances = "SELECT i.itemid, i.itemname, i.availabledate, i.description FROM item i WHERE i.type = 'appliances' AND availablityflag = '1' AND i.email <> '$email'"; 
	        $querytools = "SELECT i.itemid, i.itemname, i.availabledate, i.description FROM item i WHERE i.type = 'tools' AND availablityflag = '1' AND i.email <> '$email'";
	        $queryfurnitures = "SELECT i.itemid, i.itemname, i.availabledate, i.description FROM item i WHERE i.type = 'furnitures' AND availablityflag = '1' AND i.email <> '$email'";
	        $querybooks = "SELECT i.itemid, i.itemname, i.availabledate, i.description FROM item i WHERE i.type = 'books' AND availablityflag = '1' AND i.email <> '$email'";

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
											
  												<input name="checkbox[]"  type="checkbox" value="'.$row["itemid"].'">
  										
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
				echo '<h4 class="title">'.$row["itemname"].'<span class="pull-right tools">(tools)</span></h4>';
				echo '<p class="summary">'.$row["description"].'</p></div></div></td></tr>';
				
			} 
			while ($row = pg_fetch_assoc($result_appliances)) {
				echo '<tr data-status="appliances">
										<td>
											
  												<input name="checkbox[]" type="checkbox" value="'.$row["itemid"].'">
  											
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
				echo '<h4 class="title">'.$row["itemname"].'<span class="pull-right appliances">(appliances)</span></h4>';
				echo '<p class="summary">'.$row["description"].'</p></div></div></td></tr>';
				
				
			}
			//fetch all furnitures
			while ($row = pg_fetch_assoc($result_furnitures)) {
				echo '<tr data-status="furnitures">
										<td>
											
  												<input name="checkbox[]" type="checkbox" value="'.$row["itemid"].'">
  											
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
				echo '<h4 class="title">'.$row["itemname"].'<span class="pull-right furnitures">(furnitures)</span></h4>';
				echo '<p class="summary">'.$row["description"].'</p></div></div></td></tr>';
				
				
			}
			//fetch all book
			while ($row = pg_fetch_assoc($result_books)) {
				echo '<tr data-status="books">
										<td>
											
  												<input name="checkbox[]" type="checkbox" value="'.$row["itemid"].'">
  											
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
				echo '<h4 class="title">'.$row["itemname"].'<span class="pull-right books">(books)</span></h4>';
				echo '<p class="summary">'.$row["description"].'</p></div></div></td></tr>';
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
							<input type="submit" name="bid" id="bid" tabindex="4" class="form-control btn btn-bid" value="Bid">
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

