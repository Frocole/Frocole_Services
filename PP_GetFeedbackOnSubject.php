<?php
	error_log("[".__FILE__."] Info: Started", 0);

    require_once dirname(__FILE__).'/config.inc';

	// Retrieve input.
	//
	$username = $conn->real_escape_string($_POST["username"]);
	$password = $conn->real_escape_string($_POST["password"]);
	$courseid = $conn->real_escape_string($_POST["courseid"]);
	$subject  = $conn->real_escape_string($_POST["subject"]);

	// Create query.
	//
	$query =
	"
	SELECT t1.*
	FROM feedbackitems t1 INNER JOIN ( SELECT MAX(FeedBackItemID) FeedBackItemID, Parameter FROM feedbackitems GROUP BY Parameter, FeedbackSuplierID, Subject) t2
	ON t1.Parameter = t2.Parameter AND t1.FeedBackItemID = t2.FeedBackItemID
	WHERE `GroupID` =
	(
		SELECT GroupID
		FROM userandcourserelations
		WHERE UserID =
		(
			SELECT users.UserID
			FROM users
			WHERE users.Username = '$username' AND users.Password = '$password'
		)
		AND CourseID = '$courseid'
	)
	AND `Subject` = '$subject'
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
