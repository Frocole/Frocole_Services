<?php
require_once dirname(__FILE__).'/config.inc';
	
// Create query.
	$query = 
	"	
	SELECT infotext 
	FROM `infotexten` 	
	";
	
	$sth = mysqli_query($conn,$query);	
	
//show data for each row
	
	$rows = array();
	while($r = mysqli_fetch_assoc($sth)) 
	{
		echo $r["infotext"];
		$rows[] = $r;
	}
	//print json_encode($rows);
	//echo $rows["infotext"];
?>