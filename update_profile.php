<?php
session_start();
require('database/connect_db.php');


if(isset($_POST['update_data'])) {
    $user_id = $_POST['user_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $zip = $_POST['zip'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];

    $query = "UPDATE users SET username = '$username', email = '$email', first_name = '$fname', last_name = '$lname', address = '$address',
    zip = '$zip', city = '$city', state = '$state', country = '$country' WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $query);

    $_SESSION['username'] = $username;
    header('Location: profile.php');
    exit();

}


?>