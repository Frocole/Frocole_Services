<?php
	error_log("[".__FILE__."] Info: Started", 0);

	require_once dirname(__FILE__).'/config.inc';

	// Retrieve input.
	//
	$username = $conn->real_escape_string($_POST["username"]);
	$password = $conn->real_escape_string($_POST["password"]);

	// Create query.
	//
	$query =
	"
	SELECT *
	FROM courses
	WHERE CourseID IN
		(
			SELECT userandcourserelations.CourseID
			FROM userandcourserelations
			WHERE userandcourserelations.UserID =
			(
				SELECT users.UserID
				FROM users
				WHERE users.Username = '$username' AND users.Password = '$password'
			)
		)
		AND courses.CourseActive = 1
	";

	$sth = $conn->query($query);

	// Show data for each row.
	//
	$rows = array();
	while($r = $sth->fetch_assoc())
	{
		$rows[] = $r;
	}

	if (!headers_sent()) {
 		header('Cache-Control: no-store, max-age=0');
    	header('Content-Type: application/json');
    }

	error_log("[".__FILE__."] Info: Emitting results", 0);

	print json_encode($rows);
?>
