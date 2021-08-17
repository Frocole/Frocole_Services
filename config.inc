<?php	    
    // Define Frocole Database Name.	
    $db = ""; //ENTER Database Name here

    // Setting develop to true disables some PHP related security checks.
    //
    $develop = true;
  
    // DEBUG SETTINGS.
    // echo ini_get("mysqli.default_host");
    // echo ini_get("mysqli.default_user");
    // echo ini_get("mysqli.default_pw");
    // echo "Database: $db";
    // echo "Developer: $develop";
  
    // Make MYSQLI Connection.
    $conn = new mysqli('host', 'username', 'password'); // ENTER Credentials here

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
?>
