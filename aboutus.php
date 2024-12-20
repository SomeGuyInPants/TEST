<?php
    require ('database/connect_db.php');
    session_start();

    $admin = false;

    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $query = "SELECT * FROM `users` WHERE username = '$username' ";
        $result = mysqli_query($con, $query);
        $row= mysqli_fetch_array($result);

        $user_id = $row['user_id'];

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
        }
        $_SESSION['LAST_ACTIVITY'] = time();
    } else {
        session_unset();
    }
?>

<html>
    <head>
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                margin: 0;
                background-color: #f9f9f9;
            }
            .title-section {
                background: #ffffff;
                text-align: center;
                font-size: 35px;
                padding: 40px 20px;
                border-bottom: 2px solid #ddd;
            }
            .content-section {
                margin: 40px auto;
                padding: 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                max-width: 1200px;
                border: 1px solid #e0e0e0;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
            }
            .content-text {
                width: 50%;
                text-align: justify;
                font-size: 20px;
                line-height: 1.5;
                color: #333;
            }
            .content-image {
                width: 45%;
            }
            .content-image img {
                width: 100%;
                height: auto;
                border-radius: 8px;
            }
            .header, .footer {
                background-color: #333;
                color: white;
                padding: 15px 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .header a, .footer a {
                color: white;
                text-decoration: none;
            }
            .header button {
                background-color: #4CAF50;
                border: none;
                color: white;
                padding: 10px 15px;
                font-size: 14px;
                cursor: pointer;
                margin-left: 10px;
            }
            .footer {
                text-align: center;
            }

            /* Section Background Colors */
            .about-section {
                background-color: #e0f7fa; /* Light Blue */
            }
            .purpose-section {
                background-color: #f1f8e9; /* Light Green */
            }
            .goal-section {
                background-color: #fff3e0; /* Light Orange */
            }
        </style>
        <title>About Us</title>
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
        <link rel='stylesheet' href='css/header.css'>
        <link rel='stylesheet' href='css/footer.css'>
        <link rel="icon" type="image/x-icon" href="images/talksick.png">
    </head>

    <body>
        <!-- Navigation Bar -->
        <div class="header">
            <a href='index.php'>
                <img class='logo' src="images/talksick.png" height='60'>
            </a>
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
                <?php if($admin) { echo "<a href='manage_users.php'><button>Manage Users</button></a>"; } ?>
            </div>
        </div>

        <!-- About Us Section -->
        <div class='title-section'>
            <span><u>About Talk Sick</u></span>
        </div>
        <div class='content-section about-section'>
            <div class='content-text'>
                Talk Sick is a non-profit organization based in Kuala Lumpur, Malaysia, with a mission to promote sustainable development and improve the overall well-being of the Malaysian community. Founded in 2024 by Jonas and Marvind, Talk Sick addresses real-world issues such as food insecurity by providing support where it is needed most.
            </div>
            <div class='content-image'>
                <img src='images/aboutus.jpg' alt='About Us Image'>
            </div>
        </div>

        <!-- Purpose Section -->
        <div class='title-section'>
            <span><u>Our Purpose</u></span>
        </div>
        <div class='content-section purpose-section'>
            <div class='content-text'>
                Aligned with Sustainable Development Goal (SDG) 2: Zero Hunger, we act as a bridge between donors and those in need. Through donations in the form of money, food, and essential supplies, we support vulnerable communities, including struggling families, orphanages, and underfunded schools.
            </div>
            <div class='content-image'>
                <img src='images/ourmission.png' alt='Our Mission Image'>
            </div>
        </div>

        <!-- Goals Section -->
        <div class='title-section'>
            <span><u>Our Goals</u></span>
        </div>
        <div class='content-section goal-section'>
            <div class='content-text'>
                Our goal is to ensure every Malaysian has access to basic needs. Contributors to Talk Sick are rewarded with points redeemable for special rewards like t-shirts, caps, and more, creating a giving cycle that benefits all.
            </div>
            <div class='content-image'>
                <img src='images/ourgoal.jpg' alt='Our Goal Image'>
            </div>
        </div>


    <!-- Footer -->
    <div class='footer'>
        <img class='logo' src="images/talksick.png">
        <p>Contact us: <a href='mailto:hello@talksick.org'>hello@talksick.org</a> | +0189594740</p>
        <a href = "terms_and_conditions.php">Terms & Conditions</a>
    </div>
</body>
