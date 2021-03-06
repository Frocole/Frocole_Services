<?php
	error_log("[".__FILE__."] Info: Started", 0);

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
	DELETE FROM userandgrouprelations
	WHERE UserID = (SELECT UserID From userandcourserelations WHERE UserID = '$userid'
	AND CourseID IN(SELECT CourseID FROM courses WHERE CourseID = '$courseid'
	AND LeraarUserID = (SELECT UserID FROM users WHERE Username = '$username' AND Password = '$password')))
	AND
	GroupID = '$groupid'";

	error_log("[".__FILE__."] Info: Emitting results", 0);

	if (!headers_sent()) {
		header('Cache-Control: no-store, max-age=0');
    }

	// Apply query and echo outcome.
	//
	$result = $conn->query($query);
?>
