<?php
  function change_profile_image($user_id, $file_temp, $file_extn, $file_to_replace)
  {
    $file_path = 'images/profile/' . substr(md5(time()), 0, 10) . '.' . $file_extn ;
    move_uploaded_file($file_temp, $file_path);

    if(file_exists($file_to_replace) === true)
    {
      //remove old file
      if (is_file($file_to_replace))
      {
        unlink($file_to_replace);
      }
    }

    $querystr = "UPDATE `users` SET `profile` = '$file_path' WHERE `user_id` = $user_id" ;
    //For New mysqli
    global $con ;
    if ($query = mysqli_query($con, $querystr)) 
    {
      //mysqli_free_result($query);   
    }
  }

  function mail_users($subject, $body)
  {
    $querystr = "SELECT `email`, `first_name` FROM `users` WHERE `allow_email` = 1" ;
      //For New mysqli
      global $con ;
      if ($query = mysqli_query($con, $querystr)) 
      {
        // Associative array
        while (($row = mysqli_fetch_assoc($query)) !== false && empty($row['email']) === false)
        {
            email($row['email'], $subject, "Hello " . $row['first_name'] . ",\n\n" . $body);
        }
        mysqli_free_result($query);   
      }
  }

  function has_access($user_id, $type)
  {
    $user_id = (int)$user_id;
    $type = (int)$type;
      //For New mysqli
      global $con ;
      $querystr = "SELECT COUNT(`user_id`) AS `num` FROM `users` WHERE `user_id` = $user_id AND `type` = $type" ;
      if ($result = mysqli_query($con, $querystr)) 
      {
        // Associative array
        $num = mysqli_fetch_assoc($result);
        //echo 'Total count:' . $num['num'];
        // Free or clear result set
        mysqli_free_result($result);
        return ($num['num'] == 1) ? true : false;      
      }
  }

  function recover($mode, $email)
  {
    $mode = sanitize($mode);
    $email = sanitize($email);

    $user_data = user_data(user_id_from_email($email), 'user_id', 'first_name', 'username');
    if($mode == 'username')
    {
      email($email, 'your username', "Hello "
      . $user_data['first_name']
      . ",\n\nYour username is:"
      . $user_data['username']
      . "\n\n-phpmyacademy"
      );
    }
    elseif($mode == 'password')
    {
      $generated_password = substr(md5(rand(999,999999)), 0, 8) ;
      change_password($user_data['user_id'], $generated_password);

      //force user change password, optional
      update_user($user_data['user_id'], array('password_recover' => '1'));

      email($email, 'Your password recovery', "Hello "
      . $user_data['first_name']
      . ",\n\nYour new password is:"
      . $generated_password
      . "\n\n-phpmyacademy"
      );
    }
  }

  function activate($email, $email_code)
  {
    $email = sanitize($email);
    $email_code = sanitize($email_code);

      //For New mysqli
      global $con ;
      $querystr = "SELECT COUNT(`user_id`) AS `num` FROM `users` WHERE `email` = '$email' 
                    AND `email_code` = '$email_code' 
                    AND `active` = 0";
      $querystr2 = "UPDATE `users` SET `active` = 1 WHERE `email` = '$email'";              
      if ($result = mysqli_query($con, $querystr)) 
      {
        // Associative array
        $num = mysqli_fetch_assoc($result);
        //echo 'Total count:' . $num['num'];
        // Free or clear result set
        mysqli_free_result($result);
        //return $num['num'];
      }

      if($num['num'] == 1)
      {
        mysqli_query($con, $querystr2);
        return true;
      }
      else
      {
        return false;
      }
  }

  function change_password($user_id, $password)
  {
    $user_id = (int)$user_id ;
    $password = md5($password);

    $querystr = "UPDATE `users` SET `password` = '$password', `password_recover` = 0 WHERE `user_id` = $user_id" ;
      //For New mysqli
      global $con ;
      mysqli_query($con, $querystr);
  }

  function update_user($user_id, $update_data)
  {
    $update = array();
    array_walk($update_data, 'array_sanitize');

    foreach($update_data as $field => $data)
    {
      $update[] = '`' . $field . '` = \'' . $data . '\'';
    }

    $querystr = "UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` = $user_id" ;
      //For New mysqli
      global $con ;
      mysqli_query($con, $querystr);

  }

  function register_user($register_data)
  {
    array_walk($register_data, 'array_sanitize');
    $register_data['password'] = md5($register_data['password']);
    $fields = '`' . implode('`, `', array_keys($register_data)) . '`' ;
    $data = '\'' . implode('\', \'', $register_data) . '\'' ;
    //echo $fields ;
    //print_r($register_data);
 
    $querystr = "INSERT INTO `users` ($fields) VALUES ($data)" ;
      //For New mysqli
      global $con ;
      mysqli_query($con, $querystr);

      //send email
  global $activate_email_address ;
  email($register_data['email'], 'Activate your account', "Hello " . $register_data['first_name'] . ", \n\n You need to activate your account, so use the link below: \n\n http://localhost/lr.22/activate.php?email=" . $register_data['email'] . "&email_code=" . $register_data['email_code'] . " \n\n - phpacademy.org");

  }

  function user_count()
  {
      //For New mysqli
      global $con ;
      $querystr = "SELECT COUNT(`user_id`) AS `num` FROM `users` WHERE `active` = 1" ;
      if ($result = mysqli_query($con, $querystr)) 
      {
        // Associative array
        $num = mysqli_fetch_assoc($result);
        //echo 'Total count:' . $num['num'];
        // Free or clear result set
        mysqli_free_result($result);
        return $num['num'];
      }
  }

  function user_data($user_id)
  {
    $data = array();
    $user_id = (int)$user_id;

    $func_num_args = func_num_args();
    //echo $func_num_args ;
    $func_get_args = func_get_args();
    //print_r($func_get_args);

    if($func_num_args > 1)
    {
      unset($func_get_args[0]);
      $field = '`' . implode('`, `', $func_get_args) . '`' ;
      $querystr = "SELECT $field FROM `users` WHERE `user_id` = $user_id" ;
      //echo $querystr ;
        //For New mysqli
        global $con ;
        if ($result = mysqli_query($con, $querystr)) 
        {
          // Associative array
          $data = mysqli_fetch_assoc($result);
          //print_r($data);
          //die();
          mysqli_free_result($result);
          
          return $data;
        }
      
    }


  }

  function logged_inYN()
  {
    return (isset($_SESSION['user_id'])) ? true : false ;
  }

  function user_exists($username)
  {
      ///For New mysqli 
      global $con ;
      $username = mysqli_real_escape_string( $con ,$username); //clean data to avoid scribt
      if ($result = mysqli_query($con, "SELECT COUNT(`user_id`) AS `num` FROM `users` WHERE `username` = '$username'")) 
      {
        // Associative array
        $num = mysqli_fetch_assoc($result);
        //echo 'Total count:' . $num['num'];
        // Free or clear result set
        mysqli_free_result($result);
      }
      return ($num['num'] == 1) ? true : false;    
  }
 
  function email_exists($email)
  {
      ///For New mysqli
      global $con ;
      $email = mysqli_real_escape_string( $con ,$email); //clean data to avoid scribt
      if ($result = mysqli_query($con, "SELECT COUNT(`user_id`) AS `num` FROM `users` WHERE `email` = '$email'")) 
      {
        // Associative array
        $num = mysqli_fetch_assoc($result);
        //echo 'Total count:' . $num['num'];
        // Free or clear result set
        mysqli_free_result($result);
      }
      return ($num['num'] == 1) ? true : false;    
  }

  function user_active($username)
  {
      ///For New mysqli
      global $con ;
      $username = mysqli_real_escape_string( $con ,$username); //clean data to avoid scribt
      if ($result = mysqli_query($con, "SELECT COUNT(`user_id`) AS `num` FROM `users` WHERE `username` = '$username' AND `active` = 1")) 
      {
        // Associative array
        $num = mysqli_fetch_assoc($result);
        //echo 'Total count:' . $num['num'];
        // Free or clear result set
        mysqli_free_result($result);
      }
      return ($num['num'] == 1) ? true : false;     
  }

  function user_id_from_username($username)
  {
    $username = sanitize($username) ; //clean data to avoid scribt
      ///For New mysqli
      global $con ;
      if ($result = mysqli_query($con, "SELECT `user_id` FROM `users` WHERE `username` = '$username'")) 
      {
        // Associative array
        $num = mysqli_fetch_assoc($result);
        //echo 'Total count:' . $num['num'];
        // Free or clear result set
        mysqli_free_result($result);
      }
      return $num['user_id'];    
  }    

  function user_id_from_email($email)
  {
    $email = sanitize($email) ; //clean data to avoid scribt
      ///For New mysqli
      global $con ;
      if ($result = mysqli_query($con, "SELECT `user_id` FROM `users` WHERE `email` = '$email'")) 
      {
        // Associative array
        $num = mysqli_fetch_assoc($result);
        //echo 'Total count:' . $num['num'];
        // Free or clear result set
        mysqli_free_result($result);
      }
      return $num['user_id'];   
  }    

  function login($username, $password)
  {
    $user_id = user_id_from_username($username);
    $password = md5($password);

      ///For New mysqli
      global $con ;
      $username = mysqli_real_escape_string( $con ,$username); //clean data to avoid scribt
      if ($result = mysqli_query($con, "SELECT COUNT(`user_id`) AS `num` FROM `users` WHERE `username` = '$username' AND `password` = '$password'")) 
      {
        // Associative array
        $num = mysqli_fetch_assoc($result);
        //echo 'Total count:' . $num['num'];
        // Free or clear result set
        mysqli_free_result($result);
      }
      return ($num['num'] == 1) ? $user_id : false;    
  }   

?>