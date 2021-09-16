<?php
	error_log("[".__FILE__."] Info: Started", 0);

	error_log("[".__FILE__."] Info: Emitting results", 0);

	if (!headers_sent()) {
		header('Cache-Control: no-store, max-age=0');
    }

	echo "This Frocole Server Exists.";
?>