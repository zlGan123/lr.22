<?php 
include 'core/init.php'; 
include 'includes/overall/overall_header.php'; 

if(isset($_GET['username']) === true && empty($_GET['username']) === false)
{

    $username = $_GET['username'];
        
    if (user_exists($username) === true) 
    {
        $user_id = user_id_from_username($username);
        // $profile_data = user_data($user_id, 'company_name' , 'first_name', 'last_name', 'email');
        $profile_data = user_data($user_id, 'first_name', 'last_name', 'email');
?>
        <h1> 
            <?php 
                // echo $profile_data['company_name']; 
            ?> 
            <!-- 's profile -->
        </h1>
        <h1> 
            <?php 
                echo $profile_data['first_name'] . " " . $profile_data['last_name'];
            ?>'s Profile 
            
        </h1>
        <p>
            Email: 
            <?php 
                echo $profile_data['email']; 
            ?>
        </p>
        <p>
            <!-- Person in charge:  -->
            <?php 
                // echo $profile_data['first_name'] . $profile_data['last_name']; 
            ?>
        </p>
        
        
<?php

    }
    else 
    {
        echo 'Sorry, that user doesn\'t exists!';
    }
}
else
{
    header('Location: index.php');
    exit();
}

?>


<?php include 'includes/overall/overall_footer.php'; ?>

