<?php
include 'connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnassign'])) {
    $clientid = mysqli_real_escape_string($conn, $_POST['txtcid']);
    $name = mysqli_real_escape_string($conn, $_POST['txtname']);
    $from = mysqli_real_escape_string($conn, $_POST['txtfrom']);
    $to = mysqli_real_escape_string($conn, $_POST['txtto']);
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);
    $time = mysqli_real_escape_string($conn, $_POST['txttime']);
    $select = mysqli_real_escape_string($conn, $_POST['txtselect']);
    $contact = mysqli_real_escape_string($conn, $_POST['txtcontact']);
    $id = $_SESSION['LoginID'];

    $sql = "INSERT INTO deliveryschedule (Client_id, Name, ScheduleFrom, ScheduleTo, ShipmentDate, Time, DeliveryType, ContactNo, PlantManagerId, ChairmanId) 
            VALUES ('$clientid', '$name', '$from', '$to', '$date', '$time', '$select', '$contact', '$id', '7')";
    
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = "Delivery Schedule Added Successfully";
    } else {
        $_SESSION['message'] = "Delivery Schedule Not Assigned";
    }

    // Redirect to avoid form resubmission on refresh
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM deliveryschedule WHERE DScheduleID = '$taskID'");
    header("Location: del schedule.php");
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="del schedule.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="body-container">

            <div class="nav-bar">
    
                <img class="logo-img" src="../Machinery  Equipment/01.jpg.png" alt="">
               
                <div class="nav-btns">
        
                    <a class="profile-btn" href="../../8-PlantManager/plantmngrhome.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1">
    
                <div class="info">
                    <label for="">TECHSPACE</label>
                    <h1>DELIVERY SCHEDULE</h1>
                    <p>"Techspace ensures a seamless and timely delivery schedule to meet customer demands efficiently. Our standard processing time is 2-3 business days, with shipping times varying based on location. We offer express and standard delivery options to accommodate different needs. Customers receive real-time tracking updates to stay informed about their orders."</p>
                </div>
                
            </div>
    
        </div>

    </div>

    <!------------------------------------------------------------------------------------------------------>

    <div class="container">
    <h1 style="font-size: 45px; margin-top: 70px; margin-left: 100px;"><span style="color: rgb(221, 36, 36);">Client</span> Details</h1>

    <table class="content-table" style="border-collapse: collapse; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2); margin-top: 70px; margin-left: 400px;">
        <thead>
            <tr style="background-color: black; color:white; font-size: 20px;">
                <th style="text-align: center; padding: 20px; width: 150px;">Client ID</th>
                <th style="text-align: center; width: 340px;">Name</th>
                <th style="text-align: center; width: 340px;">Email</th>
                <th style="text-align: center; width: 250px;">Contact</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM ClientProfile";
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    // Correct concatenation of first and last name
                    echo "<tr style='font-size: 20px;'>
                       <td style='text-align: center; padding: 15px;'>{$row['ClientProfileID']}</td>
                       <td style='text-align: center;'>" . $row['CFirstName'] . ' ' . $row['CLastName'] . "</td>
                       <td style='text-align: center;'>{$row['Email']}</td>
                       <td style='text-align: center;'>{$row['CTelephoneNo']}</td>
                    </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>



     <!------------------------------------------------------------------------------------------------------>

     <div class="container">
    <h1 style="font-size: 45px; margin-top: 70px; margin-left: 100px;">Delivery <span style="color:rgb(221, 36, 36); ">Schedule</span> Details</h1>

    <table class="content-table" style="border-collapse: collapse; margin-top: 70px; margin-left: 75px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2); ">
        <thead>
            <tr style="background-color: black; color: white; font-size: 20px;">
                <th style="text-align: center; padding: 20px; width: 160px;">Schedule ID </th>
                <th style="text-align: center; width: 150px;">Client ID </th>
                <th style="text-align: center; width: 300px;">Name</th>
                <th style="text-align: center; width: 150px;">From</th>
                <th style="text-align: center; width: 200px;">To</th>
                <th style="text-align: center; width: 150px;">Date</th>
                <th style="text-align: center; width: 150px;">Time</th>
                <th style="text-align: center; width: 150px;">Type</th>
                <th style="text-align: center; width: 300px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM deliveryschedule";
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<tr style='font-size: 20px;'>
                        <td style='text-align: center; padding: 20px;'>{$row['DScheduleID']}</td>
                        <td style='text-align: center;'>{$row['Client_id']}</td>
                        <td style='text-align: center;'>{$row['Name']}</td>
                        <td style='text-align: center;'>{$row['ScheduleFrom']}</td>
                        <td style='text-align: center;'>{$row['ScheduleTo']}</td>
                        <td style='text-align: center;'>{$row['ShipmentDate']}</td>
                        <td style='text-align: center;'>{$row['Time']}</td>
                        <td style='text-align: center;'>{$row['DeliveryType']}</td>
                        <td style='text-align: center; padding: 20px;'>
                            <a href='del schedule.php?delete={$row['DScheduleID']}' style='text-decoration: none; background-color: black; color: white; padding: 10px 60px 10px 60px; border-radius: 50px;' 
                            onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a></td>
                    </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>


    <form method="post">

    
    <?php if (isset($edit_task)): ?>
        <input type="hidden" name="taskID" value="<?= $edit_task['DScheduleID']; ?>">
        <?php endif; ?>
   
    <div class="main-flex" style="z-index: 1;display: flex; flex-direction: column; justify-content: center; gap: 100px;  align-items: center; flex-wrap: wrap; background-color: rgba(217, 217, 217, 0.32);
        width: 60%; margin-left: 320px; padding: 65px; border-radius: 40px; margin-top: -400px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);" >

    <div class="main" style="z-index: 1;display: flex; justify-content: center; gap: 150px; align-items: center; flex-wrap: wrap; ">


    <div class="left11" style="z-index: 1;display: flex; flex-direction: column; align-items: center; gap: 30px;">

    <div class="left"  style="display: flex; flex-direction: column; gap: 10px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Client ID</label>
        <input type="text" style="z-index: 1;width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtcid" value="<?= isset($edit_task) ? $edit_task['PManufacturingQuantity'] : ''; ?>" required>
    </div>
   
    <div class="left"   style="display: flex; flex-direction: column; gap: 10px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Delivery Name</label>
        <input type="text" style="z-index: 1;width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtname" value="<?= isset($edit_task) ? $edit_task['ProductId'] : ''; ?>" required>
    </div>
    
    <div class="left"   style="display: flex; flex-direction: column; gap: 10px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">From</label>
        <input type="text" style="z-index: 1;width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtfrom" value="<?= isset($edit_task) ? $edit_task['PName'] : ''; ?>" required>
    </div>
    
    <div class="left"   style="display: flex; flex-direction: column; gap: 10px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">To</label>
        <input type="text" style="z-index: 1;width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtto" value="<?= isset($edit_task) ? $edit_task['PName'] : ''; ?>" required>
    </div>
    
    </div>

   
    <div class="right11" style="display: flex; flex-direction: column; align-items: center; gap: 30px;">


    <div class="left"   style="display: flex; flex-direction: column; gap: 10px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Shippment Date</label>
        <input type="date" style="z-index: 1;width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtdate" value="<?= isset($edit_task) ? $edit_task['PName'] : ''; ?>" required>
    </div>
   
    <div class="left"   style="display: flex; flex-direction: column; gap: 10px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Time</label>
        <input type="time" style="z-index: 1;width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txttime" value="<?= isset($edit_task) ? $edit_task['PName'] : ''; ?>" required>
    </div>
    
    <div class="left"   style="display: flex; flex-direction: column; gap: 10px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Type</label>
        <select name="txtselect" style="z-index: 1;width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;"  required>
            <option value="">Select Delivery Type</option>
            <option value="Standard Delivery" <?php if (isset($edit_task) && $edit_task['taskType'] == "Standard Delivery") echo "selected"; ?>>Standard Delivery</option>
            <option value="Express Delivery" <?php if (isset($edit_task) && $edit_task['taskType'] == "Express Delivery") echo "selected"; ?>>Express Delivery</option>
            <option value="Scheduled Delivery" <?php if (isset($edit_task) && $edit_task['taskType'] == "Scheduled Delivery") echo "selected"; ?>>Scheduled Delivery</option>
            <option value="Cash on Delivery" <?php if (isset($edit_task) && $edit_task['taskType'] == "Cash on Delivery") echo "selected"; ?>>Cash on Delivery</option>

        </select>
    </div>
    

    <div class="left"   style="display: flex; flex-direction: column; gap: 10px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Contact</label>
        <input type="number" style="z-index: 1;width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtcontact" value="<?= isset($edit_task) ? $edit_task['PManufacturingQuantity'] : ''; ?>" required>
    </div>

    </div>


    
    </div>

    <div class="btn">
    <input type="submit" name="btnassign"   style="width: 200px; height: 50px; background-color: rgb(32, 32, 32); color: rgb(255, 255, 255); border-radius: 20px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;">
    </div>

    <!-- Success or Error Message -->
    <?php if (isset($_SESSION['message'])): ?>
        <p style="color: green; font-weight: bold; text-align: center;"><?= $_SESSION['message']; ?></p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    

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


