<?php
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
	select t1.* 
	from FeedBackItems t1 inner join ( select max(FeedBackItemID) FeedBackItemID, Parameter from FeedBackItems group by Parameter, FeedbackSuplierID, Subject) t2 
	on t1.Parameter = t2.Parameter and t1.FeedBackItemID = t2.FeedBackItemID 
	WHERE `GroupID` = 
	(
		SELECT GroupID 
		FROM UserAndCourseRelations
		WHERE UserID = 
		(
			SELECT Users.UserID 
			FROM Users 	
			WHERE Users.Username = '$username' AND Users.Password = '$password'
		)	
		AND CourseID = '$courseid'
	)
	AND `Subject` = '$subject'
	"
	;
	
	$sth = $conn->query($query);	
	
	// Show data for each row.
	//
	$rows = array();
	while($r = $sth->fetch_assoc()) 
	{
		$rows[] = $r;
	}

	print json_encode($rows);
?>