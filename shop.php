<?php
    require ('database/connect_db.php');
    session_start();

    $admin = false;
    $buttonDisable = true;

    if(isset($_SESSION['username'])) {

        $username = $_SESSION['username'];
        $query = "SELECT * FROM `users` WHERE username = '$username' ";
        $result = mysqli_query($con, $query);
        $row= mysqli_fetch_array($result);
        $buttonDisable = false;

        $user_id = $row['user_id'];
        $current_point = $row['current_point'];

        $adminResult = mysqli_query($con, "SELECT * FROM users WHERE is_admin = 1 AND user_id = $user_id");
        if(mysqli_num_rows($adminResult)) {
            $admin = true;
        }

        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 600)) {
            session_unset();
            session_destroy();
            if($admin) {
                $admin = false;
            }
            header('Location: index.php');
        }

        $_SESSION['LAST_ACTIVITY'] = time();
    }
    else {
        session_unset();
    }


    
?>

<!doctype html>
<html lang="en">

    <head>

        <style>
            body {
                font-family: 'Poppins', sans-serif;
                margin: 0;
                background-color: #f9f9f9;
                color: #333;
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

            /* Title Section */
            .title-section {
                text-align: center;
                background-color: white;
                padding: 20px 0;
                font-size: 36px;
                font-weight: bold;
                border-bottom: 2px solid #FFD700;
            }

            /* Points Display */
            .show-point {
                text-align: center;
                font-size: 22px;
                margin: 20px 0;
            }

            /* Shop Section */
            .shop-product {
                display: flex;
                background-color: white;
                margin: 20px auto;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
                width: 80%;
                align-items: center;
            }

            .product-image img {
                width: 250px;
                height: 250px;
                object-fit: cover;
                border-radius: 10px;
                border: 2px solid #FFD700;
            }

            .product-description {
                flex-grow: 1;
                padding: 0 20px;
            }

            .product-title {
                font-size: 28px;
                font-weight: bold;
                margin-bottom: 10px;
            }

            .product-description span {
                font-size: 20px;
                line-height: 1.5;
            }

            .redeem-section {
                text-align: center;
            }

            .redeem {
                font-size: 20px;
                padding: 10px 20px;
                background-color: #FFD700;
                color: #333;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: 0.3s;
            }

            .redeem:hover {
                background-color: #E5C100;
            }

            .redeem[disabled] {
                background-color: #ccc;
                cursor: not-allowed;
            }

        </style>

        <title>Shop</title>
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
        <link rel='stylesheet' href='css/header.css'>
        <link rel='stylesheet' href='css/footer.css'>
        <link rel="icon" type="image/x-icon" href="images/talksick.png">
    </head>

    <body>
        <!-- Navigation Bar -->
        <div class="header">
            <!-- Logo -->
            <a href='index.php'>
                <img class='logo' src="images/talksick.png">
            </a>

            <!-- Navigation Links -->
            <div>
                <?php
                if(!isset($_SESSION['username'])) {
                    echo "<a href='login.php'><button>Login</button></a>";
                } else {
                    echo "<a href='profile.php'><button>Profile</button></a>";
                }
                ?>
                <a href='aboutus.php'><button>About Us</button></a>
                <a href='shop.php'><button>Shop</button></a>
                <?php
                if($admin) {
                    echo "<a href='manage_users.php'><button>Manage Users</button></a>";
                }
                ?>
            </div>
        </div>

        <!-- Title Section -->
        <div class='title-section'>
            <span>Shop</span>
        </div> 
        
        <!-- If user is logged in, display user's current points
        If user's current point is > 1, display wording in plural form
        If user's current point is = 1, display wording in singular form
        If user is not logged in, skip -->
        <?php
            if(isset($_SESSION['username'])) {
                if($current_point > 1) {
                    echo "<div class='show-point'>Current Points: $current_point Points</div>";
                }
                else {
                    echo "<div class='show-point'>Current Point: $current_point Point</div>";
                }
                
            }
        ?>
        
        <br><br>

        <!-- Get product details from database -->
        <?php
            $query = "SELECT * FROM product";
            $result = mysqli_query($con, $query);
            
            while($row = mysqli_fetch_array($result)) {
                $product_id = $row['product_id'];
                $product_name = $row['product_name'];
                $product_description = $row['product_description'];
                $product_price = $row['product_price'];
                $product_image = $row['product_image'];

                // Display product details
                echo "
                    <form action='thank_you.php' method='POST'>

                    <input type='hidden' name='product_id' value='$product_id'>
                    <input type='hidden' name='product_name' value='$product_name'>
                    <input type='hidden' name='product_price' value='$product_price'>

                    <div class='shop-product'>

                        <div class='product-image'>
                            <img src='$product_image'>
                        </div>

                        <div class='product-description'>
                            <span class='product-title'>$product_name</span><br><br>
                            <span>$product_description</span>
                        </div>
                    ";
                    
                        if($buttonDisable || $current_point < $product_price) {
                            echo "
                            <div class='redeem-section'>
                                <span>$product_price points</span>
                                <button type='submit' class='redeem' name='redeem' disabled>Redeem</button>
                            </div>";
                        }
                        else {
                            echo "
                            <div class='redeem-section'>
                                <span>$product_price points</span>
                                <button type='submit' class='redeem active' name='redeem'>Redeem</button>
                            </div>";
                        }

                    echo "
                    </div>
                    </form>
                ";
            }

        ?>   

    <br><br><br><br>
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