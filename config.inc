<?php	    
    // Define Frocole Database Name.
    $settings = parse_ini_file("../../frocole_db.ini", TRUE);

    $db = $settings['database']['schema'];

    // Setting develop to true disables some PHP related security checks.
    //
    $develop = true;
  
    // DEBUG SETTINGS.
    // echo "Database: $db";
    // echo "Developer: $develop";
  
    $a=1;
    
    // Make MYSQLI Connection.
    //
    $conn = new mysqli($settings['database']['host'], $settings['database']['username'], $settings['database']['password'], $db, $settings['database']['port']); // ENTER Credentials and other MySql info here

    // a) Verify MYSQLI connection.    
    //
    if ($conn->connect_errno) 
	{	
        die("Connect failed: $conn->connect_errno.");
    }
  
    // b) Ping MYSQLI server.
    //
    if (!$conn->ping()) {
        die("Ping failed: $conn->errno.");    
    }
   
    // c) Select MYSQLI Database.
    //
    $conn->select_db($db);
    if ($conn->errno) {
        die("Select Database failed: $conn->errno.");    
    }
  
    // d) Perform some PHP related security checks.
    //
    if (!$develop) {
  
        // 1) Check if the function 'phpinfo() is disabled to prevent leaking credentials.
        //
        $disabled = explode(',', ini_get('disable_functions'));
        if (!in_array('phpinfo', $disabled)) {
            trigger_error("The PHP function 'phpinfo()' is enabled", E_USER_WARNING);      
        }
  
        // 2) Check 'display_errors' value to prevent leaking credentials.
        //
        if (ini_get("display_errors")==true) 
		{
            trigger_error("The PHP setting 'display_errors' is enabled", E_USER_WARNING);
        }

        // 3) Check that PHP does not emit it's version number.
        //
        if (ini_get("expose_php")==true) {
            trigger_error("The PHP setting 'expose_php' is enabled", E_USER_WARNING);
        }
    }
    
    if (!headers_sent()) {
	// header('Cache-Control: no-store, max-age=0');
	header('Access-Control-Allow-Method: POST');
	header('Access-Control-Allow-Origin: *');
    }
    
?>
