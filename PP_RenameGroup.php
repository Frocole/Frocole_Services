<?php
    require_once dirname(__FILE__).'/config.inc';

	// Retrieve input.
	//
	$username = 		$conn->real_escape_string($_POST["username"]);
	$password = 		$conn->real_escape_string($_POST["password"]);
	$groupid = 			$conn->real_escape_string($_POST["groupid"]);
	$courseid = 		$conn->real_escape_string($_POST["courseid"]);
	$groupnickname = 	$conn->real_escape_string($_POST["groupnickname"]);
	
	// Create query.
	//
	$query = "
	UPDATE Groups
	SET GroupNickname = '$groupnickname'
	WHERE 
	GroupID = $groupid
	AND
	CourseID =	
	(
		SELECT CourseID 
		FROM Courses
		WHERE CourseID = $courseid 
		AND LeraarUserID = 
		(
			SELECT UserID 
			FROM Users 
			WHERE Username = '$username' 
			AND Password = '$password'
		)	
	)
	";

	// Apply query and echo outcome.
	//
	$result = $conn->query($query);
?>