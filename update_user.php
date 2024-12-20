<?php
    require ('database/connect_db.php');

    $userid = $_POST['userid'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $zip = $_POST['zip'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $current_point = $_POST['current_point'];

    $query = "UPDATE `users` SET first_name = '$firstname', last_name = '$lastname', email = '$email', address = '$address', zip = '$zip', city = '$city', state = '$state', country = '$country', current_point = '$current_point' WHERE user_id = '$userid'";
    
    mysqli_query($con, $query);

    // Close the connection
    mysqli_close($con);
?>
