<?php  
include 'connect.php';
include 'function.php';
session_start();
$deleted = "";

if (!isset($_SESSION['LoginID']) || empty($_SESSION['LoginID'])) {
    echo "LoginID is not set or is invalid.";
    exit;  // Stop further execution if no valid LoginID
}

if(isset($_POST['btnset'])) {
   
    $fname = trim($_POST['txtfname']);
    $lname = trim($_POST['txtlname']);
    $email = trim($_POST['txtemail']);
    $tel = trim($_POST['txttel']);
    $address = trim($_POST['txtaddress']);
    $nic = trim($_POST['txtnic']);
    $age = trim($_POST['txtage']);
    $gender = trim($_POST['txtgender']);
    $id = intval($_SESSION['LoginID']); 
    
    
    if(empty($fname)) {
        $deleted = false; 
        
        echo '<div style="color: red; font-weight: bold;">Error: First Name is required to generate an avatar.</div>';
        exit;
    }


    $firstLetter = strtoupper($fname[0]);

    // Generate avatar
    $user_avatar = make_avatar($firstLetter);

   

    // Sanitize inputs to prevent SQL Injection
    $fname = mysqli_real_escape_string($conn, $fname);
    $lname = mysqli_real_escape_string($conn, $lname);
    $email = mysqli_real_escape_string($conn, $email);
    $tel = mysqli_real_escape_string($conn, $tel);
    $address = mysqli_real_escape_string($conn, $address);
    $nic = mysqli_real_escape_string($conn, $nic);
    $age = mysqli_real_escape_string($conn, $age);
    $gender = mysqli_real_escape_string($conn, $gender);
    $user_avatar = mysqli_real_escape_string($conn, $user_avatar);
    $_SESSION["img"] = $user_avatar;

    // Insert query
    $sql = "INSERT INTO ClientProfile (CFirstName, CLastName, Email, CTelephoneNo, CAddress, CNIC, CAge, CGender, login_id, user_avatar) 
            VALUES ('$fname', '$lname', '$email', '$tel', '$address', '$nic', '$age', '$gender', '$id', '$user_avatar')";
    
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $deleted = true; 
        
    } else {
        $deleted = false; 

    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="clientprofile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="advance pay.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


    <script type="text/javascript">
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form");

    // Get all input fields
    const fname = document.getElementById("txtfname");
    const lname = document.getElementById("txtlname");
    const email = document.getElementById("txtemail");
    const tel = document.getElementById("txttel");
    const address = document.getElementById("txtaddress");
    const nic = document.getElementById("txtnic");
    const age = document.getElementById("txtage");
    const gender = document.getElementById("txtgender");

    // Error handling functions
    const setError = (element, message) => {
        const inputControl = element.parentElement;
        let errorDisplay = inputControl.querySelector(".error");

        if (!errorDisplay) {
            errorDisplay = document.createElement("div");
            errorDisplay.className = "error";
            inputControl.appendChild(errorDisplay);
        }

        errorDisplay.innerText = message;
        errorDisplay.style.color = "red";
        element.style.border = "2px solid red";
        inputControl.classList.add("error");
        inputControl.classList.remove("success");
    };

    const setSuccess = (element) => {
        const inputControl = element.parentElement;
        const errorDisplay = inputControl.querySelector(".error");

        if (errorDisplay) {
            errorDisplay.innerText = "";
        }

        element.style.border = "2px solid green";
        inputControl.classList.add("success");
        inputControl.classList.remove("error");
    };

    // Validation functions
    const isValidEmail = (email) => {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email.toLowerCase());
    };

    const isValidPhoneNumber = (tel) => {
        const re = /^[0-9]{10}$/; // 10-digit phone number
        return re.test(tel);
    };

    const isValidNIC = (nic) => {
        const re = /^[0-9]{9}[VvXx]?$|^[0-9]{12}$/; // Supports old and new NIC formats
        return re.test(nic);
    };

    const isValidAge = (age) => {
        return /^\d+$/.test(age) && age >= 10 && age <= 100; // Only numbers and valid age range
    };

    const isValidGender = (gender) => {
        return ["Male", "Female", "Other"].includes(gender);
    };

    const validateField = (element, validator, errorMessage) => {
        const value = element.value.trim();
        if (value === "") {
            setError(element, "This field is required");
            return false;
        } else if (validator && !validator(value)) {
            setError(element, errorMessage);
            return false;
        } else {
            setSuccess(element);
            return true;
        }
    };

    // Apply validation
    const validateFname = () => validateField(fname, (v) => /^[a-zA-Z]+$/.test(v), "Enter a valid First Name");
    const validateLname = () => validateField(lname, (v) => /^[a-zA-Z]+$/.test(v), "Enter a valid Last Name");
    const validateEmail = () => validateField(email, isValidEmail, "Provide a valid email address");
    const validateTel = () => validateField(tel, isValidPhoneNumber, "Enter a valid 10-digit phone number");
    const validateAddress = () => validateField(address, null, "Address is required");
    const validateNIC = () => validateField(nic, isValidNIC, "Enter a valid NIC number");
    const validateAge = () => validateField(age, isValidAge, "Enter a valid age between 10 and 100");
    const validateGender = () => validateField(gender, isValidGender, "Enter Male, Female, or Other");

    const validateInputs = () => {
        return validateFname() &&
               validateLname() &&
               validateEmail() &&
               validateTel() &&
               validateAddress() &&
               validateNIC() &&
               validateAge() &&
               validateGender();
    };

    form.addEventListener("submit", function (e) {
        if (!validateInputs()) {
            e.preventDefault();
        }
    });

    // Real-time validation on input
    fname.addEventListener("input", validateFname);
    lname.addEventListener("input", validateLname);
    email.addEventListener("input", validateEmail);
    tel.addEventListener("input", validateTel);
    address.addEventListener("input", validateAddress);
    nic.addEventListener("input", validateNIC);
    age.addEventListener("input", validateAge);
    gender.addEventListener("input", validateGender);
});


</script>


</head>
<body>
    <form method="post" id="form">

    <div class="nav-bar">
        <img class="logo-img" src="01.jpg.png" alt="Logo">
        <p>Sign up and GET 20% OFF for your first order. Sign Up now</p>
        <div class="nav-btns">
            <a class="profile-btn" href="../Home/Thiz/index.html">Logout</a> <!-- Add logout link -->
        </div>
    </div>

    <div class="main">
        <div>
            <h1>Enter your Details</h1>
        </div>

        <div class="flex">
            <div class="left">
                <div class="in3">
                    <label>First Name</label>
                    <input type="text" id="txtfname" name="txtfname" placeholder="Enter your First Name">
                    <div class="error"></div>
                </div>
                <div class="in4">
                    <label>Last Name</label>
                    <input type="text" name="txtlname" id="txtlname" placeholder="Enter your Last Name">
                    <div class="error"></div>
                </div>
                <div class="in5">
                    <label>Email</label>
                    <input type="text"  id="txtemail" name="txtemail"  placeholder="Enter your Email">
                    <div class="error"></div>
                </div>
                <div class="in6">
                    <label>Telephone No</label>
                    <input type="text" name="txttel" id="txttel" placeholder="Enter your Contact">
                    <div class="error"></div>
                </div>
            </div>

            <div class="right">
                <div class="in8">
                    <label>Address</label>
                    <input type="text" name="txtaddress" id="txtaddress" placeholder="Enter your Address">
                    <div class="error"></div>
                </div>
                <div class="in9">
                    <label>NIC</label>
                    <input type="text" name="txtnic" id="txtnic" placeholder="Enter your NIC" >
                    <div class="error"></div>
                </div>
                <div class="in10">
                    <label>Age</label>
                    <input type="text" name="txtage" id="txtage" placeholder="Enter your Age">
                    <div class="error"></div>
                </div>
                <div class="in11">
                    <label>Gender</label>
                    <input type="text" name="txtgender" id="txtgender" placeholder="Enter your Gender">
                    <div class="error"></div>
                </div>
            </div>
        </div>
    </div>

    <div style="text-align: center; margin-top: 100px;">
            <?php 
              if ($deleted === true) {
                     echo '<div style="color: green; font-weight: bold;">Profile Inserted Successfully</div>';
              } elseif ($deleted === false) {
                     echo '<div style="color: red; font-weight: bold;">Error: Profile INsertion Unsucessfull</div>';
             }

             ?>
    </div>

    <div class="btns">
        <a href="../Client/ClientHome/client.php" name="btnback">BACK</a>
    

        <!--mek hama update button ek css ek ghn -->
        <input type="submit" name="btnset" value="SET" style="color: white; border: solid 1px; border-radius: 18px; background-color: rgb(37, 37, 37);
        font-size: 12pt;margin-right: 30px;width: 115px;height: 43px;padding: 10px;text-align: center; cursor: pointer;">
    </div>

    </form>

    <div class="footer">
        
        <div class="foot1">
    
            <label for="">SITE NAVIGATION</label>
            <li><a href="">Home</a></li>
            <li><a href="">Who We Are</a></li>
            <li><a href="">Our Capabilities</a></li>
            <li><a href="">Our Products</a></li>
            <li><a href="">Sustainability</a></li>
            <li><a href="">Partnerships</a></li>
            <li><a href="">Contact Us</a></li>
            <p>© Techspace (Pvt) Ltd. All rights reserved.</p>
            
        </div>
        
        <div class="foot2">
        
            <label for="">FIND US ON</label>
            <a href=""><img src="../1-Chairman/facebook.png"><p class="fb">Facebook</p></a>
            <a href=""><img src="../1-Chairman/twitter.png"><p class="twit">Twitter</p></a>
            <a href=""><img src="../1-Chairman/instagram.png"><p class="insta">Instagram</p></a>
            <a href=""><img src="../1-Chairman/linkedin.png"><p class="linkdin">Linkedin</p></a>
            <a href=""><img src="../1-Chairman/youtube.png"><p class="yt">Youtube</p></a>
            <a href=""><img src="../1-Chairman/tik-tok.png"><p class="tiktok">TikTok</p></a>
            
        </div>
        
        <div class="foot3">
        
            <label for="">CONTACT US</label>
            <a href=""><img src="../1-Chairman/call.png">: <p>+(94)11 4727222</p> </a>
            <a href=""><img src="../1-Chairman/telephone.png">: <p>+(94)11 2547252</p> </a>
            <a href=""><img src="../1-Chairman/email.png">: <p>info@techspace.com</p> </a>
        
        </div>
        
        <div class="foot4">
        
            <label for="">VISIT US</label>
            <p>No, 25, Rheinland Place, Wadduwa <br>Kaluthara, Sri Lanka.</p>
            <img src="01.jpg.png" alt="">
                
        </div>
    
    </div>

</body>
</html>
