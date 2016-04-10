<!DOCTYPE html>
<html>
	<header>
		<title>Search For Items</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/biddingpage.css">
	</header>
	<body>
		<div class="container">
			<div class="row">
				<section class="content">
					<h1>Items up for bidding</h1>
					<div class="col-md-8 col-md-offset-2">
						<form id="search-form" action="search.php" method="post" role="form" style="display: block;">
							<div class="btn-group">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search" name="search">
									<div class="input-group-btn">
										<button name="search-submit" id="search-submit" class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
									</div>
								</div>
							</div>
						</form>
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="table-container">
									<table class="table table-filter">
										<tbody>
		<?php 
			include_once 'includes/dbconnect.php';
			$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());
			
			$search = '';
			if(isset($_POST['search-submit'])) {
				$search = pg_escape_string($_POST['search']);
			}

	        $query = "SELECT i.itemname, i.type, i.availabledate, i.description FROM item i WHERE i.itemname LIKE '%" . $search . "%'"; 
	        $result = pg_query($query); 
	        
			while ($row = pg_fetch_assoc($result)) {
				echo '<tr data-status="'.$row["type"].'">
										<td>
											<div class="ckbox">
												<input type="checkbox" id="checkbox">
											</div>
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
				echo '<h4 class="title">'.$row["itemname"].'<span class="pull-right tools">(Tools)</span></h4>';
				echo '<p class="summary">'.$row["description"].'</p></div></div></td></tr>';
			}
			pg_free_result($result);
				echo '</tbody></table>';
		?>
				</div>
				</div>
				</div>
				<div class="text-left">
					<p>	
						<a href="retrieveinfo.php" class="btn btn-primary" role="button">Back to Main Page</a>
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