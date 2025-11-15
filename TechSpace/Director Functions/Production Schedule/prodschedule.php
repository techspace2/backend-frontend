<?php 
include 'connect.php';
session_start();
$del= "";

// INSERT TASK
if (isset($_POST['btnadd'])) {
    $Name = mysqli_real_escape_string($conn, $_POST['txtitem']);
    $details = mysqli_real_escape_string($conn, $_POST['txtdetails']);
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);
    $id = $_SESSION['LoginID'];

    $sql = "INSERT INTO ProductionSchedule (PScheduleItem, PScheduleDetails, PScheduleDate , DirectorId) VALUES ('$Name', '$details', '$date' ,'$id')";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $_SESSION['message'] = "Production Schedule Added Successfully";
    } else {
        $_SESSION['message'] = "Failed to Add Production Schedule";
    }
    
}

// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM ProductionSchedule WHERE PScheduleID = '$taskID'");
    echo "<script>localStorage.setItem('scrollPosition', window.scrollY);</script>";
    header("Location: prodschedule.php");
    exit();
}

// FETCH TASK DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM ProductionSchedule WHERE PScheduleID = '$taskID'");
    $edit_task = mysqli_fetch_assoc($result);
}

// UPDATE TASK
if (isset($_POST['update_task'])) {
    $scheduleID = $_POST['PScheduleID'];  // Make sure this field exists in the form
    $message = mysqli_real_escape_string($conn, $_POST['txtdetails']);
    $item = mysqli_real_escape_string($conn, $_POST['txtitem']);
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);

    // Update the task with the new details
    $sql_update = "UPDATE ProductionSchedule 
                   SET PScheduleDetails='$message', PScheduleItem='$item', PScheduleDate='$date' 
                   WHERE PScheduleID='$scheduleID'";
    
    if (mysqli_query($conn, $sql_update)) {
       
        $_SESSION['message'] = "Production Schedule Updated Successfully";
        header("Location: prodschedule.php");
        exit();
        
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production Schedule</title>
    <link rel="stylesheet" href="prod schedule.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap">

</head>
<body>
    
<script>
    function saveScrollPosition() {
        localStorage.setItem('scrollPosition', window.scrollY);
    }

    function restoreScrollPosition() {
        if (localStorage.getItem('scrollPosition') !== null) {
            window.scrollTo(0, localStorage.getItem('scrollPosition'));
            localStorage.removeItem('scrollPosition');
        }
    }

    // Save scroll position before refresh or navigation
    window.addEventListener("beforeunload", saveScrollPosition);
</script>


    <div class="container">
        <div class="body-container">
            <div class="nav-bar">
                <img class="logo-img" src="../Department Operation/01.jpg.png" alt="">
                <div class="nav-btns">
                    <a class="profile-btn" href="../../2-Director/directorhome.php">Back</a>
                </div> 
            </div>

            <div class="back1" style="font-family: 'inter', serif; margin-top:438px;">
                <div class="info">
                    <label for="">PROD. SCHEDULE AT TECHSPACE</label>
                    <h1>PRODUCTION SCHEDULE</h1>
                    <p>"Carefully planned to ensure efficient manufacturing and timely delivery of high-quality apparel. Our process includes fabric sourcing, cutting, sewing, quality control, and packaging, all aligned with strict timelines."</p>
                </div>
            </div>
        </div>
    </div>

    <br><br><br>

    <div class="container1">
        <table class="content-table" style="border-collapse: collapse; font-size:16px; margin-left:55px; margin-top:20px;">
            <thead>
                <tr style="background-color: black; color:white;">
                    <th style="text-align: center; width:100px; padding:20px;">Schedule ID</th>
                    <th style="text-align: center; width:300px; ">Production Item</th>
                    <th style="text-align: center; width:300px;">Schedule Details</th>
                    <th style="text-align: center; width:200px;">Date</th>
                    <th style="text-align: center; width:400px; padding:20px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql2 = "SELECT * FROM ProductionSchedule";
                $result2 = mysqli_query($conn, $sql2);
                if (mysqli_num_rows($result2) > 0) {
                    while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<tr style='background-color:rgba(255, 255, 255, 0.164);font-size: 20px;border-bottom:none;'>

                            <td style='text-align: center; height:90px;'>{$row['PScheduleID']}</td>
                            <td style='text-align: center;'>{$row['PScheduleItem']}</td>
                            <td style='width:700px;'>{$row['PScheduleDetails']}</td>
                            <td style='text-align: center;'>{$row['PScheduleDate']}</td>

                            <td style='width: 400px; display: flex; justify-content:center; align-items:center; gap:60px; font-size: 21px; height:90px;' >
                                <a href='?delete={$row['PScheduleID']}' class='delete-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 50px 10px 50px; border-radius: 50px; text-align: center;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                                <a href='?edit={$row['PScheduleID']}' class='option-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 65px 10px 65px; border-radius: 50px; text-align: center;'>Edit</a>
                            </td>
                        
                        </tr>";
                    }
                }
                ?>
            </tbody> 
        </table>
    </div>

   <!-- The Form Section for Editing -->
<form method="POST" action="">
    <?php if (isset($edit_task)): ?>
        <!-- Hidden input to pass the task ID for updating -->
        <input type="hidden" name="PScheduleID" value="<?= $edit_task['PScheduleID'] ?>">
    <?php endif; ?>

    <div class="main-flex" style="display: flex; flex-direction: column; flex-wrap: wrap; gap: 18px; background-color: rgb(240, 238, 238); padding: 70px; width: 48%; margin-left: 420px; border-radius: 40px; margin-top: 100px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);">
        <div class="left1" style="display: flex; align-items: center; gap: 227px; flex-wrap: wrap;">
            <label style="font-size: 28px;">Date</label>
            <input type="date" name="txtdate" value="<?= isset($edit_task) ? $edit_task['PScheduleDate'] : '' ?>" style="width: 380px; height: 55px; padding-left: 10px; font-size: 20px;outline: none; border: none; border-radius: 10px; background-color: rgb(255, 255, 255);">
        </div>
        <br>

        <div class="left1" style="display: flex; align-items: center; gap: 80px; flex-wrap: wrap;">
            <label style="font-size: 28px;">Production Item</label>
            <input type="text" name="txtitem" value="<?= isset($edit_task) ? $edit_task['PScheduleItem'] : '' ?>" style="width: 380px; height: 55px; padding-left: 10px; font-size: 20px; outline: none; border: none; border-radius: 10px; background-color: rgb(255, 255, 255);">
        </div>
        <br>

        <label style="font-size: 28px;">Production Schedule Details </label><br><br>
        <textarea name="txtdetails" style="width: 900px; height: 300px; padding-left: 10px; padding-top: 10px; font-size: 20px; outline: none; border: none; border-radius: 10px; background-color: rgb(255, 255, 255);" placeholder="Write Production Schedule Info..."><?= isset($edit_task) ? $edit_task['PScheduleDetails'] : '' ?></textarea>
        <br>

        <div class="crud-btn" style="display: flex; flex-wrap: wrap; gap: 60px; align-items: center; justify-content: center;">
            <input type="submit" name="btnadd" value="ADD" style="background-color: black; color: white; width: 200px; height: 55px; font-size: 20px; border: none; border-radius: 40px; cursor: pointer;">
            <?php if (isset($edit_task)): ?>
                <input type="submit" name="update_task" value="UPDATE" style="background-color: black; color: white; width: 200px; height: 55px; font-size: 20px; border: none; border-radius: 5px; cursor: pointer;">
            <?php endif; ?>

            <div style="text-align: center;">
                            <?php 
                if (isset($_SESSION['message'])) {
                    echo "<p style='color: green; text-align: center; font-size: 20px; font-weight: bold;'>{$_SESSION['message']}</p>";
                    unset($_SESSION['message']); // Clear the message after displaying
                }
                ?>

            </div>

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