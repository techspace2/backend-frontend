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

$sql = "SELECT * FROM StaffProfile WHERE StaffProfileID='" . mysqli_real_escape_string($conn, $_SESSION['LoginID']) . "'";
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
    $job = mysqli_real_escape_string($conn,$_POST['txtjob']);
    $address = mysqli_real_escape_string($conn,$_POST['txtaddress']);
    $nic = mysqli_real_escape_string($conn,$_POST['txtnic']);
    $age = mysqli_real_escape_string($conn,$_POST['txtage']);
    $gender = mysqli_real_escape_string($conn,$_POST['txtgender']);
    $date = mysqli_real_escape_string($conn,$_POST['txtdate']);


    $sql1 = "UPDATE StaffProfile 
             SET FirstName='$fname', LastName='$lname', Email='$email', TelephoneNo='$telephone', 
              JobTitle='$job', Address='$address', NIC='$nic', 
              Age='$age', Gender='$gender', 
              EnrollmentDate='$date'
    WHERE StaffProfileID='$id'";

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
    <link rel="stylesheet" href="profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<body  style="background-image: url(who-we-are-banner-pattern.webp);">
    <form method="post">

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
              
                // Assuming the 'user_avatar' column in the database stores the file path of the avatar image
                $avatarPath = htmlspecialchars($row['user_avatar']);
                echo '<img src="' . $avatarPath . '" alt="User Avatar" style="width: 300px; height: 300px; border-radius: 50%;">';
        
                ?>
            </div>

    


            <div class="profile-in">
                <input type="text" style="width: 300px;" class="in1" value="<?php echo htmlspecialchars($row['FirstName'] . ' ' . $row['LastName']); ?>" readonly>
                <input type="text" style="width: 200px;" class="in2" value="<?php echo htmlspecialchars($_SESSION['LType']); ?>" readonly>
            </div>
        </div>

        <div class="flex">
            <div class="left">
                <div class="in3">
                    <label>First Name</label>
                    <input type="text" name="txtfname" value="<?php echo htmlspecialchars($row['FirstName']); ?>">
                </div>
                <div class="in4">
                    <label>Last Name</label>
                    <input type="text" name="txtlname" value="<?php echo htmlspecialchars($row['LastName']); ?>">
                </div>
                <div class="in5">
                    <label>Email</label>
                    <input type="text" name="txtemail" value="<?php echo htmlspecialchars($row['Email']); ?>">
                </div>
                <div class="in6">
                    <label>Telephone No</label>
                    <input type="text" name="txttel" value="<?php echo htmlspecialchars($row['TelephoneNo']); ?>">
                </div>
                <div class="in7">
                    <label>Job Title</label>
                    <input type="text" name="txtjob" value="<?php echo htmlspecialchars($row['JobTitle']); ?>">
                </div>
            </div>

            <div class="right">
                <div class="in8">
                    <label>Address</label>
                    <input type="text" name="txtaddress" value="<?php echo htmlspecialchars($row['Address']); ?>">
                </div>
                <div class="in9">
                    <label>NIC</label>
                    <input type="text" name="txtnic" value="<?php echo htmlspecialchars($row['NIC']); ?>">
                </div>
                <div class="in10">
                    <label>Age</label>
                    <input type="text" name="txtage" value="<?php echo htmlspecialchars($row['Age']); ?>">
                </div>
                <div class="in11">
                    <label>Gender</label>
                    <input type="text" name="txtgender" value="<?php echo htmlspecialchars($row['Gender']); ?>">
                </div>
                <div class="in12">
                    <label>Enrollment Date</label>
                    <input type="text" name="txtdate" value="<?php echo htmlspecialchars($row['EnrollmentDate']); ?>">
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
        <a href="javascript:history.back()" name="btnback">BACK</a>
    

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
