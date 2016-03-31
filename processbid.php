<?php
    session_start();
	include_once 'includes/dbconnect.php';
	$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());

	$checkboxArray = $_SESSION['chkboxArr'];
	$checkfinal = array();
	
	//handle checkbox lists
	if(isset($_POST['bid'])) {
        $checked = $_POST['checkbox'];
        $_SESSION['checkedboxes'] = $checked;
        header("Location: confirmbid.php");
    }
    
    //handle list of bids
    if(isset($_POST['confirmbid'])) {
    	//array of all the bids
    	$bid = $_POST['bid'];
        $_SESSION['bidarray'] = $bid;
    	header("Location: finalbid.php");
    }
    //session variables to combine checked boxes and respective bids
     //amount 
    $_SESSION['bids'] = array_combine($checked, $bid);

   	pg_close($dbconn);

?> 
