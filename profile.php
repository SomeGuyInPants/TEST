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
            header('Location: index.php');
        }

        $_SESSION['LAST_ACTIVITY'] = time();
    }
    else {
        session_unset();
    }


    
?>

<!doctype html>
<html>

    <head>

        <style>

            body {
                font-family: 'Poppins' !important;
                margin: 0;
            }

            .header button {
                padding: 6px 20px !important;
            }

            .title-section 
            {
                background: white;
                font-size: 36px;
                padding: 30px 20px;
                margin-left: 100px;
            }

            .profile-data-section 
            {
                display: inline-flex;
                /* border: 2px solid blue; */
                background: white;
                margin: auto 100px;
                padding: 0px 0px 60px 0px;
         
            }
            .profile-data-fields-left-section
            {
                /* border: 2px solid black; */
                font-size: 25px;
                margin: 10px 0px;
                width: 32em;
            }

            .profile-data-fields-right-section {
                /* border: 2px solid black; */
                font-size: 25px;
                margin: 10px 0px;
                width: 20em;
            }

            .profile-data-fields-left-section span, .profile-data-fields-right-section span {
                text-align: right;
                padding: 10px 20px;
            }

            .button-section
            {
                /* border: 2px solid black; */
                text-align: center;
                font-size: 25px;
                margin: 10px auto;
                justify-content: center;
                display: table;
                width: 100%;
                
            }

            .button
            {
                border: none;
                border-radius: 10px;
                
            }

            .donation {
                background: #80CC28;
                transition: 0.3s;
            }

            .donation:hover {
                background: #73b824;
                transition: 0.3s;
            }

            .sign-out {
                background: #FF3E3E;
                transition: 0.3s;
            }

            .sign-out:hover {
                background: #cc3232;
                transition: 0.3s;
            }

			.edit {
			    background: #FFD700; /* Gold/Yellow */
			    color: black; /* Text color for contrast */
			    transition: 0.3s;
			    padding: 7px 20px;
			}
			
			.edit:hover {
			    background: #E6C200; /* Darker yellow for hover effect */
			    transition: 0.3s;
			}
            
            .button a, .button a:hover {
                text-decoration: none;
                color: inherit;
            }

            .modal-open {
                overflow: scroll;
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

        <title>Profile</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel='stylesheet' href='css/header.css'>
        <link rel='stylesheet' href='css/footer.css'>
        <link rel="icon" type="image/x-icon" href="images/talksick.png">
        
        <script>
            // username validation to check if username is taken
            function isUsernameTaken(username) {
                if (username.length != 0) {
                    var user_id = document.getElementById('user_id').value;
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("username-validation").value = this.responseText; 
                    }
                    };

                    xmlhttp.open("GET", "database/check_username.php?username=" + username + "&user_id=" +user_id, true);
                    xmlhttp.send();
                }
            }

            // email validation to check if email is taken
            function isEmailTaken(email) {
                if (email.length != 0) {
                    var user_id = document.getElementById('user_id').value;
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("email-validation").value = this.responseText; 
                    }
                    };

                    xmlhttp.open("GET", "database/check_email.php?email=" + email + "&user_id=" +user_id, true);
                    xmlhttp.send();
                }
            }
        </script>
    </head>

    <body>
    <div>
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
        </div>

        <!-- title section -->
        <div class='title-section'>
            <span><u>Profile</u></span>
        </div>

        <!-- profile data section -->
        <?php

        // user info
        $query = "SELECT * FROM `users` WHERE username = '$username' ";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);

        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $email = $row['email'];
        $address = $row['address'];
        $zip = $row['zip'];
        $city = $row['city'];
        $state = $row['state'];
        $country = $row['country'];
        $current_point = $row['current_point'];
        

        // user total donation and points earned
        $query2 = "SELECT SUM(donation_amount) AS total_donation_amount, SUM(point_earned) AS total_point_earned FROM `donation_history` WHERE user_id = '$user_id'";
        $result2 = mysqli_query($con, $query2);
        $row2 = mysqli_fetch_array($result2);

        $total_donation_amount = isset($row2['total_donation_amount'])? $row2['total_donation_amount']: 0;
        $total_point_earned = isset($row2['total_point_earned'])? $row2['total_point_earned']: 0;


        // display user details
        echo
        "
            <div class='profile-data-section'>
                    <div class='profile-data-fields-left-section'>
                        <span>First Name: $first_name</span>
                        <span>Last Name: $last_name</span>
                        <br><br>
                        <span>Username: $username</span>                           
                        <br><br>
                        <span>Email: $email</span>                         
                        <br><br>
                        <span>Address: $address</span>
                        <br><br>
                        <span>Zip: $zip</span>
                        <span>City: $city</span>
                        <br><br>
                        <span>State: $state</span>
                        <br><br>
                        <span>Country: $country</span>
                    </div>

                    <div class='profile-data-fields-right-section'>
                    <span>Total donated: RM $total_donation_amount</span>
                    <br><br>
                    <span>Total points earned: $total_point_earned Points</span>
                    <br><br>
                    <span>Current points: $current_point Points</span>
                    <br><br>
                    <br><br>
                    <span class='donation button'>
                    <a href='donation_history.php'>View donation history</a></span>
                    <br><br>
                    <button class='edit button' style=' margin-right: 20px; outline:none;' data-bs-toggle='modal' data-bs-target='#edtBtn'>
                    Edit Profile</button>

                    <span class='sign-out button'>
                    <a href='logout.php'>Sign Out</a></span>
                
                    

                    </div>
            </div>";
        ?>

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

        <!-- Modal Pop Up-->
        <div class="modal fade" id="edtBtn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLongTitle">Edit Profile</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            
                <div class="modal-body">
                <form class='row g-1' action='update_profile.php' method='POST'>

                    <input type='hidden' name='user_id' id='user_id' value='<?=$user_id?>'>

                    <div class="form-group col-md-6">
                        <label for="validationDefault01" class="form-label h5">First name</label>
                        <input type="text" class="form-control h5" id="fname" name="fname" value="<?=$first_name?>"
                        pattern='[aA-zZ]*' title="First name must not contain any numbers and/or special characters" autocomplete='off' required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="validationDefault02" class="form-label h5">Last name</label>
                        <input type="text" class="form-control h5" id="lname" name="lname" value="<?=$last_name?>"
                        pattern='[aA-zZ]*' title="First name must not contain any numbers and/or special characters" autocomplete='off' required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="validationDefault02" class="form-label h5">Username</label>
                        <input type="text" class="form-control h5" id="username" name="username" value="<?=$username?>" oninput="isUsernameTaken(this.value)" onkeyup='checkUsername()'
                        pattern='[a-zA-Z_][a-zA-Z0-9]*' title='Name cannot start with a number and
                        contain special characters (#, $, %, _).' autocomplete='off' required>
                    </div>
                    <input type='hidden' id='username-validation' value=''>

                    <div class="form-group col-md-6">
                        <label for="validationDefault02" class="form-label h5">Email</label>
                        <input type="text" class="form-control h5" id="email" name="email" value="<?=$email?>" oninput="isEmailTaken(this.value)" onkeyup='checkEmail()' pattern='^[\w]+@([\w]+\.com)$'
                        title="Email must end with .com" autocomplete='off' required>
                    </div>
                    <input type='hidden' id='email-validation' value=''>

                    <div class="form-group col-md-12">
                        <label for="validationDefault02" class="form-label h5">Address</label>
                        <input type="text" class="form-control h5" id="address" name="address" value="<?=$address?>" autocomplete='off' required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="validationDefault02" class="form-label h5">Zip</label>
                        <input type="text" class="form-control h5" id="zip" name="zip" value="<?=$zip?>" autocomplete='off' required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="validationDefault02" class="form-label h5">City</label>
                        <input type="text" class="form-control h5" id="city" name="city" value="<?=$city?>" 
                        pattern='[aA-zZ]*' title="City must not contain any numbers and/or special characters" autocomplete='off' required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="validationDefault02" class="form-label h5">State</label>
                        <input type="text" class="form-control h5" id="state" name="state" value="<?=$state?>"
                        pattern='[aA-zZ]*' title="State must not contain any numbers and/or special characters" autocomplete='off' required>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label for="validationDefault02" class="form-label h5">Country</label>
                        <input type="text" class="form-control h5" id="country" name="country" value="<?=$country?>" 
                        pattern='[aA-zZ]*' title="Country must not contain any numbers and/or special characters" autocomplete='off' required>
                    </div>
                    

               
                </div>
           
            


                <div class="modal-footer">
                <button type="button" class="btn btn-secondary h3" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name='update_data' class="btn btn-primary h3">Save changes</button>
                </div>

                </form>
            </div>
        </div>
        </div>

    
    <!-- Bootstrap reference-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body>

</html>

<script>
var username = document.getElementById("username");
var email = document.getElementById("email");

var checkUsername = function () {
    var usernameValue = document.getElementById("username-validation").value;
    if(usernameValue == true && username.value == '') {
        username.setCustomValidity('Please fill out this field.');
    }
    else if (usernameValue == true) {
        username.setCustomValidity('Username has been taken, please enter a new one.');
    }
    else {
        username.setCustomValidity('');
    }
}

var checkEmail = function () {
    var emailValue = document.getElementById("email-validation").value;
    if(emailValue == true && email.value == '') {
        email.setCustomValidity('Please fill out this field.');
    }
    else if (emailValue == true) {
        email.setCustomValidity('Email has been taken, please enter a new one.');
    }
    else {
        email.setCustomValidity('');
    }
}
</script>