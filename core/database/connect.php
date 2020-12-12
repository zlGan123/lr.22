<?php

    $host = "localhost";
    $username = "root";
    $passwd = "";
    $dbname = 'lr.2';
    
    // Create connection
    $conn = new mysqli($host, $username, $passwd, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    // echo "Connected successfully";

    $connect_error = 'Sorrry, we\'re experiencing connection problems.';
    $connectdb_error = 'Sorrry, we\'re experiencing DB connection problems.';

    //Creating a connection
    $con = mysqli_connect($host, $username, $passwd, $dbname);
    if ($con) {
        //print("Connection Established Successfully");
        //check users table exist?
        if(mysqli_num_rows(mysqli_query($con,"SHOW TABLES LIKE 'tusers'"))) 
        {
            //users table exist
        } 
        else 
        {
            //create userstable if not exist.
            // sql to create table
            $sql = "CREATE TABLE users (
            user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(32) NOT NULL,
            password VARCHAR(32) NOT NULL,
            first_name VARCHAR(32) NOT NULL,
            last_name VARCHAR(32) NOT NULL,
            email VARCHAR(1024) NOT NULL,
            email_code VARCHAR(32) NOT NULL,
            active INT(6) DEFAULT 0,
            password_recover INT(6) DEFAULT 0,
            type INT(6) DEFAULT 0,
            allow_email INT(6) DEFAULT 1,
            profile VARCHAR(32) NOT NULL,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
            
            if (mysqli_query($con, $sql)) 
            {
                //echo "Table tusers created successfully";
            } 
            else 
            {
                //echo "Error creating table: " . mysqli_error($con);
            }
        }
    } 
    else 
    {
        print($connect_error);
    }
?>