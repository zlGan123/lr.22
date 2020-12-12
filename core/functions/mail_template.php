<?php
require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'falcon.awedns.com';  // Specify main and backup SMTP servers 'smtp1.example.com;smtp2.example.com'
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'webfeedback@mygrowtech.com';                 // SMTP username
$mail->Password = 'Mgt888super';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('webfeedback@mygrowtech.com', 'MyGrowtech');
$mail->addAddress('cmgankl@gmail.com', 'Gan');     // Add a recipient  'gan@mygrowtech.com', 'Joe User'
//$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('webfeedback@mygrowtech.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject Mygrowtech';
$mail->Body    = '<h1>I want to fly!!!!</h1>';  //'This is the HTML message body <b>in bold!</b>'
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}

?>