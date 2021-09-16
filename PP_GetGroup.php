<?php
	error_log("[".__FILE__."] Info: Started", 0);

    require_once dirname(__FILE__).'/config.inc';

	$username = $conn->real_escape_string($_POST["username"]);
	$password = $conn->real_escape_string($_POST["password"]);
	$courseid = $conn->real_escape_string($_POST["courseid"]);

	// Create query.
	//
	$query = "
	SELECT $db.Groups.GroupID, $db.Groups.GroupNickname, $db.Groups.CourseID, UserAndGroupRelations.Public
	FROM $db.Groups
	INNER JOIN UserAndGroupRelations ON $db.Groups.GroupID = UserAndGroupRelations.GroupID
	WHERE CourseID = '$courseid'
	AND UserAndGroupRelations.USERID =
	(
        SELECT UserID
        FROM Users
        WHERE Username = '$username'
        AND Password = '$password'
	)";

	$sth = $conn->query($query);

	// Show data for each row.
	//
	$rows = array();
	while($r = $sth->fetch_assoc())
	{
		$rows[] = $r;
	}

	if (!headers_sent()) {
    	header('Content-Type: application/json');
    }

	error_log("[".__FILE__."] Info: Emitting results", 0);

	print json_encode($rows);
?>