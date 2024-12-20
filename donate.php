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
        font-family: 'Poppins';
        margin: 0;
      }

      .form-section {
        background-color: #ffff9f;
        border: 2px solid black;
        height: auto;
        width: 45%;
        margin: auto;
        text-align: center;
        font-size: 32px;
        border-radius: 5px;
      }

      .form-section label {
        display: block;
        text-align: left;
        margin-left: 140px;
        font-size: 24px;
        padding: 10px 0px;
      }
      
  
      
      .card-box {
        background-color: white;
        border: 1px solid black;
        width: 360px;
        padding: 10px 20px;
        margin: auto;
      }

      .form-section .informative-error {
        font-size: 20px;
        color: red;
        text-align: left;

      }

      .form-section .checkbox {
        font-size: 24px;
      }

      input[type=text], input[type=email], input[type=number] {
        font-size: 24px;
        padding: 10px 20px;
        font-family: 'Poppins' ;
        width: 60%;
      }

      input[type=checkbox] {
        transform: scale(2);

      }

      .form-section br {
        line-height: 30px;
      }

      .form-section button {
        font-size: 24px;
      padding: 10px 20px;
      margin-top: 50px;
      font-family: inherit;
      cursor: pointer;
      background-color: #ffa700;
      border-radius: 5px;
      border: 0px;
      transition: 0.3s;
      }

      .form-section .donate-button {
        width: 150px;
        margin-left: 100px;
      }

      .form-section button:hover {
        transition: 0.3s;
      background-color: #BBE788;
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

      <title>Donate</title>
      <script src="https://js.stripe.com/v3/"></script>
      <script src="js/card.js"></script>
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

    <br><br><br><br>

    <!-- Donation Form -->
    <div class='form-section'>

      <br><span><u>Donate To Make A Difference</u></span><br><br>
      <form id='payment-form' method='POST' action='thank_you.php'>
      
      <!-- If user is not logged in, request for name, email, donation amount and card details -->
      <!-- If user is logged in, request for donation amount and card details only -->
      <?php
        if(!isset($_SESSION['username'])) {
            echo "
            <label for='name'>Display Name</label>
            <input type='text' id='name' name='name' onkeyup='checkDetails()' autocomplete='off' required><br><br>
            <label for='email'>Email</label>
            <input type='email' id='email' name='email'  pattern='^[\w]+@([\w]+\.com)$'
            title='Email must end with .com' onkeyup='checkDetails()' autocomplete='off' required><br><br>
            <input type='hidden' id='loginStatus' value='false'<br>";
        }
        else {
            echo "<input type='hidden' id='loginStatus' value='true'<br>";
        }
      ?>


      <!-- Donation validation is done through card.js -->
      <label for='donation'>Donation amount</label>
      <input type='number' id='donation_amount' name='donation_amount' onkeyup='checkDetails()' autocomplete='off' required><br>

      <!-- If user is not logged in, inform user that being logged in grants points -->
      <!-- If user is logged in, inform user the number of points earned per donation -->
      <?php
        if(!isset($_SESSION['username'])) {
          echo "<label class='informative-error' style='color:grey;font-size:15px'><i>Log in to earn points (RM 5 = 5O points)</i></label>";
        }
        else {
          echo "<label class='informative-error' style='color:black'><i>For every RM 5, earn 5O points</i></label>";
        }
      ?>

      <!-- Payment element done using card.js (using stripe API) -->
			<label style="align-items: center;" for="payment-element">Card</label>   


      <div class='card-box'>
        <div id='payment-element' required></div>
      </div>

      <label id='card-error' class='informative-error'></label>

      <br>

      <!-- Checkbox to keep donator's name anonymous -->
      <input type='checkbox' id='anonymous' name='anonymousStatus' value=true>
      <span class='checkbox'>Keep my name anonymous</span><br>

      <!-- Go back and donate button -->
      <button type='button' id='goBackBtn'>Go Back</button>
      <button class='donate-button' id='submitBtn'>Donate</button>
      </form>
      
    </div>

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


  </body> 

</html>

