<?php
    require_once dirname(__FILE__).'/config.inc';
    
	// Retrieve input.    
    //$userid = $conn->real_escape_string($_POST["userid"]);
    //$username = $conn->real_escape_string($_POST["username"]);
    //$password = $conn->real_escape_string($_POST["password"]);
    
	// Create query.
    $query = 
    "	
	SELECT * 
	FROM Courses 	
	WHERE Courses.CourseActive = '1'
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