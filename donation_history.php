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

<html>

    <head>

        <style>

            body {
   				font-family: 'Poppins', sans-serif;
                margin: 0;
            }

            .donation-history-section 
            {
                background: white;
                font-size: 36px;
                padding: 30px 20px;
                margin-left: 100px;
            }

			.return {
			    background: #E74C3C; 
			    transition: 0.3s;
			    float: right;
			    border-radius: 8px;
			    text-align: center;
			    font-size: 20px; 
			    margin: 0px 0px 0px 0px; 
			    padding: 8px 16px; 
			    color: white; 
			
			}
			
			.return:hover {
			    background: #C0392B; 
			    transition: 0.3s;
			}
	
            
            a
            {
                text-decoration: none;
                color: inherit;
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

            .empty-record {
                height: 52px;
            }

            .pagination {
                text-align: left;
            }

            .pagination-link {
                display: inline-block;
                font-size: 26px;
                padding: 5px 16px;
                margin: 0px 2px;
                cursor: pointer;
            }

            .active {
                background-color: #80CC28;
                border-radius: 5px;
            }
            .pagination-link:hover:not(.active) {
                background-color: #BBE788;
                border-radius: 5px;
                transition: 0.2s;
            }

            .inactive {
                display: inline-block;
                font-size: 26px;
                padding: 5px 16px;
                color: white;
                pointer-events: none;
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

        <title>Donation History</title>
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
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

        <!-- title section -->
        <div class='donation-history-section'>
            <span><u>Donation History</u></span>
            <br><br>
            
            <!-- Display donation table through donation_history_pagination.php with AJAX -->
            <div class='table-responsive' id='pagination'>
            </div>

            <br>

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

<script>  
// AJAX script
 $(document).ready(function(){  
      load_data();  
      function load_data(page)  
      {  
           $.ajax({  
                url:"donation_history_pagination.php",  
                method:"POST",  
                data:{page:page},  
                success:function(data){  
                     $('#pagination').html(data);  
                }  
           })  
      }  
      $(document).on('click', '.pagination-link', function(){  
           var page = $(this).attr("id");  
           load_data(page);  
      });  
 });  
 </script>  