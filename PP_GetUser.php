<?php
	error_log("[".__FILE__."] Info: Started", 0);

    require_once dirname(__FILE__).'/config.inc';

	// Retrieve input.
	//
	$username = $conn->real_escape_string($_POST["username"]);
	$password = $conn->real_escape_string($_POST["password"]);

	// Create query.
	//
	$query = "SELECT * FROM Users WHERE Username = '$username' AND Password = '$password'";

	$sth = $conn->query($query);

	// Show data for each row.
	//
	$rows = array();
	while($r = $sth->fetch_assoc())
	{
		$rows[] = $r;
	}

	if (!headers_sent()) {
    	header('Content-Type: application/json');
    }

	error_log("[".__FILE__."] Info: Emitting results", 0);

	print json_encode($rows);
?>