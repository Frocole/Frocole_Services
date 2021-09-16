<?php
	error_log("[".__FILE__."] Info: Started", 0);

	require_once dirname(__FILE__).'/config.inc';

	// Create query.
	$query =
	"
	SELECT infotext
	FROM `infotexten`
	";

	$sth = mysqli_query($conn,$query);

	error_log("[".__FILE__."] Info: Emitting results", 0);

	//show data for each row
	$rows = array();
	while($r = mysqli_fetch_assoc($sth))
	{
		echo $r["infotext"];
		$rows[] = $r;
	}
?>