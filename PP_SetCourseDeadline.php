<?php
	error_log("[".__FILE__."] Info: Started", 0);

    require_once dirname(__FILE__).'/config.inc';

	// 	Retrieve input.
	//
	$username = 	$conn->real_escape_string($_POST["username"]);
	$password = 	$conn->real_escape_string($_POST["password"]);
	$courseid = 	$conn->real_escape_string($_POST["courseid"]);
	$deadline = 	$conn->real_escape_string($_POST["deadline"]);

	// 	Create query.
	//
	$query = "
	UPDATE courses
	SET Deadline = '$deadline'
	WHERE
	CourseID = '$courseid'
	AND
	LeraarUserID =
	(
		SELECT UserID
		FROM users
		WHERE Username = '$username'
		AND Password = '$password'
	)
	";

	error_log("[".__FILE__."] Info: Emitting results", 0);

	if (!headers_sent()) {
 		header('Cache-Control: no-store, max-age=0');
    }

	// Apply query and echo outcome.
	//
	$result = $conn->query($query);
?>
