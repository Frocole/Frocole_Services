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
	SELECT users.UserID, users.Nickname
	FROM users
	WHERE
	NOT users.UserID IN
	(
		SELECT UserID
		FROM userandgrouprelations
		WHERE
		GroupID IN
		(
			SELECT GroupID
			FROM $db.groups
			WHERE CourseID = '$courseid'
		)
	)
	AND users.UserID IN
	(
		SELECT UserID
		FROM userandcourserelations
		WHERE CourseID =
		(
			SELECT CourseID
			FROM courses
			WHERE CourseID = '$courseid' AND LeraarUserID =
			(
				SELECT UserID
				FROM users
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
