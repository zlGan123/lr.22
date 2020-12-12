<?php
include 'core/init.php';
include 'includes/overall/overall_header.php';
?>
<h1>Home</h1>
<p>Just a template.</p>

<?php
if (isset($_SESSION['user_id'])) {
      echo 'Logged in';
} else {
      echo 'Not logged in';
}

if (has_access($session_user_id, 1) === true )  
{
echo ' (Admin!)';
} 
if (has_access($session_user_id, 2) === true)  
{
echo ' (Moderator!)';
}        


include 'includes/overall/overall_footer.php';
?>