<?php
session_start();
include 'connect.php';

$del=null;



if (isset($_POST['loginbtn'])) {
    $type = $_POST['txttype'];
    $username = $_POST['txtusername'];
    $password = $_POST['txtpassword'];

    $sql = "SELECT * FROM Login WHERE LType='$type' AND LUsername='$username' AND LPassword='$password'";
    $result = mysqli_query($conn,$sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

            $_SESSION['LType'] = $type;
            $_SESSION['LUsername'] = $username;
            $_SESSION['LPassword'] = $password;
            $_SESSION['LoginID'] = $user['StaffProfileID'];

            // Redirect based on user type
            if ($type === "Chairman") {
                header("Location: http://localhost/TechSpace/1-Chairman/chairmanhome.php");
                exit();
            }
            else if ($type ==="Director")
            {
                header("Location: http://localhost/TechSpace/2-Director/directorhome.php");
                exit();
            }
            else if($type === "General Manager")
            {
                header("Location: http://localhost/TechSpace/3-GM/gm.php");
                exit();
            }
            else if($type === "Financial Officer")
            {
                header("Location: http://localhost/TechSpace/4-FinancialOfficer/financialofficer.php");
                exit();
            }
            else if($type === "Payroll Executive")
            {
                header("Location: http://localhost/TechSpace/5-Payroll/payrollex.php");
                exit();
            }
            else if($type === "Purchasing Manager")
            {
                header("Location: http://localhost/TechSpace/6-PurchasingManager/purchasingmngr.php");
                exit();
            }
            else if($type === "Commercial Executive")
            {
                header("Location: http://localhost/TechSpace/7-CommericalEx/commercialex.php");
                exit();
            }
            else if($type === "Plant Manager")
            {
                header("Location: http://localhost/TechSpace/8-PlantManager/plantmngrhome.php");
                exit();
            }
            else if($type === "HR Manager")
            {
                header("Location: http://localhost/TechSpace/9-HR/hr.php");
                exit();
            }
            else if($type === "Stores Manager")
            {
                header("Location: http://localhost/TechSpace/10-StoresManager/stmanager.php");
                exit();
            }
            else if($type === "Buisness Development Manager")
            {
                header("Location: http://localhost/TechSpace/11-BusinessDevManager/bdm.php");
                exit();
            }
            else if($type === "Technical Manager")
            {
                header("Location: http://localhost/TechSpace/12-TechEngineer/techeng.php");
                exit();
            }
            else if($type === "CAD Engineer")
            {
                header("Location: http://localhost/TechSpace/13-CAD/cad.php");
                exit();
            }

        }
         else
        {
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
    <link rel="stylesheet" href="staff.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>


    <script type="text/javascript">
   
        document.addEventListener("DOMContentLoaded", function() {
       const form = document.getElementById('form');
       const email = document.getElementById('txtusername');
       const password = document.getElementById('txtpass');
       const type= document.getElementById('type');

       form.addEventListener('submit', function(e) {
           if (!validateInputs()) {
               e.preventDefault(); 
           }
       });

       const setError = (element, message) => {
           const inputControl = element.parentElement;
           const errorDisplay = inputControl.querySelector('.error');

           errorDisplay.innerText = message;
           errorDisplay.style.color = "red"; 
           element.style.border = "2px solid red";
           inputControl.classList.add('error');
           inputControl.classList.remove('success');
       };

       const setSuccess = (element) => {
           const inputControl = element.parentElement;
           const errorDisplay = inputControl.querySelector('.error');

           errorDisplay.innerText = '';
           errorDisplay.style.color = ""; 
            element.style.border = "2px solid green";
           inputControl.classList.add('success');
           inputControl.classList.remove('error');
       };

       const isValidEmail = (email) => {
           const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
           return re.test(email.toLowerCase());
       };


       const validateInputs = () => {
           const emailValue = email.value.trim();
           const passwordValue = password.value.trim();
           const typeValue = type.value.trim();
           let isValid = true;

           if (emailValue === '') {
               setError(email, 'Username is required');
               isValid = false;
           } 
           else if(!isValidEmail(emailValue))
           {
            setError(email, 'Provide a Valid Username');
           }
           else {
               setSuccess(email);
           }

           if (passwordValue === '') {
               setError(password, 'Password is required');
               isValid = false;
           }  else {
               setSuccess(password);
           }

           if(typeValue==="Login Type")
           {        
              setError(type, 'Type is required');
               isValid = false;
           }
           else {
               setSuccess(type);
           }

           return isValid;
       };

      
       email.addEventListener('input', validateInputs);
       password.addEventListener('input', validateInputs);
       type.addEventListener('input', validateInputs);
   });
</script>






</head>
<body>

    <form method="post" id="form">
    <!-- Logo -->
    <div class="logo" style="display:flex; align-items: center; justify-content:center;">
        <img src="01.jpg.png" alt="TechSpace Logo">
        <ul class="nav-options" style="display:flex; list-style:none; margin-left:450px;">
        <li><a href="../../../Home/Thiz/index.html">Home</a></li>
            <li><a href="../../../Non Functional/Non Functional 1/About.html">Who We Are</a></li>
            <li><a href="../../../Non Functional/Non Functional 1/Capability.html">Our Capabilities</a></li>
            <li><a href="../../../Non Functional/Sustainability/Sutain.html">Sustainability</a></li>
            <li><a href="../../../Non Functional/Careers/Careers.html">Careers</a></li>
            <li><a href="../../../Non Functional/Contact Us/contact.html">Contact Us</a></li>
           
        </ul>
    </div>

    <!-- Login Container -->
    <div class="container" style="margin-top: 110px;">
        <div class="login-box">
            <h2 style="font-size:35px;">LOGIN</h2>
            <div class="input-control">
                <select name="txttype" id="type" class="select" style="height:40px; border:none; padding-left:10px; border-radius: 8px; margin-top:40px;">
                    <option value="Login Type">Login Type</option>
                    <option value="Chairman">Chairman</option>
                    <option value="Director">Director</option>
                    <option value="General Manager">General Manager</option>
                    <option value="Financial Officer">Financial Officer</option>
                    <option value="Payroll Executive">Payroll Executive</option>
                    <option value="Purchasing Manager">Purchasing Manager</option>
                    <option value="Commercial Executive">Commercial Executive</option>
                    <option value="Plant Manager">Plant Manager</option>
                    <option value="HR Manager">HR Manager</option>
                    <option value="Stores Manager">Stores Manager</option>
                    <option value="Buisness Development Manager">Buisness Development Manager</option>
                    <option value="Technical Manager">Technical Manager</option>
                    <option value="CAD Engineer">CAD Engineer</option>
                </select>
                <div style="margin-top:10px;" class="error"></div>
            </div>
            <div class="input-control" style="margin-top: 30px;">
                <label for="txtusername">Username</label>
                <input type="text" id="txtusername" name="txtusername" style="margin-top:10px;">
                <div style="margin-top:10px;" class="error"></div>
            </div>
            
            <div class="input-control" style="margin-top: 30px;">
                <label for="txtpass">Password</label>
                <input type="password" id="txtpass" name="txtpassword" style="margin-top:10px;">
                <div style="margin-top:10px;" class="error"></div>
            </div>

            <div style="text-align: center; ">
            <?php 
             if ($del === true) {
                echo "<p style='color: red; margin-top:30px; text-align: center;'>Incorrect Username or Password</p>";
            } 
             ?>
          </div>

            <input type="submit" id="loginbtn" value="Login" name="loginbtn" style="margin-top:40px;">

        </div>
    </div>
    </form>

</body>
</html>
