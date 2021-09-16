<?php
	error_log("[".__FILE__."] Info: Started", 0);

    require_once dirname(__FILE__).'/config.inc';

	// 	Retrieve input.
	//
	$username = 		$conn->real_escape_string($_POST["username"]);
	$password = 		$conn->real_escape_string($_POST["password"]);
	//$nickname = 		$conn->real_escape_string($_POST["nickname"]);
	$courseid = 		$conn->real_escape_string($_POST["courseid"]);
	//$subject  = 		$conn->real_escape_string($_POST["subject"]);
	//$groupnickname = 	$conn->real_escape_string($_POST["groupnickname"]);
	//$userid = 			$conn->real_escape_string($_POST["userid"]);
	//$groupid = 			$conn->real_escape_string($_POST["groupid"]);
	//$parameter = 		$conn->real_escape_string($_POST["parameter"]);
	//$score = 			$conn->real_escape_string($_POST["score"]);

	// 	Create query.
	//
	$query = "INSERT INTO UserAndCourseRelations (UserID, CourseID) VALUES (
	(SELECT UserID FROM Users WHERE Users.Username = '$username' AND Users.Password = '$password')
	,'$courseid');";

	error_log("[".__FILE__."] Info: Emitting results", 0);

	// Apply query and echo outcome.
	//
	$result = $conn->query($query);
?>