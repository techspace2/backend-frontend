<?php  
include 'connect.php';


session_start();
$dell =null;
$deleted=null;



if (!isset($_SESSION['LUsername'])) {
    header("Location: http://localhost/TechSpace/login/login/staff/staff.php");
    exit();
}


if (!isset($_SESSION['LoginID'])) {
    die("Error: User not logged in properly.");
}

$sql = "SELECT * FROM ClientProfile WHERE ClientProfileID='" . mysqli_real_escape_string($conn, $_SESSION['LoginID']) . "'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result); 

if (!$row) {
    die("Error: No data found for user.");
}


if(isset($_POST['btnupdate']))
{   
    $id =  $_SESSION['LoginID'];
    $fname = mysqli_real_escape_string($conn,$_POST['txtfname']);
    $lname = mysqli_real_escape_string($conn,$_POST['txtlname']);
    $email = mysqli_real_escape_string($conn,$_POST['txtemail']);
    $telephone = mysqli_real_escape_string($conn,$_POST['txttel']);
    $address = mysqli_real_escape_string($conn,$_POST['txtaddress']);
    $nic = mysqli_real_escape_string($conn,$_POST['txtnic']);
    $age = mysqli_real_escape_string($conn,$_POST['txtage']);
    $gender = mysqli_real_escape_string($conn,$_POST['txtgender']);

    $sql1 = "UPDATE ClientProfile 
             SET CFirstName='$fname', CLastName='$lname', Email='$email', CTelephoneNo='$telephone', 
              CAddress='$address', CNIC='$nic', 
              CAge='$age', CGender='$gender'
    WHERE ClientProfileID='$id'";

    $result1=mysqli_query($conn,$sql1);

    if($result1) {
        $deleted = true;  
    } else {
        $deleted = false;  
    }

    mysqli_close($conn);


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
        <div class="up">
        
            <div class="avatar">
                <?php 
                
                
                include 'function.php';

               
                $img=Get_user_avatar( $_SESSION['LoginID'],$conn);
                $_SESSION["img"] = $img;   
                
                ?>
            </div>

            <style>
                .avatar {
    width: 150px; /* Set desired width */
    height: 150px; /* Set desired height */
    border-radius: 50%; /* Make it circular */
    overflow: hidden; /* Prevents overflow from non-square images */
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f0f0f0; /* Optional background color */
}

.avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures image fills the circle properly */
}

            </style>
           
    


            <div class="profile-in">
                <input type="text" class="in1" value="<?php echo htmlspecialchars($row['CFirstName'] . ' ' . $row['CLastName']); ?>" readonly>
                <input type="text" class="in1" value="<?php echo htmlspecialchars( $row['ClientProfileID']); ?>" readonly>
            </div>
        </div>

        <div class="flex">
            <div class="left">
                <div class="in3">
                    <label>First Name</label>
                    <input type="text" name="txtfname" id="txtfname" value="<?php echo htmlspecialchars($row['CFirstName']); ?>">
                    <div class="error"></div>
                </div>
                <div class="in4">
                    <label>Last Name</label>
                    <input type="text" name="txtlname" id="txtlname" value="<?php echo htmlspecialchars($row['CLastName']); ?>">
                    <div class="error"></div>
                </div>
                <div class="in5">
                    <label>Email</label>
                    <input type="text" name="txtemail" id="txtemail" value="<?php echo htmlspecialchars($row['Email']); ?>">
                    <div class="error"></div>
                </div>
                <div class="in6">
                    <label>Telephone No</label>
                    <input type="text" name="txttel" id="txttel" value="<?php echo htmlspecialchars($row['CTelephoneNo']); ?>">
                    <div class="error"></div>
                </div>
            </div>

            <div class="right">
                <div class="in8">
                    <label>Address</label>
                    <input type="text" name="txtaddress" id="txtaddress" value="<?php echo htmlspecialchars($row['CAddress']); ?>">
                    <div class="error"></div>
                </div>
                <div class="in9">
                    <label>NIC</label>
                    <input type="text" name="txtnic"  id="txtnic" value="<?php echo htmlspecialchars($row['CNIC']); ?>">
                    <div class="error"></div>
                </div>
                <div class="in10">
                    <label>Age</label>
                    <input type="text" name="txtage" id="txtage" value="<?php echo htmlspecialchars($row['CAge']); ?>">
                    <div class="error"></div>
                </div>
                <div class="in11">
                    <label>Gender</label>
                    <input type="text" name="txtgender" id="txtgender" value="<?php echo htmlspecialchars($row['CGender']); ?>">
                    <div class="error"></div>
                </div>
            </div>
        </div>
    </div>

    <div style="text-align: center; margin-top: 100px;">
            <?php 
              if (isset($deleted) && $deleted) {
                     echo '<div style="color: green; font-weight: bold;">Record Updated Successfully</div>';
              } elseif (isset($deleted) && !$deleted) {
                     echo '<div style="color: red; font-weight: bold;">Error: Record is not updated</div>';
             }

             ?>
    </div>

    <div class="btns">
        <a href="../Client/ClientHome/client.php" name="btnback">BACK</a>
    

        <!--mek hama update button ek css ek ghn -->
        <input type="submit" name="btnupdate" value="UPDATE" style="color: white; border: solid 1px; border-radius: 18px; background-color: rgb(37, 37, 37);
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
