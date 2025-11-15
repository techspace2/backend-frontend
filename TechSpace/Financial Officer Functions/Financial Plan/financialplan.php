<?php 
include 'connect.php';
session_start();
$del = "";

if(isset($_POST['btnadd']))
{
    $name = $_POST['txtname'];
    $desc= $_POST['txtdetails'];
    $date = $_POST['txtdate'];
    $id = $_SESSION['LoginID'];

    $sql = "INSERT INTO FinancialPlan (FPlanName, FPlanDetails, FPlanDate, FinancialOfficerId) VALUES ('$name', '$desc', '$date', '$id')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $del = true;
        // Redirect to avoid resubmission on refresh
        header("Location: financialplan.php?success=1");
        exit();
    } else {
        $del = false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="financial plan.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap">

</head>
<body>

    <div class="container">
        <div class="body-container">
            <div class="nav-bar">
                <img class="logo-img" src="../Transaction Details/01.jpg.png" alt="">
                <div class="nav-btns">
                    <a class="profile-btn" href="../../4-FinancialOfficer/financialofficer.php">Back</a>
                </div>
            </div>
            <div class="back1">
                <div class="info">
                    <label for="">FINANCIAL PLAN AT TECHSPACE</label>
                    <h1>FINANCIAL PLAN</h1>
                    <p>"An innovative apparel company, focuses on sustainable growth and profitability. Our strategy includes efficient cost management, competitive pricing, and diversified revenue streams through online and offline sales."</p>
                </div>
            </div>
        </div>
    </div>

    <form method="post">
        <div class="main-flex" style="display: flex; flex-direction: column; justify-content: center; gap: 35px; align-items: center; flex-wrap: wrap; background-color: rgba(217, 217, 217, 0.32); width: 48%; padding: 60px; border-radius: 40px; margin-left: 410px; margin-top: 100px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
            <div class="left1" style="display: flex; align-items: center; gap: 80px;">
                <label style="font-size: 27px; color: rgb(66, 66, 66);">Plan Name</label>
                <input type="text" name="txtname" style="width: 400px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;">
            </div>
            <div class="left1" style="display: flex; align-items: center; gap: 126px;">
                <label style="font-size: 27px; color: rgb(66, 66, 66);">Details</label>
                <textarea name="txtdetails" id="" style="width: 400px; padding-top: 10px; height: 155px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;"></textarea>
            </div>
            <div class="left1" style="display: flex; align-items: center; gap: 155px;">
                <label style="font-size: 27px; color: rgb(66, 66, 66);">Date</label>
                <input type="Date" name="txtdate" style="width: 400px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;">
            </div>

            <div class="btn" style="margin-top: 40px;">
                <input type="submit" name="btnadd" value="ADD" style="width: 300px; height: 60px; background-color: rgb(32, 32, 32); color: rgb(255, 255, 255); border-radius: 50px; border: none; font-size: 23px; font-weight: 600; cursor: pointer;">
            </div>

            <div style="text-align: center;">
                <?php 
                    if (isset($_GET['success']) && $_GET['success'] == 1) {
                        echo "<p style='color: green; margin-top: 40px; font-size: 20px; font-weight: bold;'>Record added successfully!</p>";
                    } elseif ($del === false) {
                        echo "<p style='color: red; font-weight: bold; margin-top: 40px; font-size: 20px;'>Record not added.</p>";
                    }
                ?>
            </div>
        </div>
    </form>

    

<div class="footer" style="margin-top: 130px;">
        
        <div class="foot1">
    
            <label for="">SITE NAVIGATION</label>
            <li><a href="../../Home/Thiz/index.html">Home</a></li>
            <li><a href="../../Non Functional/Non Functional 1/About.html">Who We Are</a></li>
            <li><a href="../../Non Functional/Non Functional 1/Capability.html">Our Capabilities</a></li>
            <li><a href="../../Non Functional/Sustainability/Sutain.html">Sustainability</a></li>
            <li><a href="../../Non Functional/Careers/Careers.html">Careers</a></li>
            <li><a href="../../Non Functional/Contact Us/contact.html">Contact Us</a></li>
            <p>© Techspace (Pvt) Ltd. All rights reserved.</p>
            
        </div>
        
        <div class="foot2">
        
            <label for="">FIND US ON</label>
            <a href=""><img src="../../Home/Thiz/resource/facebook.png"><p class="fb">Facebook</p></a>
            <a href=""><img src="../../Home/Thiz/resource/twitter.png"><p class="twit">Twitter</p></a>
            <a href=""><img src="../../Home/Thiz/resource/instagram.png"><p class="insta">Instagram</p></a>
            <a href=""><img src="../../Home/Thiz/resource/linkedin.png"><p class="linkdin">Linkedin</p></a>
            <a href=""><img src="../../Home/Thiz/resource/youtube.png"><p class="yt">Youtube</p></a>
            <a href=""><img src="../../Home/Thiz/resource/tik-tok.png"><p class="tiktok">TikTok</p></a>
            
        </div>
        
        <div class="foot3">
        
            <label for="">CONTACT US</label>
            <a href=""><img src="../../Home/Thiz/resource/call.png">: <p>+(94)11 4727222</p> </a>
            <a href=""><img src="../../Home/Thiz/resource/telephone.png">: <p>+(94)11 2547252</p> </a>
            <a href=""><img src="../../Home/Thiz/resource/email.png">: <p>info@techspace.com</p> </a>
        
        </div>
        
        <div class="foot4">
        
            <label for="">VISIT US</label>
            <p>No, 25, Rheinland Place, Wadduwa <br>Kaluthara, Sri Lanka.</p>
            <img src="../../Home/Thiz/resource/01.jpg.png" alt="">
                
        </div>
    
    </div>

    
<style>

.footer{
   display: flex;
   justify-content: space-around;
   font-family: "inter", serif;
   padding: 60px;
   color: white;
   list-style: none;
   flex-wrap: wrap;
   background-color: rgb(34, 34, 34);
   
}

.foot1 a{
    display: flex;
    text-decoration: none;
    color: white;
    margin: 20px;
}

.foot1 a:hover{
    color: rgb(194, 189, 189);
}

.foot1 label{
    border: none;
    border-radius: 120px;
    padding: 6px;
    background-color: rgb(131, 130, 129);
    font-size: 10pt;
}

.foot1 p{
    margin-top: 90px;
}

.foot2 a{
    display: flex;
    text-decoration: none;
    color: white;
    margin: 20px;
    align-items: center;
}

.foot2 a:hover{
    color: rgb(194, 189, 189);
}


.foot2 label{
    border: none;
    border-radius: 120px;
    padding: 6px;
    background-color: rgb(131, 130, 129);
    font-size: 10pt;
}

.foot2 p{
    margin-left: 15px;
}

.foot3 a{
    display: flex;
    text-decoration: none;
    color: white;
    margin: 20px;
    align-items: center;
}

.foot3 a:hover{
    color: rgb(194, 189, 189);
}


.foot3 label{
    border: none;
    border-radius: 120px;
    padding: 6px;
    background-color: rgb(131, 130, 129);
    font-size: 10pt;
}

.foot3 p{
    margin-left: 15px;
}

.foot4 p{
    margin: 20px;
}

.foot4 label{
    border: none;
    border-radius: 120px;
    padding: 6px;
    background-color: rgb(131, 130, 129);
    font-size: 10pt;
}

.foot4 img{
    width: 300px;
    height: 100px;
    margin-top: 250px;
}

</style>

</body>    
</html>
