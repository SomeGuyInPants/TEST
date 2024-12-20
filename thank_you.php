<?php
require ('database/connect_db.php');
    session_start();

    $admin = false;

    if(isset($_SESSION['username'])) {

        $username = $_SESSION['username'];
        $query = "SELECT * FROM `users` WHERE username = '$username' ";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);

        $user_id = $row['user_id'];
        $current_point = $row['current_point'];

        // get user address info
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $address = $row['address'];
        $zip = $row['zip'];
        $city = $row['city'];
        $state = $row['state'];
        $country = $row['country'];
        
        $adminResult = mysqli_query($con, "SELECT * FROM users WHERE is_admin = 1 AND user_id = $user_id");
        if(mysqli_num_rows($adminResult)) {
            $admin = true;
        }

        if(isset($_POST['anonymousStatus'])) {
            $username = "Anonymous";
        }
        else {
            $username = $row['username'];
        }

        date_default_timezone_set('Asia/Kuala_Lumpur');
        $datetime = date("Y-m-d H:i:s");

        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 600)) {
            session_unset();
            session_destroy();
            if($admin) {
                $admin = false;
            }
        }

        $_SESSION['LAST_ACTIVITY'] = time();
    }
    else {
        session_unset();
    }

    // if user is not logged in
    if(isset($_POST['email'])) {

        $name = stripslashes($_POST['name']);
        $name = mysqli_real_escape_string($con, $name);

        // check if user has enabled to keep their name anonymous
        if(isset($_POST['anonymousStatus'])) {
            $name = "Anonymous";
        }
        
        $email = stripslashes($_POST['email']);
        $email = mysqli_real_escape_string($con, $email);

        $donation_amount = stripslashes($_POST['donation_amount']);
        $donation_amount = mysqli_real_escape_string($con, $donation_amount);

        $point_earned = ($donation_amount * 10);

        $datetime = date("Y-m-d H:i:s");

        // check if user's email entered exists in database
        $query1 = "SELECT user_id, current_point FROM users where email = '$email'";
        $result = mysqli_query($con, $query1);

        // if exist, assign points to existing user
        if(mysqli_num_rows($result)) {
            $row = mysqli_fetch_array($result);
            $user_id = $row['user_id'];
            $current_point = $row['current_point'] + $point_earned;

            $query2 = "INSERT into `donation_history` (user_id, name, date, donation_amount, point_earned)
            VALUES ('$user_id', '$name', '$datetime', '$donation_amount', '$point_earned')";
            mysqli_query($con, $query2);

            $query3 = "UPDATE `users`
             SET current_point = '$current_point' 
             WHERE user_id = '$user_id'";
             mysqli_query($con, $query3);
        }
        // if not, assign to donation_history table and assign user_id to 0 (not a user)
        else {
            $query2 = "INSERT into `donation_history` (name, date, donation_amount, point_earned)
            VALUES ('$name', '$datetime', '$donation_amount', '$point_earned')";
            mysqli_query($con, $query2);
        }
    }

    // if user redeems a product
    else if (isset($_POST['redeem'])){
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];

        $total_current_point = $current_point - $product_price;

        $query2 = "UPDATE users SET current_point = '$total_current_point' WHERE user_id = '$user_id'";
        mysqli_query($con, $query2);
    }

    // if user is logged in
    else {
        $email = $row['email'];
        $donation_amount = stripslashes($_POST['donation_amount']);
        $point_earned = ($donation_amount * 10);
        $current_point = $row['current_point'] + $point_earned;

        $query = "INSERT into `donation_history` (user_id, name, date, donation_amount, point_earned)
        VALUES ('$user_id', '$username', '$datetime', '$donation_amount', '$point_earned')";
        mysqli_query($con, $query);

        $query2 = "UPDATE `users`
             SET current_point = '$current_point' 
             WHERE user_id = '$user_id'";
             mysqli_query($con, $query2);
    }


?>
<html>
    <head>
        <style>
            body {
   			font-family: 'Poppins', sans-serif;
            margin: 0;
            }

            .thank-you-section {
                height: 110%;
                width: 100%;
                background-size: cover;
                background-position: center;
                background-image: url('images/thankyou.jpg');
                display: flex;
                justify-content: center;
                align-items: center;
            }

         

            .thank-you-section .receipt {
                text-align: center;
                background: #FEE440;
                height: auto;
                width: 50%;
                font-size: 24px;
            }

            .receipt h1 {
                padding: 0px 50px;
            }

            .receipt p {
                padding: 0px 50px;
                text-align: left;
            }

            .receipt .details {
                padding: 0px 50px;
                text-align: left;
            }


            .receipt button {
                margin: 0;
                font-size: 24px;
                padding: 10px 20px;
                font-family: inherit;
                cursor: pointer;
                background-color: #FF4242;
                border-radius: 5px;
                border: 0px;
                transition: 0.3s;

            }

            .receipt button:hover {
            transition: 0.3s;
            background-color: #BBE788;
            
            }

            .thank-you-section span, .details span {
                color: #FF4242;
            }
       /* Footer Styling */
            .footer {
                background-color: #FFD700;
                color: #333;
                text-align: center;
                padding: 20px 0;
                margin-top: 30px;
            }

            .footer a {
                color: #333;
                text-decoration: underline;
                transition: 0.3s;
            }

            .footer a:hover {
                color: #555;
            }

            .footer img.logo {
                height: 50px;
            }
            
           /* Header Styling */
            .header {
                background-color: #FFD700;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 50px;
                box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            }

            .header a {
                text-decoration: none;
            }

            .header button {
                background-color: white;
                color: #333;
                border: none;
                padding: 8px 15px;
                font-size: 18px;
                border-radius: 5px;
                margin-left: 10px;
                cursor: pointer;
                transition: 0.3s;
            }

            .header button:hover {
                background-color: #f1f1f1;
            }

            .header img.logo {
                height: 60px;
            }


        </style>
        <title>Thank you</title>
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
        <link rel='stylesheet' href='css/header.css'>
        <link rel='stylesheet' href='css/footer.css'>
        <link rel="icon" type="image/x-icon" href="images/talksick.png">
    </head>
    <body>
    <!-- Navigation Bar -->
    <div class="header">
                <!-- logo -->
                <a href='index.php'>
                <img class='logo' src="images/talksick.png" height='60'>
                </a>
				
				<div>
			    <!-- Login/Profile -->
                <?php
                if(!isset($_SESSION['username'])) {
                    echo "<a href='login.php'><button type='submit'>Login</button></a>";
                }
                else if(isset($_SESSION['username'])) {
                    echo "<a href='profile.php'><button type='submit'>Profile</button></a>";
                }
                ?>
                
                <!-- Submit -->
                <a href='aboutus.php'>
                <button type='submit'>About Us</button>
                </a>

                <!-- Shop -->
                <a href='shop.php'>
                <button type='submit'>Shop</button>
                </a>

                <!-- Manage users -->
                <?php
                if($admin) {
                    echo "<a href='manage_users.php'><button type='submit'>Manage Users</button></a>";
                }
                ?>
									
				</div>

      </div>

        <div class='thank-you-section'>
            <div class='receipt'>
                

                <?php
                if(isset($_POST['email'])) {

                    echo "
                    <h1>Thank You for your donation, <span>$name</span>!</h1><br>
                    <p>Thank you for donating to our fundraiser. Your donation will greatly help us combat hunger issues in Malaysia. </p><br>";
                    
                    echo "<p class='details'><b>Details:</b><br>
                        name: <span>$name</span><br>
                        email: <span>$email</span><br>
                        donation amount: <span>$donation_amount</span><br>
                        donation date and time: <span>$datetime</span></p><br><br>";

                    echo "<a href='index.php'>
                    <button>return to home
                    </button></a><br><br><br>";
                }
                else if(isset($_POST['redeem'])){

                    echo "
                    <h1>You have successfully redeemed <span>$product_name</span>!</h1><br>
                    <p>Your item will be delivered to the following <b>address:</b> <br><br>
                    $first_name $last_name <br>
                    $address, $city <br>
                    $state, $zip
                    </p>";

                    echo "<p class='details'><b>Details:</b><br>
                        product name: <span>$product_name</span><br>
                        product cost: <span>$product_price Points</span><br>
                        current point: <span>$total_current_point Points</span><br>
                        donation date and time: <span>$datetime</span></p><br><br>";

                    echo "<a href='index.php'>
                    <button>return to home
                    </button></a><br><br><br>";

                }
                else {
                    echo "
                    <h1>Thank You for your donation, <span>$username</span>!</h1><br>
                    <p>Thank you for donating to our fundraiser. Your donation will greatly help us combat hunger in Malaysia. </p><br>";

                    echo "<p class='details'><b>Details:</b><br>
                        name: <span>$username</span><br>
                        email: <span>$email</span><br>
                        donation amount: <span>RM $donation_amount</span><br>
                        points earned: <span>$point_earned</span><br>
                        donation date and time: <span>$datetime</span></p><br><br>";

                    echo "<a href='index.php'>
                    <button>return to home
                    </button></a><br><br><br>";
                }
                ?>
               
            </div>
        </div>


    <!-- Footer -->
    <div class='footer'>
        
        <img class='logo' src="images/talksick.png">

        <div class='logo-section'>
            <a href='terms_and_conditions.php' target='_blank'><span>Terms and Conditions</span></a>
        </div>
<br>
        <span><u>Contacts</u>
        <p> <a href='mailto:hello@talksick.org'>hello@talksick.org</a> | +0189594740</p>
        </span>

        </div>

    </body>
</html>