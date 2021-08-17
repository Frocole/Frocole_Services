<?php
    require_once dirname(__FILE__).'/config.inc';
          
    // Retrieve input.    
    //
    $username = $conn->real_escape_string($_POST["username"]);
    $password = $conn->real_escape_string($_POST["password"]);
    $nickname = $conn->real_escape_string($_POST["nickname"]);
    
    // Create query.
    //
    $query = "INSERT INTO Users (Username, Password, Nickname) VALUES ('$username','$password','$nickname');";
    
    // Apply query and echo outcome.
    //
    $result = $conn->query($query);
?>