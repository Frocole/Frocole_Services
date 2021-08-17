<?php
    require_once dirname(__FILE__).'/config.inc';
		
	// Retrieve input.	
	//
	$username = $conn->real_escape_string($_POST["username"]);
	$password = $conn->real_escape_string($_POST["password"]);
	$userid = 	$conn->real_escape_string($_POST["userid"]);
	$groupid = 	$conn->real_escape_string($_POST["groupid"]);
	$courseid = $conn->real_escape_string($_POST["courseid"]);
	
	// Create query.
	//
	$query = "
	DELETE FROM UserAndGroupRelations 
	WHERE UserID = (SELECT UserID From UserAndCourseRelations WHERE UserID = '$userid' 
	AND CourseID IN(SELECT CourseID FROM Courses WHERE CourseID = '$courseid' 
	AND LeraarUserID = (SELECT UserID FROM Users WHERE Username = '$username' AND Password = '$password')))	
	AND 
	GroupID = '$groupid'";
	
	// Apply query and echo outcome.
	//
	$result = $conn->query($query);
?>