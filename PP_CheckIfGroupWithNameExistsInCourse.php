<?php
    require_once dirname(__FILE__).'/config.inc';
	
	// Retrieve input.	
	//
	$username = $conn->real_escape_string($_POST["username"]);
	$password = $conn->real_escape_string($_POST["password"]);
	$courseid = $conn->real_escape_string($_POST["courseid"]);
	$groupnickname = $conn->real_escape_string($_POST["groupnickname"]);
	
	// Create query.
	//
	$query = "SELECT * FROM $db.Groups 
	WHERE GroupNickname = '$groupnickname' AND
	CourseID = 
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
	)";
	
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