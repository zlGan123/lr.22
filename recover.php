<?php
include 'core/init.php';
logged_in_redirect();
include 'includes/overall/overall_header.php';

?>
<h1>Recover</h1>
<?php

if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
    ?>
        <p>Thanks, we have emailed you.</p>
    <?php
} 
else 
{
    $mode_allowed = array('username', 'password');
    if (isset($_GET['mode']) === true && in_array($_GET['mode'], $mode_allowed) === true) {
        if (isset($_POST['email']) === true && empty($_POST['email']) === false) 
        {
            if (email_exists($_POST['email']) === true) {
                recover($_GET['mode'], $_POST['email']);
                header('Location: recover.php?success');
                exit();
            } 
            else 
            {
                ?>
                    <p>Oops, we couldn\'t find that email address!</p> 
                <?php
            }
        } 

        ?>
        <form action="" method="post">
            <ul>
                <li>
                    Please enter your email address: <br>
                    <input type="text" name="email">
                </li>
                <li>
                    <input type="submit" value="Recover">
                </li>
            </ul>
        </form>
<?php
    } else {
        header('Location: index.php');
        exit();
    }
}
include 'includes/overall/overall_footer.php';
?>