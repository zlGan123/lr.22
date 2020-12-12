<?php 
      include 'core/init.php'; 
      logged_in_redirect() ;     

      if(empty($_POST) === false)
      {
            //echo 'Form submitted!' ;
            $required_fields = array('username','password', 'password_again', 'first_name', 'email');
            //echo '<pre>' , print_r($_POST) , '</pre>'; //to preview form vars
            foreach ($_POST as $key => $value) 
            {
                  if(empty($value) && in_array($key, $required_fields) === true)
                  {
                        $errors[] = 'Fields marked with an asterisk are required!' ;
                        break 1;
                  }
            }

            if(empty($errors) === true)
            {
                  if(user_exists($_POST['username']) === true)
                  {
                        $errors[] = 'Sorry, the username \''. $_POST['username'] . '\' is already taken.' ;
                  }

                  if(preg_match("/\\s/", $_POST['username']) == true) //check for space
                  {
                        $errors[] = 'Your username must not contain any space.' ;
                  }

                  if(strlen($_POST['password']) < 6)
                  {
                        $errors[] = 'Your password must be at least 6 characters.' ;
                  }

                  if($_POST['password'] !== $_POST['password_again'] )
                  {
                        $errors[] = 'Your password do not match.' ;
                  }

                  if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false)
                  {
                        $errors[] = 'A valid email address is required.' ;
                  }

                  if(email_exists($_POST['email']) === true)
                  {
                        $errors[] = 'Sorry, the email \''. $_POST['email'] . '\' is already in use.' ;
                  }
            }
      }
      //print_r($errors); // for testing to see the error msg

      if(isset($_GET['success']) && empty($_GET['success']))
      {
include 'includes/overall/overall_header.php'; 
?>
      <h1>Register</h1>

<?php            
            echo 'You have been registered successfully! Please check your email to activate your account.';
      }
      else
      {
            if(empty($_POST) === false && empty($errors) === true)
            {
                  //register user
                  $register_data = array
                  (
                        'username' => $_POST['username'],
                        'password' => $_POST['password'],
                        'first_name' => $_POST['first_name'],
                        'last_name' => $_POST['last_name'],
                        'email' => $_POST['email'],
                        'email_code' => md5($_POST['username'] + microtime())
                  );
                  //print_r($register_data);
      
                  register_user($register_data);
                  header('Location: register.php?success');
                  exit();
            }

include 'includes/overall/overall_header.php'; 
?>
      <h1>Register</h1>

<?php              

            if(empty($errors) === false)
            {
                  echo output_errors($errors);
            }
?>

            <form action="" method="post">
                  <ul>
                        <li>
                              Username*: <br>
                              <input type="text" name="username">
                        </li>
                        <li>
                              Password*: <br>
                              <input type="password" name="password">
                        </li>
                        <li>
                              Password again*: <br>
                              <input type="password" name="password_again">
                        </li>
                        <li>
                              First name*: <br>
                              <input type="text" name="first_name">
                        </li>
                        <li>
                              Last name: <br>
                              <input type="text" name="last_name">
                        </li>
                        <li>
                              Email*: <br>
                              <input type="text" name="email">
                        </li>
                        <li>
                              <input type="submit" value="Register">
                        </li>
                  </ul>
            </form>

<?php 
      }
      include 'includes/overall/overall_footer.php'; 
?>

