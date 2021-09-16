<?php
	error_log("[".__FILE__."] Info: Started", 0);

    require_once dirname(__FILE__).'/config.inc';

	// Retrieve input.
	//
	$username = 	$conn->real_escape_string($_POST["username"]);
	$password = 	$conn->real_escape_string($_POST["password"]);
	//$groupid = 		$conn->real_escape_string($_POST["groupid"]);
	$courseid = 	$conn->real_escape_string($_POST["courseid"]);

	// Create query.
	//
	$query =
	"
	SELECT Users.UserID, Users.Nickname
	FROM Users
	WHERE
	NOT Users.UserID IN
	(
		SELECT UserID
		FROM UserAndGroupRelations
		WHERE
		GroupID IN
		(
			SELECT GroupID
			FROM $db.Groups
			WHERE CourseID = '$courseid'
		)
	)
	AND Users.UserID IN
	(
		SELECT UserID
		FROM UserAndCourseRelations
		WHERE CourseID =
		(
			SELECT CourseID
			FROM Courses
			WHERE CourseID = '$courseid' AND LeraarUserID =
			(
				SELECT UserID
				FROM Users
				WHERE Username = '$username'
				AND Password = '$password'
			)
		)
	)
	";

	$sth = $conn->query($query);

	// Show data for each row.
	//
	$rows = array();
	while($r = $sth->fetch_assoc())
	{
		$rows[] = $r;
	}

	error_log("[".__FILE__."] Info: Emitting results", 0);

	if (!headers_sent()) {
 		header('Cache-Control: no-store, max-age=0');
    	header('Content-Type: application/json');
    }

    print json_encode($rows);
?>