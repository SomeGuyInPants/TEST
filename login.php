<?php
    session_start();

    require ('database/connect_db.php');

    if(isset($_POST['login'])) 
    {
        $username = $_POST['username'];
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit();
    }
    else 
    {
        session_unset();
    }
?>
<html>

<head>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f9f9f9;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: -1;
            background: url('images/talksick.png') center center / cover no-repeat;
            background-color: grey;
            filter: blur(50px);
            -webkit-filter: blur(50px);
            transform: scale(1.1);
        }

        /* Page Container */
        .container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            overflow: hidden;
            margin: 20px;
        }

        /* Left Section Styling */
        .left-section {
            width: 40%;
            background: linear-gradient(to bottom, #FFD700, #F0E68C);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 30px;
        }

        .left-section img {
            height: 100px;
            margin-bottom: 20px;
        }

        .left-section a {
            font-size: 18px;
            color: #000;
            text-decoration: none;
        }

        /* Right Section Styling */
        .right-section {
            width: 60%;
            background-color: #fff;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-section h2 {
            font-size: 32px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .login-details {
            margin: 15px 0 5px;
            font-size: 16px;
            color: #444;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 30px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #FFD700;
            outline: none;
        }

        .button {
            background-color: #FFD700;
            color: #333;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            margin-top: 10px;
        }

        .button:hover {
            background-color: #F0E68C;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left-section,
            .right-section {
                width: 100%;
                padding: 20px;
            }
        }
    </style>
    
    <script>

    function isLoginValid() {
        var usernameValue = document.forms['form']['username'].value;
        var passwordValue = document.forms['form']['password'].value;

        if (usernameValue.length != 0 && passwordValue.length != 0) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("login-validation").value = this.responseText; 
                }
            };
            xmlhttp.open("GET", "database/check_login.php?username="+usernameValue+"&password="+passwordValue, true);
            xmlhttp.send();
        }
    }

    var checkUsernameAndPassword = function () {
        var loginValue = document.getElementById("login-validation").value;

        if (loginValue == false) {
            username.setCustomValidity('Username or password is invalid.');
            return false; // Blocks form submission if the credentials are invalid
        }
        else if (loginValue == true) {
            username.setCustomValidity('');
            return true;
        }
    }
    </script>



    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="images/logo/favicon32.png">
</head>

<body>
    <!-- Page Container -->
    <div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <a href='index.php'>
                <img src="images/talksick.png" alt="Logo">
            </a>
            <a href='register/register1.php'><u>Don't have an account?</u></a>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <h2>Login</h2>
            <form name='form' id='form' action='login.php' method='POST' autocomplete="off">
                <div class='login-details'>Username</div>
                <input type='text' id='username' name='username' size='25' onkeyup='isLoginValid()' required>

                <div class='login-details'>Password</div>
                <input type='password' id='password' name='password' size='19' required>

                <button type='submit' class="button" name='login' onclick='checkUsernameAndPassword()'>Sign In</button>
                <input type='hidden' id='login-validation' value=''>
            </form>
        </div>
    </div>
</body>

    <script>
var username = document.getElementById("username");
    var blockPass = document.getElementById("blockPass");
    var showPass = document.getElementById("showPass");
    var password = document.getElementById("password");
    var showPassBox = document.getElementById("passBox");
	
	function isLoginValid() {
      var usernameValue = document.forms['form']['username'].value;
      var passwordValue = document.forms['form']['password'].value;

      if (usernameValue.length != 0 && passwordValue.length != 0) {
       	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("login-validation").value = this.responseText; 
            }
        };

        xmlhttp.open("GET", "database/check_login.php?username="+usernameValue+"&password="+passwordValue, true);
        xmlhttp.send();
        
        }
    }
		
    var checkUsernameAndPassword = function () {
        var loginValue = document.getElementById("login-validation").value;

        if(loginValue == false) {
            username.setCustomValidity('Username or password is invalid.');
            return false;
        }
        else if (loginValue == true){
            username.setCustomValidity('');
            console.log("Response Text: true");
            return true;
        }
    }
    

    }
    </script>

</html>
