<?php
   require_once dirname(__FILE__).'/config.inc';

	// Retrieve input.	
	//
	$username = 	$conn->real_escape_string($_POST["username"]);
	$password = 	$conn->real_escape_string($_POST["password"]);
	$subject  = 	$conn->real_escape_string($_POST["subject"]);
	$groupid = 		$conn->real_escape_string($_POST["groupid"]);
	$parameter = 	$conn->real_escape_string($_POST["parameter"]);
	$score = 		$conn->real_escape_string($_POST["score"]);
	
	// Create query.
	//
	$query = "
		INSERT INTO FeedBackItems (GroupID, FeedbackSuplierID, Subject, Parameter, Score) 
		VALUES 
		(
			'$groupid',
			(
				SELECT Users.UserID 
				FROM Users 	
				WHERE Users.Username = '$username' AND Users.Password = '$password'
			),
			'$subject',
			'$parameter',
			'$score' 	
		)";
	
	// Apply query and echo outcome.
	//
	$result = $conn->query($query);
?>