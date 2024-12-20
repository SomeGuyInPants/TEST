<?php
    require ('database/connect_db.php');

    $userid = $_POST['userid'];

    $query = "DELETE FROM `users` WHERE user_id = '$userid'";
    
    mysqli_query($con, $query);

    // Close the connection
    mysqli_close($con);
?>
