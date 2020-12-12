<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="downloads.php">Downloads</a></li>
        <li><a href="forum.php">Forum</a></li>
        <li><a href="contact.php">Contact us</a></li>
        <?php
            if (has_access($session_user_id, 1) === true )  //1=admin 
            {
                ?>
                    <li><a href="admin.php">Admin Page</a></li>
                    <li><a href="moderator.php">Moderator Page</a></li>
                <?php
            } 
            if (has_access($session_user_id, 2) === true)  //2=Moderator
            {
                ?>
                    <li><a href="moderator.php">Moderator Page</a></li>
                <?php
            } 
        ?>        
    </ul>
</nav>