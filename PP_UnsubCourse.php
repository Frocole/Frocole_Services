<?php
    require_once dirname(__FILE__).'/config.inc';

	// Retrieve input.	
	//
	$username = $conn->real_escape_string($_POST["username"]);
	$password = $conn->real_escape_string($_POST["password"]);
	$courseid = $conn->real_escape_string($_POST["courseid"]);
	
	// Create query.
	//
	$query = "DELETE FROM UserAndCourseRelations 
	WHERE 
	UserID = (SELECT UserID FROM Users WHERE Users.Username = '$username' AND Users.Password = '$password')	
	AND 
	CourseID = '$courseid'";
	
	// Apply query and echo outcome.
	//
	$result = $conn->query($query);
?>