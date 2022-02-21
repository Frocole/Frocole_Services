<?php
	error_log("[".__FILE__."] Info: Started", 0);

    require_once dirname(__FILE__).'/config.inc';

	// Retrieve input.
	//
	$username = 		$conn->real_escape_string($_POST["username"]);
	$password = 		$conn->real_escape_string($_POST["password"]);
	$courseid = 		$conn->real_escape_string($_POST["courseid"]);
	$paguidelineid = 		$conn->real_escape_string($_POST["paguidelineid"]);
	$subjecttype  = 	$conn->real_escape_string($_POST["subjecttype"]);
	$parameter = 		$conn->real_escape_string($_POST["parameter"]);
	$delta = 			$conn->real_escape_string($_POST["delta"]);
	$advice = 			$conn->real_escape_string($_POST["advice"]);


	// Create query.
	//
	$query = "
	UPDATE paguidelines
	SET 
	`SubjectType` = '$subjecttype', 
	`Parameter` = '$parameter', 
	`Delta` = '$delta', 
	`Advice` = '$advice'
	Where CourseID =
	(
		SELECT CourseID
		FROM courses
		WHERE CourseID = '$courseid' 
		AND LeraarUserID =
		(
			SELECT UserID
			FROM users
			WHERE Username = '$username'
			AND Password = '$password'
		)
	)
	AND 
	PAGuidelineID = '$paguidelineid'
	";

	error_log("[".__FILE__."] Info: Emitting results", 0);

	if (!headers_sent()) {
		header('Cache-Control: no-store, max-age=0');
    }

	// Apply query and echo outcome.
	//
	$result = $conn->query($query);
?>
