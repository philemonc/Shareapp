<!DOCTYPE html>
<html>
	<header>
		<title>Bidding Page</title>
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
			       <h1><b>Items up for bidding</b></h1>
			       </div>
			       <br>
			       <form id="search-form" action="bidding.php" method="post" role="form" style="display: block;">
						<div class="btn-group">
							<div class="col-md-6 col-md-offset-3">
							<div class="input-group">
									<input type="text" class="form-control" placeholder="Search Items" name="search">
								<div class="input-group-btn">
										<button name="search-submit" id="search-submit" class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
								</div>
							</div>
							</div>
						</div>
					</form>
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
			
		$search = '';
		//handle search query
		if(isset($_POST['search-submit'])) {
			$search = pg_escape_string($_POST['search']);
			$query = "SELECT i.itemid, i.itemname, i.type, i.availabledate, i.description FROM item i WHERE i.itemname LIKE '%" . $search . "%'"; 
	        $result = pg_query($query); 
	        echo '<form id="bid-form" action="processbid.php" method="post" role="form" style="display: block;">';
	        
			while ($row = pg_fetch_assoc($result)) {
				echo '<tr data-status="'.$row["type"].'">
										<td>
											<input name="checkbox[]" type="checkbox" value="'.$row["itemid"].'">
										</td>
										<td>
											<a href="javascript:;" class="star">
												<i class="glyphicon glyphicon-star"></i>
											</a>
										</td>
										<td>
											<div class="media">';	
				echo '<div class="media-body"><span class="media-meta pull-right">'.$row["availabledate"].'</span>';
				echo '<h4 class="title">'.$row["itemname"].'<span class="pull-right tools">(Tools)</span></h4>';
				echo '<p class="summary">'.$row["description"].'</p></div></div></td></tr>';
			}
			pg_free_result($result);
			echo '</tbody></table>';
		
		} else { 
			//handle query not in search
			//1 means available, 0 means not available
	        $queryappliances = "SELECT DISTINCT i.itemid, i.itemname, i.availabledate, i.description
			FROM item i
			WHERE i.type = 'appliances' AND availabilityflag = '1' AND i.email <> '$email' AND i.itemid NOT IN (SELECT itemid FROM loan)";
	        
	        //query for tools
	        $querytools = "SELECT DISTINCT i.itemid, i.itemname, i.availabledate, i.description 
			FROM item i
			WHERE i.type = 'tools' AND availabilityflag = '1' AND i.email <> '$email' AND i.itemid NOT IN (SELECT itemid FROM loan)";

	        //query for furniture
	        $queryfurnitures = "SELECT DISTINCT i.itemid, i.itemname, i.availabledate, i.description
			FROM item i
			WHERE i.type = 'furnitures' AND availabilityflag = '1' AND i.email <> '$email' AND i.itemid NOT IN (SELECT itemid FROM loan)";

	        //query for books
	        $querybooks = "SELECT DISTINCT i.itemid, i.itemname, i.availabledate, i.description 
			FROM item i
			WHERE i.type = 'books' AND availabilityflag = '1' AND i.email <> '$email' AND i.itemid NOT IN (SELECT itemid FROM loan)";

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
											<div class="media">';	
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
											<div class="media">';	
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
											<div class="media">';	
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
											<div class="media">';	
				echo '<div class="media-body"><span class="media-meta pull-right">'.$row["availabledate"].'</span>';
				echo '<h4 class="title">'.$row["itemname"].'<span class="pull-right books">(books)</span></h4>';
				echo '<p class="summary">'.$row["description"].'</p></div></div></td></tr>';
			}

			echo '</tbody></table>';

        
			pg_free_result($result);
			pg_free_result($result_books);
			pg_free_result($result_furnitures);
			pg_free_result($result_appliances);
		}
		pg_close($dbconn);
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

