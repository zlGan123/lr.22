<?php 
    include 'core/init.php' ; 
    logged_in_redirect(); //if login prevent to load this page


        if(isset($_GET['success']) && empty($_GET['success']))
        {
            include 'includes/overall/overall_Header.php' ; 
?>
                <h2>Thanks, we've activated your account...</h2>
                <p>You're free to log in!</p>
<?php
            
        } 
        else if(isset($_GET['email'], $_GET['email_code']) === true)
        {
            $email = trim($_GET['email']) ;
            $email_code = trim($_GET['email_code']) ;

            if(email_exists($email) === false)
            {
                $errors[] = 'Oops, something went wrong and we couldn\'t find that email address!';
            }
            else if(activate($email, $email_code) === false)
            {
                $errors[] = 'We have problems activating your account. Try login your account might already been activated.';
            }

            if(empty($errors) === false)
            {
                include 'includes/overall/overall_Header.php' ; 
?>
                    <h2>Oops...</h2>
<?php
                    echo output_errors($errors);
            }
            else
            {
                header('Location: activate.php?success');
                exit();
            }
        }
        else
        {
            header('Location: index.php');
            exit();
        } 
    include 'includes/overall/overall_Footer.php' ; 
?>