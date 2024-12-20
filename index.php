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
    }
    else {
        session_unset();
    }
?>

<html>

<head>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            color: #333;
            background-color: #fefefe;
        }

        a {
            text-decoration: none;
        }

        /* Navigation Bar */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: #FFD700;
            color: #333;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header .logo {
            height: 80px;
        }

        .header button {
            background-color: #FF6347;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            transition: 0.3s;
            border-radius: 4px;
            font-weight: bold;
        }

        .header button:hover {
            background-color: #e0533b;
        }

        /* Banner Section */
        .home-banner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 400px;
            background: linear-gradient(to right, #FFFAE1, #FFEB85);
            margin-bottom: 40px;
            color: #333;
            position: relative;
        }

        .home-banner .content {
            text-align: center;
        }

        .home-banner h1 {
            font-size: 48px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .home-banner p {
            font-size: 20px;
            margin-bottom: 30px;
        }

        .donate-button {
            background-color: #FF6347;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .donate-button:hover {
            background-color: #e0533b;
        }

        /* Mission Section */
        .our-mission {
            background-color: #fff;
            text-align: center;
            padding: 60px 20px;
            position: relative;
        }

        .our-mission::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #FFEB85;
        }

        .our-mission h2 {
            font-size: 36px;
            margin-bottom: 30px;
            color: #333;
            font-weight: 600;
        }

        .mission-box {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .mission-box .box {
            background: #FFFAE1;
            border: 1px solid #FFEB85;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            width: 300px;
            transition: transform 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .mission-box .box:hover {
            transform: translateY(-10px);
        }

        .mission-box img {
            height: 100px;
            margin-bottom: 20px;
        }

        .mission-box span {
            font-size: 18px;
        }

        /* Donation Section */
        .donation-section {
            text-align: center;
            padding: 40px 20px;
            background-color: #FFFAE1;
            
        }

        .donation-section h2 {
            font-size: 32px;
            margin-bottom: 20px;
            font-weight: 600;
            
        }

        .pagination-link {
            display: inline-block;
            font-size: 32px;
            padding: 5px 16px;
            margin: 0px 2px;
            cursor: pointer;
            background-color: #3333;
        }
        
        .pagination-link:hover:not(.active) {
            background-color: #FFFAE1;
            border-radius: 5px;
            transition: 0.2s;
         }
            
        table, th, td {
            padding: 20px 40px;
            font-size: 25px;
            border-collapse: collapse;
            border: 2px solid black;
            margin-left: auto;
            margin-right: auto;
         }

         th {
            background-color: #FED750;
         }

         td {
            background-color: #FED751;
         }

         th.bottom-row {
            height: 70px;
         }

         table td.first-col, table th.first-col{
            width: 400px;
         }
            

        /* Footer */
        .footer {
            background-color: #333;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .footer .logo {
            height: 80px;
            margin-bottom: 20px;
        }

        .footer a {
            color: #FFD700;
            font-weight: bold;
        }
    </style>

    <title>Talk Sick</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins:300,400,600&display=swap' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
    <link rel='stylesheet' href='css/header.css'>
    <link rel='stylesheet' href='css/footer.css'>
    <link rel="icon" type="image/x-icon" href="images/logo/talksickicon.png">
</head>

<body>
    <!-- Navigation Bar -->
    <div class="header">
        <a href='index.php'>
            <img class='logo' src="images/talksick.png">
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
            
            <?php if($admin) echo "<a href='manage_users.php'><button>Manage Users</button></a>"; ?>
        </div>
    </div>

    <!-- Banner -->
    <div class='home-banner' style="background: url('images/zh1.jpg') center; opacity:85%;">
        <div class='content'>
            <h1>Help Fight Hunger in Malaysia</h1>
            <p>Your support ensures food security for families in need.<br>Join us and make a difference today.</p>
            <a href='donate.php'><button class='donate-button'>Donate Now</button></a>
        </div>
    </div>

       <!-- Mission Section -->
    <div class='our-mission' style="background-color: #FFFAE1;">
        <h2>Our Mission</h2>
        <div class='mission-box'>
            <div class='box'>
                <img src='images/sdg2.png'>
                <p>Contribute to SDG 2: Zero Hunger</p>
            </div>
            <div class='box'>
                <img src='images/food-basket.jpeg'>
                <p>Distribute nutritious meals to underprivileged families</p>
            </div>
            <div class='box'>
                <img src='images/community.jpeg'>
                <p>Support communities through food assistance programs</p>
            </div>
        </div>
    </div>


    <!-- Donation Section -->
    <div class='donation-section'>
        <h2>Donation List</h2>
        <div class='table-responsive' id='pagination'></div>
    </div>
    
    <script>  
$(document).ready(function() {
    load_data();
    function load_data(page) {
        $.ajax({
            url: "index_pagination.php",
            method: "POST",
            data: { page: page },
            success: function(data) {
                console.log('Data received:', data);
                $('#pagination').html(data);
                console.log('Data loaded into #pagination');
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }

    $(document).on('click', '.pagination-link', function() {
        var page = $(this).attr("id");
        console.log('Clicked page:', page);
        load_data(page);
    });
});

 </script>

    <!-- Footer -->
    <div class='footer'>
        <img class='logo' src="images/talksick.png">
        <p>Contact us: <a href='mailto:hello@talksick.org'>hello@talksick.org</a> | +0189594740</p>
        <a href = "terms_and_conditions.php">Terms & Conditions</a>
    </div>
</body>


</html>
  
