<?php
	error_log("[".__FILE__."] Info: Started", 0);

	require_once dirname(__FILE__).'/config.inc';

	// Retrieve input.
	$segment = $conn->real_escape_string($_SERVER['QUERY_STRING']);

	// Create query.
	$query = "
	SELECT infotext
	FROM `infotexten` WHERE SegmentID IN (SELECT SegmentID FROM Segments WHERE SegmentName='$segment')";

	$sth = mysqli_query($conn,$query);

	error_log("[".__FILE__."] Info: Emitting results", 0);

	if (!headers_sent()) {
		header('Cache-Control: no-store, max-age=0');
    }

    //show data for each row
	$rows = array();
	while($r = mysqli_fetch_assoc($sth))
	{
		echo $r["infotext"];
		$rows[] = $r;
	}
?>