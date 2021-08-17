<?php
    require_once dirname(__FILE__).'/config.inc';
	
	// 	Retrieve input.	
	//
	$username = 	$conn->real_escape_string($_POST["username"]);
	$password = 	$conn->real_escape_string($_POST["password"]);
	//$userid = 		$conn->real_escape_string($_POST["userid"]);
	$groupid = 		$conn->real_escape_string($_POST["groupid"]);
	$courseid = 	$conn->real_escape_string($_POST["courseid"]);
	$public = 		$conn->real_escape_string($_POST["public"]);

	// 	Create query.
	//
	$query = "
	UPDATE UserAndGroupRelations 
	SET Public = '$public'	
	WHERE 
	GroupID = '$groupid'
	AND
	UserID =	
	(
		SELECT UserID 
		FROM Users 
		WHERE Username = '$username' 
		AND Password = '$password'
	)		
	";
	
	// Apply query and echo outcome.
	//
	$result = $conn->query($query);
?>