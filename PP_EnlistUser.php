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
	INSERT INTO UserAndGroupRelations
	(
		UserID,
		GroupID,
		Public
	)
	VALUES
	(
		(
				SELECT UserID From UserAndCourseRelations WHERE UserID = '$userid'
				AND CourseID IN (SELECT CourseID FROM Courses WHERE CourseID = '$courseid'
				AND LeraarUserID = (SELECT UserID FROM Users WHERE Username = '$username'
				AND Password = '$password'))
		),
		'$groupid',
		0
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