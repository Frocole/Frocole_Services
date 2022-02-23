<?php
	error_log("[".__FILE__."] Info: Started", 0);

    require_once dirname(__FILE__).'/config.inc';

	// Retrieve input.
	//
	$username = $conn->real_escape_string($_POST["username"]);
	$password = $conn->real_escape_string($_POST["password"]);
	$courseid = $conn->real_escape_string($_POST["courseid"]);

	// Create query.
	//
	$query =
	"
	SELECT t1.*
	FROM feedbackitems t1 INNER JOIN
	(
		SELECT MAX(FeedBackItemID)FeedBackItemID,
		Parameter FROM feedbackitems GROUP BY Parameter, FeedbackSuplierID, Subject
	)
	t2 ON t1.Parameter = t2.Parameter AND t1.FeedBackItemID = t2.FeedBackItemID

	WHERE `GroupID` =
	(
		SELECT GroupID FROM $db.groups WHERE $db.groups.GroupID in
				(
					SELECT GroupID FROM userandgrouprelations WHERE UserID =
					(
						SELECT users.UserID
						FROM users
						WHERE users.Username = '$username' AND users.Password = '$password'
					)
				)
		AND $db.groups.CourseID = '$courseid'
	)

	AND
	(
		`Subject` =
		(
			SELECT users.UserID FROM users WHERE users.Username = '$username' AND users.Password = '$password'
		)
		OR `Subject` =
		CONCAT
		(
			'GPF',
			(
				SELECT GroupID FROM $db.groups WHERE $db.groups.GroupID IN
				(
					SELECT GroupID FROM userandgrouprelations WHERE UserID =
					(
						SELECT users.UserID
						FROM users
						WHERE users.Username = '$username' AND users.Password = '$password'
					)
				)
				AND $db.groups.CourseID = '$courseid'
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
