<?php
include 'connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnassign'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['txtfname']);
    $lname = mysqli_real_escape_string($conn, $_POST['txtlname']);
    $email = mysqli_real_escape_string($conn, $_POST['txtemail']);
    $tel = mysqli_real_escape_string($conn, $_POST['txtcontact']);
    $id = $_SESSION['LoginID'];

    
        $sql = "INSERT INTO Worker (FirstName, LastName, Email, WTelephone, HrManagerId) 
                VALUES ('$fname', '$lname', '$email', '$tel', '$id')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            $_SESSION['message'] = "Worker Added Successfully";
        } else {
            $_SESSION['message'] = "Worker not Assigned";
        }

    header("Location: worker.php");
    exit();
}


// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM Worker WHERE WorkerID = '$taskID'");
    header("Location: worker.php");
    exit();
}

// FETCH TASK DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM Worker WHERE WorkerID = '$taskID'");
    $edit_task = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_task'])) {
    $taskID = mysqli_real_escape_string($conn, $_POST['taskID']);
    $fname = mysqli_real_escape_string($conn, $_POST['txtfname']);
    $lname = mysqli_real_escape_string($conn, $_POST['txtlname']);
    $email = mysqli_real_escape_string($conn, $_POST['txtemail']);
    $tel = mysqli_real_escape_string($conn, $_POST['txtcontact']);

    $sql = "UPDATE Worker SET FirstName='$fname', LastName='$lname', Email='$email' ,WTelephone='$tel' WHERE WorkerID='$taskID'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = "Worker Updated Successfully";
    } else {
        $_SESSION['message'] = "Failed to update Worker";
    }

    header("Location: worker.php");
    exit();
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="worker.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="body-container">

            <div class="nav-bar">
    
                <img class="logo-img" src="01.jpg.png" alt="">
               
                <div class="nav-btns">
        
                    <a class="profile-btn" href="../../9-HR/hr.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1">
    
                <div class="info">
                    <label for="">WORKER AT TECHSPACE</label>
                    <h1>WORKER</h1>
                    <p>"Techspace values the dedication and skill of its apparel workers, who bring creativity and precision to every piece they produce. Their hard work ensures high-quality garments that blend innovation with style. With a commitment to excellence, they play a vital role in shaping Techspace’s reputation in the fashion industry."</p>
                </div>
                
            </div>
    
        </div>

    </div>

    <!------------------------------------------------------------------------------------------------------>


    <div class="container">
    <h1 style="font-size: 45px; margin-top: 70px; margin-left: 100px;"><span style="color: rgb(207, 19, 19);">Worker</span> Details</h1>

    <table class="content-table" style="border-collapse: collapse; margin-left:65px; margin-top: 70px;">
        <thead>
            <tr style="background-color: black; color:white; font-size: 20px;">
                <th style="text-align: center; width: 180px; padding: 20px;">Worker ID </th>
                <th style="text-align: center; width: 300px;">First Name</th>
                <th style="text-align: center; width: 300px;">Last Name</th>
                <th style="text-align: center; width: 300px;">Email</th>
                <th style="text-align: center; width: 200px;">Contact</th>
                <th style="text-align: center; width: 450px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM Worker";
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<tr style='font-size: 20px;'>
                        <td style='text-align: center;'>{$row['WorkerID']}</td>
                        <td style='text-align: center;'>{$row['FirstName']}</td>
                        <td style='text-align: center;'>{$row['LastName']}</td>
                        <td style='text-align: center;'>{$row['Email']}</td>
                        <td style='text-align: center;'>{$row['WTelephone']}</td>
                        <td style='text-align: center; display: flex; justify-content: center; align-items: center; gap: 40px; padding: 20px;'>
                            <a href='worker.php?delete={$row['WorkerID']}' style='text-decoration: none; color: white; background-color: black; padding: 10px 40px 10px 40px; cursor: pointer; border-radius: 50px;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                            <a href='worker.php?edit={$row['WorkerID']}' style='text-decoration: none; color: white; background-color: black; padding: 10px 52px 10px 52px; cursor: pointer; border-radius: 50px;'>Edit</a>
                        </td>
                    </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<h2 style="font-size: 45px; margin-top: -300px; margin-left: 100px;"><?= isset($edit_task) ? "<span style='color: rgb(207, 19, 19);'>Edit</span> Worker  Details" : "Add <span style='color: rgb(207, 19, 19);'>Worker</span> Details"; ?></h2>

<form method="post">
    <?php if (isset($edit_task)): ?>
        <input type="hidden" name="taskID" value="<?= $edit_task['WorkerID']; ?>">
        <?php endif; ?>
        
    <div class="main" style="display: flex; flex-direction: column;justify-content: center; gap: 35px; align-items: center; flex-wrap: wrap; background-color: rgba(217, 217, 217, 0.32);
        width: 48%; padding: 65px; border-radius: 40px; margin-left: 430px; margin-top: 100px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">


    <div class="left" style="display: flex; align-items: center; gap: 58px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">First Name</label>
        <input type="text" style="z-index: 1;width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;"  name="txtfname" value="<?= isset($edit_task) ? $edit_task['FirstName'] : ''; ?>" required>
    </div>
    
    <div class="left" style="display: flex; align-items: center; gap: 60px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Last Name</label>
        <input type="text" style="z-index: 1;width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtlname" value="<?= isset($edit_task) ? $edit_task['LastName'] : ''; ?>" required>
    </div>
    
    <div class="left" style="display: flex; align-items: center; gap: 120px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Email</label>
        <input type="email" style="z-index: 1;width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtemail" value="<?= isset($edit_task) ? $edit_task['Email'] : ''; ?>" required>
    </div>
   
    <div class="left" style="display: flex; align-items: center; gap: 92px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Contact</label>
        <input type="tel" style="z-index: 1;width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtcontact" value="<?= isset($edit_task) ? $edit_task['WTelephone'] : ''; ?>" required>
    </div>
    

    <input type="submit" name="<?= isset($edit_task) ? "update_task" : "btnassign"; ?>" value="<?= isset($edit_task) ? "Update Worker" : "Add Worker"; ?>" style="width: 200px; height: 50px; margin-top: 30px; background-color: rgb(32, 32, 32); color: rgb(255, 255, 255); border-radius: 50px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;">

    
    <!-- Success or Error Message -->
    <?php if (isset($_SESSION['message'])): ?>
        <p style="color: green; font-weight: bold; text-align: center;"><?= $_SESSION['message']; ?></p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>


    </div>    

   
    
</form>

<!-- JavaScript to Restore Scroll Position -->
<script>
    function restoreScroll() {
        if (localStorage.getItem('scrollPosition')) {
            window.scrollTo(0, localStorage.getItem('scrollPosition'));
            localStorage.removeItem('scrollPosition');
        }
    }
</script>




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


