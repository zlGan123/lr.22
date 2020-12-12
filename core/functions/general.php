<?php

    function email($to, $subject, $body)
    {
        // mail($to, $subject, $body, "From: hello@phpacademy.org");

        if($to !== 'hello@phpacademy.org')  //prevent email back to email account
        {
            //require 'PHPMailer/PHPMailerAutoload.php';
            $mail = new PHPMailer;
            //global $mail;

            //$mail->SMTPDebug = 3;                               // Enable verbose debug output

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'falcon.awedns.com';  // Specify main and backup SMTP servers 'smtp1.example.com;smtp2.example.com'
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'webfeedback@mygrowtech.com';                 // SMTP username
            $mail->Password = 'Mgt888super';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            $mail->setFrom('hello@phpacademy.org', 'PhpMyAcademy');
            $mail->addAddress($to);     // Add a recipient  'gan@mygrowtech.com', 'Joe User'
            //$mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo('hello@phpacademy.org', 'Support');
            //$mail->addCC('cc@example.com');
            $mail->addBCC('hello@phpacademy.org');

            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            //$mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = $subject ;
            $mail->Body = $body ;  //'This is the HTML message body <b>in bold!</b>'
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if(!$mail->send()) {
                $errors[] = "Message could not be sent. /n" . " Mailer Error: " . $mail->ErrorInfo;
            } else {
                $errors[] = 'Message has been sent!';
            } 
        }
    
    }
    
    function logged_in_redirect()
    {
        if(logged_inYN() === true)
        {
            header('Location: index.php') ;
            exit();
        }
    }

    function protect_page()
    {
        if(logged_inYN() === false)
        {
            header('Location: protected.php') ;
            exit();
        }
    }

    function admin_protect()
    {
        global $user_data ;
        if(has_access($user_data['user_id'], 1) === false)
        {
            header('Location: index.php') ;
            exit();
        }
    }    

    function moderator_protect()
    {
        global $user_data ;
        if(has_access($user_data['user_id'], 1) === true)
        {

        }
        elseif(has_access($user_data['user_id'], 2) === true)
        {

        }
        else
        {
            header('Location: index.php') ;
            exit();
        }
    }  

    function array_sanitize(&$item)
    {
        global $con ;
        $item = htmlentities(strip_tags(mysqli_real_escape_string($con, $item)));       
    }

    function sanitize($data)
    {
        global $con ;
        return  htmlentities(strip_tags(mysqli_real_escape_string($con, $data)));    
    }

    function output_errors($errors)
    {
        $output = array();
        foreach ($errors as $error) 
        {
            $output[] = '<li>' . $error . '</li>' ;
        }
        return '<ul>' . implode('', $output) . '</ul>';
    }

?>