<?php
	error_log("[".__FILE__."] Info: Started", 0);

    require_once dirname(__FILE__).'/config.inc';

	error_log("[".__FILE__."] Info: Emitting results", 0);

	if (!headers_sent()) {
		header('Cache-Control: no-store, max-age=0');
    }

    echo "The Frocole Database Exists.";
?>