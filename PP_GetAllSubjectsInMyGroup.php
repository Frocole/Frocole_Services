<?php
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
	SELECT Users.UserID, Users.Nickname, UserAndGroupRelations.Public 
	FROM Users 	
	INNER JOIN UserAndGroupRelations ON Users.UserID = UserAndGroupRelations.UserID
	WHERE 
	UserAndGroupRelations.GroupID = '$groupid'
	AND Users.UserID IN 
		(	
			SELECT UserAndGroupRelations.UserID
			FROM UserAndGroupRelations
			WHERE 
			UserAndGroupRelations.GroupID = '$groupid'
			AND
			(
				UserAndGroupRelations.GroupID IN 
				(
					SELECT UserAndGroupRelations.GroupID
					FROM UserAndGroupRelations
					WHERE UserAndGroupRelations.UserID =
					(
						SELECT Users.UserID 
						FROM Users 	
						WHERE Users.Username = '$username' AND Users.Password = '$password'
					)
				)
				OR 
				UserAndGroupRelations.GroupID IN 
				(
					SELECT GroupID 
					FROM Groups
					WHERE CourseID IN 
					(
						SELECT CourseID
						FROM Courses
							WHERE CourseID = '$courseid'
							AND LeraarUserID = 
							(
								SELECT Users.UserID 
								FROM Users 	
								WHERE Users.Username = '$username' AND Users.Password = '$password'
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
	while($r = $sth->fetch_assoc()) 
	{
    	$rows[] = $r;
	}

    print json_encode($rows);
?>