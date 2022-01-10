<?php
	error_log("[".__FILE__."] Info: Started", 0);

    require_once dirname(__FILE__).'/config.inc';

    // Retrieve input.
    //
    $username = 	$conn->real_escape_string($_POST["username"]);
    $password = 	$conn->real_escape_string($_POST["password"]);
    $groupid = 		$conn->real_escape_string($_POST["groupid"]);
    $courseid = 	$conn->real_escape_string($_POST["courseid"]);

	// Create query.
	//
    $query =
    "
	SELECT users.UserID, users.Nickname, userandgrouprelations.Public
	FROM users
	INNER JOIN userandgrouprelations ON users.UserID = userandgrouprelations.UserID
	WHERE
	userandgrouprelations.GroupID = '$groupid'
	AND users.UserID IN
		(
			SELECT userandgrouprelations.UserID
			FROM userandgrouprelations
			WHERE
			userandgrouprelations.GroupID = '$groupid'
			AND
			(
				userandgrouprelations.GroupID IN
				(
					SELECT userandgrouprelations.GroupID
					FROM userandgrouprelations
					WHERE userandgrouprelations.UserID =
					(
						SELECT users.UserID
						FROM users
						WHERE users.Username = '$username' AND users.Password = '$password'
					)
				)
				OR
				userandgrouprelations.GroupID IN
				(
					SELECT GroupID
					FROM $db.groups
					WHERE CourseID IN
					(
						SELECT CourseID
						FROM courses
							WHERE CourseID = '$courseid'
							AND LeraarUserID =
							(
								SELECT users.UserID
								FROM users
								WHERE users.Username = '$username' AND users.Password = '$password'
							)
					)
				)
			)

		)
		AND
		Users.UserID IN
		(
			SELECT UserAndCourseRelations.UserID
			FROM UserAndCourseRelations
			WHERE UserAndCourseRelations.CourseID = '$courseid'
		)
		AND NOT Users.UserID =
		(
			SELECT LeraarUserID
			FROM Courses
			WHERE CourseID = '$courseid'
		)
	";

    $sth = $conn->query($query);

	// Show data for each row.
    //
    $rows = array();

    if ($sth) {
		while($r = $sth->fetch_assoc())
		{
			$rows[] = $r;
		}
    }
	error_log("[".__FILE__."] Info: Emitting results", 0);

	if (!headers_sent()) {
 		header('Cache-Control: no-store, max-age=0');
    	header('Content-Type: application/json');
    }

    print json_encode($rows);
?>
