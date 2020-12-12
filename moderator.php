<?php 
include 'core/init.php'; 
protect_page();  //protect for normal user
moderator_protect(); //protect for admin
include 'includes/overall/overall_header.php'; 
?>
      <h1>Moderator Page</h1>

      <p>About ....</p>

<?php include 'includes/overall/overall_footer.php'; ?>

