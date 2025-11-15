<?php
include 'connect.php';
$del="";
$deleted="";

if(isset($_POST['signupbtn']))
{
    $username = $_POST['txtusername'];
    $password = $_POST['txtpassword'];
    $confpass = $_POST['txtconfpassword'];

    if($password===$confpass)
    {
            $sql="INSERT INTO ClientLogin (ClientLoginUsername,ClientLoginPassword) VALUES ('$username','$password')";
        $result = mysqli_query($conn,$sql);

        if($result==true)
        {
            
             $del=true;
            
        }
        else
        {
            $del=false;

        }
    }
    else
    {
        $deleted=true;
    }

    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp Page</title>
    <link rel="stylesheet" href="signup.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:w100..900&ght@family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    
    <script type="text/javascript">
        
   document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form");
    const email = document.getElementById("txtemail"); 
    const password = document.getElementById("txtpass");
    const confpassword = document.getElementById("txtconfpass");

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

    const validateconfPassword = () => {
        const confpasswordValue = confpassword.value.trim();
        if (confpasswordValue === "") {
            setError(confpassword, "Confirmation Password is required");
            return false;
        } else {
            setSuccess(confpassword);
            return true;
        }
    };

    const validateInputs = () => {
        let isEmailValid = validateEmail();
        let isPasswordValid = validatePassword();
        let isconfPasswordValid = validateconfPassword();
        return isEmailValid && isPasswordValid && isconfPasswordValid;
    };

    email.addEventListener("input", validateEmail);
    password.addEventListener("input", validatePassword);
    confpassword.addEventListener("input", validateconfPassword);
});

</script>
    
</head>
<body>


    

    <!-- Logo -->
    <div class="logo" style="display:flex; align-items: center; justify-content:center;">

        <img src="01.jpg.png" alt="TechSpace Logo" style="width:280px; height:100px;margin-left:20px;">

        <ul class="nav-options" style="display:flex; list-style:none; margin-left:450px;">
        <li><a href="../../../Home/Thiz/index.html">Home</a></li>
            <li><a href="../../../Non Functional/Non Functional 1/About.html">Who We Are</a></li>
            <li><a href="../../../Non Functional/Non Functional 1/Capability.html">Our Capabilities</a></li>
            <li><a href="../../../Non Functional/Sustainability/Sutain.html">Sustainability</a></li>
            <li><a href="../../../Non Functional/Careers/Careers.html">Careers</a></li>
            <li><a href="../../../Non Functional/Contact Us/contact.html">Contact Us</a></li>
        </ul>
    
    </div>

    <form method="post" id="form">
    <!-- Login Container -->
    <div class="container">
        <div class="login-box" style="margin-top:70px; border-radius:50px;">
            <h2>SIGN UP</h2>
            
            <div class="input-control">
                <label for="txtusername">Username</label>
                <input type="text" id="txtemail" name="txtusername">
                <div style="margin-top:10px;" class="error"></div>
            </div>
            
            <div class="input-control">
                <label for="txtpass">Password</label>
                <input type="password" id="txtpass" name="txtpassword">
                <div style="margin-top:10px;" class="error"></div>
            </div>

            <div class="input-control">
                <label for="txtpass">Confirm Password</label>
                <input type="password" id="txtconfpass" name="txtconfpassword">
                <div style="margin-top:10px;" class="error"></div>
            </div>

            <input type="submit" id="loginbtn" name="signupbtn" value="Sign Up">

            <div style="text-align: center; ">
                 <?php 
                    if ($del === true) {
                        echo "<p style='color: green; text-align: center; font-weight: bold;'>Account Sucessfully Created</p>";
                    } elseif ($del === false) {
                        echo "<p style='color: red; text-align: center; font-weight: bold;'>Account Not Created Sucessfully</p>";
                    }

                    if ($deleted === true) {
                        echo "<p style='color: red; text-align: center; font-weight: bold;'>Passwords should be identical</p>";
                    }
                    

                 ?>
             </div>
            
            <div class="forgot-password">
                <p>Already have an account ?</p>
                <a href="../ClientLogin/login.php">Log in</a>
            </div>
        </div>
    </div>
    </form>

</body>
</html>
