<?php

include 'connect.php';
session_start();

$sql="SELECT * FROM DeliverySchedule";
$result = mysqli_query($conn,$sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Delivery Schedule.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <div class="body-container">

        <div class="nav-bar">

            <img class="logo-img" src="01.jpg.png" alt="">
           
            <div class="nav-btns">
    
                <a class="profile-btn" href="../../1-Chairman/chairmanhome.php">Back</a>
                   
            </div>
           
        </div>
    
        <div class="back1">
            <label for="">DELIVERY SCHEDULE AT TECHSPACE</label>
            <h1>For Fast & Luxury Transport</h1>
            <p>"Techspace follows a streamlined delivery schedule to ensure timely and efficient order fulfillment. Our standard delivery time for apparel orders is 5-7 business days for domestic shipments and 10-15 business days for international orders."</p>
        </div>

    </div>

    <!------------------------------------------------------------------------------------------------------------------------------------------>

    <h1 class="del-title">Delivery Schedule</h1>
   

    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        
    <div class="main">

        <div class="left">

            <input type="text" class="prod" value="<?php echo htmlspecialchars($row['Name']); ?>">
    
            <div class="from">
                <label for="">From</label>
                <input type="text"  value="<?php echo htmlspecialchars($row['ScheduleFrom']); ?>">
            </div>
        
            <div class="to">
                <label for="">To</label>
                <input type="text" value="<?php echo htmlspecialchars($row['ScheduleTo']); ?>">
            </div>
        
            <div class="del">
                <label for="">Delivery ID</label>
                <input type="text" value="<?php echo htmlspecialchars($row['DScheduleID']); ?>"> 
            </div>
       
            <div class="ship-date">
                <label for="">Shipment Date</label>
                <input type="text" value="<?php echo htmlspecialchars($row['ShipmentDate']); ?>">
            </div>
    
        </div>
    
        <div class="main-new">

            <div class="right">
        
                <div class="time">
                    <label for="">Time</label>
                    <input type="text" value="<?php echo htmlspecialchars($row['Time']); ?>">
                </div>
            
                <div class="del-type">
                    <label for="">Deliver Type</label>
                    <input type="text" value="<?php echo htmlspecialchars($row['DeliveryType']); ?>">
                </div>

                <div class="client-id">
                    <label for="">Client ID</label>
                    <input type="text" value="<?php echo htmlspecialchars($row['Client_id']); ?>">
                </div>
           
                <div class="con-no">
                    <label for="">Contact No</label>
                    <input type="text" value="<?php echo htmlspecialchars($row['ContactNo']); ?>">
                </div>
        
            </div>

        </div>
        </div>
        
        <?php endwhile; ?>
    

    <!------------------------------------------------------------------------------------------>


    <div class="footer" style="font-size: 16px;">

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
    margin-top: 100px;
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
            <a href=""><img src="../../1-Chairman/facebook.png"><p class="fb">Facebook</p></a>
            <a href=""><img src="../../1-Chairman/twitter.png"><p class="twit">Twitter</p></a>
            <a href=""><img src="../../1-Chairman/instagram.png"><p class="insta">Instagram</p></a>
            <a href=""><img src="../../1-Chairman/linkedin.png"><p class="linkdin">Linkedin</p></a>
            <a href=""><img src="../../1-Chairman/youtube.png"><p class="yt">Youtube</p></a>
            <a href=""><img src="../../1-Chairman/tik-tok.png"><p class="tiktok">TikTok</p></a>
            
        </div>
        
        <div class="foot3">
        
            <label for="">CONTACT US</label>
            <a href=""><img src="../../1-Chairman/call.png">: <p>+(94)11 4727222</p> </a>
            <a href=""><img src="../../1-Chairman/telephone.png">: <p>+(94)11 2547252</p> </a>
            <a href=""><img src="../../1-Chairman/email.png">: <p>info@techspace.com</p> </a>
        
        </div>
        
        <div class="foot4">
        
            <label for="">VISIT US</label>
            <p>No, 25, Rheinland Place, Wadduwa <br>Kaluthara, Sri Lanka.</p>
            <img src="01.jpg.png" alt="">
                
        </div>
    
    </div>

</body>    

   