<?php
    require ('database/connect_db.php');
    session_start();

    $admin = false;

    if(isset($_SESSION['username'])) {

        $username = $_SESSION['username'];
        $query = "SELECT * FROM `users` WHERE username = '$username' ";
        $result = mysqli_query($con, $query);
        $row= mysqli_fetch_array($result);

        if(mysqli_num_rows($result)) {
            $user_id = $row['user_id'];
        }
        else {
            session_unset();
            header("Location: index.php");
        }
        

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
            }

            .manageusers-section 
            {
                background: white;
                text-align: left;
                font-size: 35px;
                padding: 50px 0px;
                justify-content: center;
                margin-left: 100px;
            }

            .searchbar
            {
                border: 2px solid;
                width: 50%;
                background: white;
                text-align: left;
                font-size: 20px;
                padding: 10px;
                font-family: 'Unica One';
            }

            .database-section 
            {
                background: white;
                text-align: center;
                justify-content: center;
                width:95%;
                margin: 3% 2.5%;
            }


            table {
			    width: 100%;
			    border-collapse: collapse;
			    margin-top: 20px;
			    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			}
			
			th, td {
			    padding: 15px;
			    text-align: left;
			    font-size: 16px;
			}
			
			th {
			    background-color: #FFD700;
			    color: #333;
			    font-weight: 600;
			    font-size: 18px;
			    border-bottom: 2px solid #ddd;
			}
			
			tr:nth-child(even) {
			    background-color: #f9f9f9;
			}
			
			tr:hover {
			    background-color: #f1f1f1;
			}
			
			td {
			    background-color: white;
			}

            th.bottom-row {
                padding: 30px;
            }

            table
            {
                width:100%;
            }

            td.no_users {
                text-align: center;
            }

            tr.nomatch {
                text-align: center;
                visibility: collapse;            
            }

            td.nomatch {   
                padding: 15px;   
            }


            td.context
            {
                width:10%;
                text-align:center;
            }

            .context img, .editpopup_buttons, .deletepopup_buttons
            {
                cursor: pointer;
                width:25%
            }

            .tablebutton
            {
                border:none;
                display: inline;
            }

            .editpopup_bg, .deletepopup_bg
            {
                background: black;
                opacity: 0.7;
                position: fixed;
                width:100%;
                height:100%;
                font-size: 35px;
            }

            .editpopup_title, .deletepopup_title
            {
                background: #BFBFBF;
                text-align: center;
                font-size: 35px;
                padding: 10px 0px;
                justify-content: center;
                border-radius: 10px 10px 0 0;
            }

            .editpopup_body, .deletepopup_body
            {
                background: #DFDFDF;
                position: fixed;
                width:96%;
                top: 25%;
                margin: 2%;
                opacity: 1;
                display: inline-block;
                border-radius: 10px;
            }

            .editpopup_tablesection, .deletepopup_contentsection
            {   
                width:96%;
                margin: 2%;
                justify-content: center;
            }

            .deletepopup_contentsection
            {
                text-align: center;
                font-size: 30px;
            }

            .editpopup_tabledata
            {   
                width: 100%;
                background: #D5D8E4;
                text-align: left;
                font-size: 20px;
                font-family: 'Unica One';
                border: none;
            }

            .editpopup_buttonsection, .deletepopup_buttonsection
            {
                text-align: center;
                font-size: 25px;
                justify-content: center;
                display: table;
                width: 100%;
            }

            .editpopup_buttons, .deletepopup_buttons
            {
                padding: 10px;
                margin: 10px;
                display: inline-block;
                border-radius: 10px;
                border: 0;
                width: 40%;
            }

            .editpopup_bg, .editpopup_body, .deletepopup_bg, .deletepopup_body
            {
                visibility: hidden;
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
    
        <title>Manage Users</title>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="js/edit_users.js"></script>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel='stylesheet' href='css/header.css'>
        <link rel='stylesheet' href='css/footer.css'>
        <link rel="icon" type="image/x-icon" href="images/talksick.png">
    </head>

    <body>
        <!-- edit popup -->
        <div class='editpopup_bg' id='editpopup_bg'></div>
        <div class='editpopup_body' id='editpopup_body'>
            <div class='editpopup_title'>Edit User</div>

            <div class='editpopup_tablesection'>
                <table class='editpopup_table'>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Zip</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Country</th>
                        <th>Current Point</th>
                    </tr>
                    <!-- reference for userid (hidden) -->
                    <tr style='visibility: collapse;'>
                        <td> <div><input class='editpopup_tabledata' type="text" placeholder="User ID" id='edittable_userid'></div> </td>   
                    </tr>
                    <!-- edit table data -->
                    <tr>
                        <td> <div><input class='editpopup_tabledata' type="text" placeholder="First Name" id='edittable_firstname'></div> </td>
                        <td> <div><input class='editpopup_tabledata' type="text" placeholder="Last Name" id='edittable_lastname'></div> </td>
                        <td> <div><input class='editpopup_tabledata' type='email' placeholder="Email" id='edittable_email'></div> </td>
                        <td> <div><input class='editpopup_tabledata' type="text" placeholder="Address" id='edittable_address'></div> </td>
                        <td> <div><input class='editpopup_tabledata' type="text" placeholder="Zip" id='edittable_zip'></div> </td>
                        <td> <div><input class='editpopup_tabledata' type="text" placeholder="City" id='edittable_city'></div> </td>
                        <td> <div><input class='editpopup_tabledata' type="text" placeholder="State" id='edittable_state'></div> </td>
                        <td> <div><input class='editpopup_tabledata' type="text" placeholder="Country" id='edittable_country'></div> </td>
                        <td> <div><input class='editpopup_tabledata' type="text" placeholder="Current Point" id='edittable_current_point'></div> </td>
                    </tr> 
                </table>
            </div>

            <div class='editpopup_buttonsection'>
                <div class='editpopup_buttons' style='background: #80CC28' onclick='editpopup_confirm()'>Confirm </div>
                <div class='editpopup_buttons' style='background: #FF3E3E' onclick='editpopup_close()'>Cancel</div>
            </div>
        </div>

        <!-- delete popup -->
        <div class='deletepopup_bg' id='deletepopup_bg'></div>
        <div class='deletepopup_body' id='deletepopup_body'>
            <div class='deletepopup_title'>Delete User</div>

            <div class='deletepopup_contentsection'>
               Are you sure you want to delete this user?
            </div>

            <div id='deletepopup_userid' style='visibility: collapse;'></div>

            <div class='deletepopup_buttonsection'>
                <div class='deletepopup_buttons' style='background: #80CC28' onclick='deletepopup_confirm()'>Confirm </div>
                <div class='deletepopup_buttons' style='background: #FF3E3E' onclick='deletepopup_close()'>Cancel</div>
            </div> 
        </div>

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

        <!-- Manage Users section -->
        <div class='manageusers-section'>
            <span><u>Manage Users</u></span> 
            <br><br>
            <input class='searchbar' id="searchInput" oninput="searchbar()" type="text" placeholder="search for user...">
        </div>

        <!-- database section -->
        <div class='database-section'>
            <table id="table">
                <!-- table heading -->
                <tr>
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Zip</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Country</th>
                    <th>Current Point</th>
                    <th>Controls</th>
                </tr>

                <!-- table data -->
                <?php
                        $query = "SELECT COUNT(*) FROM users";
                        $queryResult = mysqli_query($con, $query);
                        $fetchResult = mysqli_fetch_array($queryResult);
                        $resultValue = $fetchResult[0];

                        //check if no users
                        if ($resultValue == 0)
                        {
                            echo "<td colspan=11 class=no_users> There are no users in the database </td>";
                        }
                        //if got users
                        else if($resultValue > 0)
                        {
                            // remove user id 0, which represents a non-user
                            $userDataQuery = "SELECT * FROM users WHERE user_id != 0";
                            $userDataqueryResult = mysqli_query($con, $userDataQuery);
                            
                            while ($row = mysqli_fetch_assoc($userDataqueryResult)) 
                            {
                                // get data for edit popup table
                                $j_userid = json_encode($row['user_id']);
                                $j_firstname = json_encode($row['first_name']);
                                $j_lastname = json_encode($row['last_name']);
                                $j_email = json_encode($row['email']);
                                $j_address = json_encode($row['address']);
                                $j_zip = json_encode($row['zip']);
                                $j_city = json_encode($row['city']);
                                $j_state = json_encode($row['state']);
                                $j_country = json_encode($row['country']);
                                $j_current_point = json_encode($row['current_point']);

                                echo "<tr>";
                                    echo "<td>" . $row['user_id'] . "</td>";
                                    echo "<td>" . $row['first_name'] . "</td>";
                                    echo "<td>" . $row['last_name'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['address'] . "</td>";
                                    echo "<td>" . $row['zip'] . "</td>";
                                    echo "<td>" . $row['city'] . "</td>";
                                    echo "<td>" . $row['state'] . "</td>";
                                    echo "<td>" . $row['country'] . "</td>";
                                    echo "<td>" . $row['current_point'] . "</td>";
                                    echo "
                                        <td class='context'> 
                                            <img src='images/edit.png' alt='Edit' onclick='editpopup_open(  
                                                                                                            $j_userid
                                                                                                            ,$j_firstname 
                                                                                                            ,$j_lastname
                                                                                                            ,$j_email
                                                                                                            ,$j_address 
                                                                                                            ,$j_zip
                                                                                                            ,$j_city
                                                                                                            ,$j_state
                                                                                                            ,$j_country
                                                                                                            ,$j_current_point)'>

                                            <img src='images/delete.png' alt='Delete' onclick='deletepopup_open($j_userid)'>
                                        </td>
                                        ";
                                echo "</tr>";
                            };
                        }
                ?>
                <tr class='nomatch' id='nomatch'><td colspan=11 class='nomatch'> There are no matches! </td></tr>
            </table>
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