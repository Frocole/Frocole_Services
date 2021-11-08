<?php
	error_log("[".__FILE__."] Info: Started", 0);

    require_once dirname(__FILE__).'/config.inc';

    // Retrieve input.
    //
    $username = $conn->real_escape_string($_POST["username"]);

    $segment = $conn->real_escape_string($_SERVER['QUERY_STRING']);

    // Create query.
    //
    $query = "SELECT Username FROM users WHERE Username = '$username' AND SegmentID IN (SELECT SegmentID FROM segments WHERE SegmentName='$segment')";

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
		echo "The name already exists in the database.";
	} else {
		echo "The name does not exist in the database.";
	}
?>
