<?php
	error_log("[".__FILE__."] Info: Started", 0);

    require_once dirname(__FILE__).'/config.inc';

	error_log("[".__FILE__."] Info: Emitting results", 0);

	error_log("Query: |" . $_SERVER['QUERY_STRING'] . "|", 0);

	if (!headers_sent()) {
		header('Cache-Control: no-store, max-age=0');
    }

    // Retrieve input.
    //
	$segment = $conn->real_escape_string($_SERVER['QUERY_STRING']);

    // Create query.
    //
    $query = "SELECT SegmentName FROM Segments WHERE SegmentName = '$segment'";

    // Apply query and echo outcome.
    //
    $result = $conn->query($query);

	error_log("[".__FILE__."] Info: Emitting results", 0);

	if (!headers_sent()) {
		header('Cache-Control: no-store, max-age=0');
    }

    // If the $result has any rows the username already exists.
    //
	if($result->num_rows > 0) {
		echo "This Frocole Server Exists.";
	} else {
		echo "The Segment does not exists on this Frocole Server.";
	}
?>