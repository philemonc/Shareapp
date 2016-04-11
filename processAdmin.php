<?php
	session_start();
	include_once 'includes/dbconnect.php';
	$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());
	
	if (isset($_POST['userDelete'])) {
		$email = $_POST['email'];
		$query = "DELETE FROM member WHERE email='$email'";
		pg_query($dbconn, $query);
	}
	
	if (isset($_POST['itemDelete'])) {
		$itemID = $_POST['itemID'];
		$query = "DELETE FROM item WHERE itemID='$itemID'";
		pg_query($dbconn, $query);
	}