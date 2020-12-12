<?php
    session_start();
    //error_reporting(0); // to off error reporting
    require 'database/connect.php' ;
    require 'functions/users.php' ;
    require 'functions/general.php' ;    
    require 'functions/PHPMailer/PHPMailerAutoload.php';


    $current_file = explode('/', $_SERVER['SCRIPT_NAME']); //get the page name into array
    $current_file = end($current_file); //get the value of the last array
    //print_r($current_file);
    $session_user_id = -1 ;

    if(logged_inYN() === true)
    {
        $session_user_id = $_SESSION['user_id'] ;
        $user_data = user_data($session_user_id, 'user_id', 'username', 'password', 'first_name', 'last_name', 'email', 'active', 'password_recover', 'type', 'allow_email', 'profile');
 
        //print_r($user_data);
        //echo $user_data['first_name'] ;
        if(user_active($user_data['username']) === false)
        {
            session_destroy();
            header('Location: index.php') ;
            exit();
        }

        if($current_file !== 'changepassword.php' && $current_file !== 'logout.php' && $user_data['password_recover'] == 1)
        {
            header('Location: changepassword.php?force');
            exit();
        }
    }

    $errors = array(); 
?>    
