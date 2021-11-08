<?php
	error_log("[".__FILE__."] Info: Started", 0);

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
		INSERT INTO feedbackitems (GroupID, FeedbackSuplierID, Subject, Parameter, Score)
		VALUES
		(
			'$groupid',
			(
				SELECT users.UserID
				FROM users
				WHERE users.Username = '$username' AND users.Password = '$password'
			),
			'$subject',
			'$parameter',
			'$score'
		)";

	error_log("[".__FILE__."] Info: Emitting results", 0);

	if (!headers_sent()) {
 		header('Cache-Control: no-store, max-age=0');
    }

	// Apply query and echo outcome.
	//
	$result = $conn->query($query);
?>
