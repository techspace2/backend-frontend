<?php
session_start();
include 'connect.php';

$error = array();
$del="";

if (isset($_POST['loginbutton'])) {

    $username = $_POST['txtusername'];
    $password = $_POST['txtpassword'];

   
    $sql = "SELECT * FROM ClientLogin WHERE ClientLoginUsername='$username' AND ClientLoginPassword='$password'";
    $result = mysqli_query($conn,$sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

          

             $_SESSION['LUsername'] = $username;
            $_SESSION['LPassword'] = $password;
            $_SESSION['LoginID'] = $user['ClientProfileID'];


                header("Location:  http://localhost/TechSpace/Client/ClientHome/client.php
                ");
                exit(); // Exit to prevent further code execution after redirect
            
    } else {
        
        $del=true;
    }
}


if (!empty($error)) {
    foreach ($error as $err) {
        echo '<script type="text/javascript">alert("' . $err . '");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <script type="text/javascript">

   document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form");
    const email = document.getElementById("txtemail"); 
    const password = document.getElementById("txtpass");

    form.addEventListener("submit", function (e) {
        if (!validateInputs()) {
            e.preventDefault(); 
        }
    });

    const setError = (element, message) => {
        const inputControl = element.parentElement;
        const errorDisplay = inputControl.querySelector(".error");

        errorDisplay.innerText = message;
        errorDisplay.style.color = "red"; 
        element.style.border = "2px solid red";
        inputControl.classList.add("error");
        inputControl.classList.remove("success");
    };

    const setSuccess = (element) => {
        const inputControl = element.parentElement;
        const errorDisplay = inputControl.querySelector(".error");

        errorDisplay.innerText = "";
        element.style.border = "2px solid green"; 
        inputControl.classList.add("success");
        inputControl.classList.remove("error");
    };

    const isValidEmail = (email) => {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email.toLowerCase());
    };

    const validateEmail = () => {
        const emailValue = email.value.trim();
        if (emailValue === "") {
            setError(email, "Email is required");
            return false;
        } else if (!isValidEmail(emailValue)) {
            setError(email, "Provide a valid email address");
            return false;
        } else {
            setSuccess(email);
            return true;
        }
    };

    const validatePassword = () => {
        const passwordValue = password.value.trim();
        if (passwordValue === "") {
            setError(password, "Password is required");
            return false;
        } else {
            setSuccess(password);
            return true;
        }
    };

    const validateInputs = () => {
        let isEmailValid = validateEmail();
        let isPasswordValid = validatePassword();
        return isEmailValid && isPasswordValid;
    };

    email.addEventListener("input", validateEmail);
    password.addEventListener("input", validatePassword);
});

</script>

</head>
<body>
    <form method="post" id="form">

    <!-- Logo -->
    <div class="nav-bar">
        <img src="01.jpg.png" alt="TechSpace Logo">

        <ul class="nav-options">
            <li><a href="../../../Home/Thiz/index.html">Home</a></li>
            <li><a href="../../../Non Functional/Non Functional 1/About.html">Who We Are</a></li>
            <li><a href="../../../Non Functional/Non Functional 1/Capability.html">Our Capabilities</a></li>
            <li><a href="../../../Non Functional/Sustainability/Sutain.html">Sustainability</a></li>
            <li><a href="../../../Non Functional/Careers/Careers.html">Careers</a></li>
            <li><a href="../../../Non Functional/Contact Us/contact.html">Contact Us</a></li>
        </ul>
    </div>

    <!-- Login Container -->
    <div class="container">
        <div class="login-box" style=" border-radius: 50px;">
            <h2>LOGIN</h2>
            
            <div class="input-control">
                <label for="txtusername">Username</label>
                <input type="text" id="txtemail" name="txtusername">
                <div style="margin-left: 20px; margin-top:20px;" class="error"></div>
            </div>
            
            <div class="input-control">
                <label for="txtpass">Password</label>
                <input type="password" id="txtpass" name="txtpassword">
                <div style="margin-left: 20px; margin-top:20px;" class="error"></div>
            </div>

            <input type="submit" id="loginbtn" name="loginbutton" value="Login">

            <div style="text-align: center; ">
            <?php 
             if ($del === true) {
                echo "<p style='color: red; margin-top:30px; text-align: center;'>Incorrect Username or Password</p>";
            } 
             ?>
          </div>
            
            <div class="forgot-password">
                <p>Don't have a account ?</p>
                <a href="../ClientSignup/signup.php">Sign Up</a>
            </div>
        </div>
    </div>
    </form>

</body>
</html>
