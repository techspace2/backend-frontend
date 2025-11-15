<?php  
include 'connect.php'; 
session_start();  

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $worker_id = $_POST['txtworkerid'];
    $amount = $_POST['txtamount'];
    $date = $_POST['txtdate'];
    $id = $_SESSION['LoginID'];

    // Check if Worker ID exists
    $check_worker = "SELECT * FROM Worker WHERE WorkerId = '$worker_id'";
    $result = mysqli_query($conn, $check_worker);

    if (mysqli_num_rows($result) == 0) {
        $_SESSION['error'] = "Worker ID not found!";
    } else {
        // Insert data if Worker ID is valid
        $query = "INSERT INTO AdvancePayment (WorkerId, ADPAmount, APDate ,PayrollId) 
                  VALUES ('$worker_id','$amount','$date' ,'$id')";

        if (mysqli_query($conn, $query)) {
            $_SESSION['success'] = "Advance Payment Added Successfully";
            header("Location: advancepay.php");
             exit();
        } else {
            $_SESSION['error'] = "Insertion unsuccessful: " . mysqli_error($conn);
            
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="advance pay.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="body-container">

            <div class="nav-bar">
    
                <img class="logo-img" src="../Cal Salary/01.jpg.png" alt="">
               
                <div class="nav-btns">
        
                    <a class="profile-btn" href="../../5-Payroll/payrollex.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1">
    
                <div class="info">
                    <label for="">ADVANCE PAYMENT AT TECHSPACE</label>
                    <h1>ADVANCE PAYMENT</h1>
                    <p>"At Techspace, we require an advance payment to initiate production and secure materials for your order. This ensures a smooth and timely manufacturing process while maintaining our commitment to quality. The advance amount will be adjusted against the final invoice."</p>
                </div>
                
            </div>
    
        </div>

    </div>

    <!------------------------------------------------------------------------------------------------------>

    <form method="POST">
    <div class="main-flex" style="display: flex; flex-direction: column;justify-content: center; gap: 35px; align-items: center; flex-wrap: wrap; background-color: rgba(217, 217, 217, 0.32);
        width: 48%; padding: 65px; border-radius: 40px; margin-left: 430px; margin-top: 100px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">

        <div class="left1" style="display: flex; align-items: center; gap: 130px;">
            <label style="font-size: 24px; color: rgb(66, 66, 66);"> Worker ID</label>
            <input type="text" name="txtworkerid" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;">
        </div>
    
        <div class="left1" style="display: flex; align-items: center; gap: 52px;">
            <label style="font-size: 24px; color: rgb(66, 66, 66);">Advance Amount</label>
            <input type="text" name="txtamount" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;">
        </div>

        <div class="left1" style="display: flex; align-items: center; gap: 190px;">
            <label style="font-size: 24px; color: rgb(66, 66, 66);">Date</label>
            <input type="date" name="txtdate" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;">
        </div>

        <div class="btn" style="margin-top: 30px;">
            <input type="submit" name="save" value="ADD ADVACNE PAYMENT" style="width: 300px; height: 50px; background-color: rgb(211, 97, 20); color: rgb(255, 255, 255); border-radius: 20px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;">
        </div>

        <div style="text-align: center;">
                <?php 
                    if (isset($_SESSION['success'])) {
                        echo "<p style='color: green; margin-top: 40px; font-size: 20px; font-weight: bold;'>{$_SESSION['success']}</p>";
                        unset($_SESSION['success']); 
                    } elseif (isset($_SESSION['error'])) {
                        echo "<p style='color: red; font-weight: bold; margin-top: 40px; font-size: 20px;'>{$_SESSION['error']}</p>";
                        unset($_SESSION['error']); 
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

