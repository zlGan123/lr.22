<?php 
include 'core/init.php'; 
protect_page(); // to prevent access without log in
include 'includes/overall/overall_header.php'; 
?>
    <h1>Change Password</h1>
<?php  


if(empty($_POST) === false)
{
    $required_fields = array('current_password', 'password','password_again');
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
          if(md5($_POST['current_password']) === $user_data['password'])
          {
            if(trim($_POST['password']) !== trim($_POST['password_again']))
            {
                $errors[] = 'Your password do not match!' ;
            }
            elseif(strlen($_POST['password']) < 6)
            {
                $errors[] = 'Your password must at least 6 characters.' ;
            }
          }
          else
          {
            $errors[] = 'Your current password is incorrect!' ;
          }
    }

    //print_r($errors);
}
    if(isset($_GET['success']) === true && empty($_GET['success']) === true)
    {
      
        echo 'Your password has been changed.' ;
    }
    else
    {

        if(empty($_POST) === false && empty($errors) === true)
        {
            //post the form and no error
            change_password($session_user_id, $_POST['password']);
            header('Location: changepassword.php?success');
            exit();
        }

    if(isset($_GET['force']) === true && empty($_GET['force']) === true)
    {
?>
        <p>You must change your password now that you've requested!</p>
<?php
    }
    
    if(empty($errors) === false)
    {
        //output error
        echo output_errors($errors);
    }
?>
        <form action="" method="post">
            <ul>
                <li>
                        Current Password*: <br>
                        <input type="password" name="current_password">
                </li>
                <li>
                        New Password*: <br>
                        <input type="password" name="password">
                </li>
                <li>
                        New Password again*: <br>
                        <input type="password" name="password_again">
                </li>
                <li>
                        <input type="submit" value="Change password">
                </li>
            </ul>
        </form>

<?php 
    }
include 'includes/overall/overall_footer.php'; 
?>

