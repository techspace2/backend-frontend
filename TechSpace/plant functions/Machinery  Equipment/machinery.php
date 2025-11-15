<?php
include 'connect.php';
session_start();

// INSERT TASK
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnassign'])) {
    $name = mysqli_real_escape_string($conn, $_POST['txtname']);
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);
    $price = mysqli_real_escape_string($conn, $_POST['txtprice']);
    $status = mysqli_real_escape_string($conn, $_POST['txtstatus']); 
    $id = $_SESSION['LoginID'];

    $sql = "INSERT INTO Machinery (MName, MDate, MPrice, MStatus, PlantManagerId) 
            VALUES ('$name', '$date', '$price', '$status', '$id')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = "Machine Added Successfully";
    } else {
        $_SESSION['message'] = "Machine not Assigned";
    }

    header("Location: machinery.php");
    exit();
}

// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM Machinery WHERE MID = '$taskID'");
    header("Location: machinery.php");
    exit();
}

// FETCH TASK DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM Machinery WHERE MID = '$taskID'");
    $edit_task = mysqli_fetch_assoc($result);
}

// UPDATE TASK
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_task'])) {
    $taskID = $_POST['taskID'];
    $name = mysqli_real_escape_string($conn, $_POST['txtname']);
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);
    $price = mysqli_real_escape_string($conn, $_POST['txtprice']);
    $status = mysqli_real_escape_string($conn, $_POST['txtstatus']);

    mysqli_query($conn, "UPDATE Machinery SET MName='$name', MDate='$date', MPrice='$price', MStatus='$status' WHERE MID='$taskID'");

    $_SESSION['message'] = "Machine Updated Successfully";

    header("Location: machinery.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Machinery Management</title>
    <link rel="stylesheet" href="machinery.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap">

</head>
<body onload="restoreScroll()">
<div class="container">

        <div class="body-container">

            <div class="nav-bar">
    
                <img class="logo-img" src="01.jpg.png" alt="">
               
                <div class="nav-btns">
        
                    <a class="profile-btn" href="../../8-PlantManager/plantmngrhome.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1">
    
                <div class="info">
                    <label for="">TECHSPACE</label>
                    <h1>MACHINERY & EQUIPMENT</h1>
                    <p>"Techspace is a leading apparel company specializing in high-performance workwear for the machinery and equipment industry. Our products are designed for durability, comfort, and safety, ensuring that professionals stay protected in demanding environments."</p>
                </div>
                
            </div>
    
        </div>

    </div>




<div class="container">
    <h1 style="font-size: 45px; margin-left: 100px; margin-top: 70px;"><span style="color: rgb(212, 28, 28);">Equipment</span> Details</h1>

    <table class="content-table" style="border-collapse: collapse; margin-top: 70px; margin-left: 200px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
        <thead>
            <tr style="background-color: black; color:white; font-size: 20px;">
                <th style="text-align: center; padding: 20px;">Equipment ID</th>
                <th style="text-align: center;width: 300px;">Name</th>
                <th style="text-align: center; width: 200px;">Date</th>
                <th style="text-align: center; width: 200px;">Price</th>
                <th style="text-align: center; width: 200px;">Status</th>
                <th style="text-align: center; width: 450px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM Machinery";
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<tr style='font-size: 20px;'>
                        <td style='text-align: center; padding: 20px;'>{$row['MID']}</td>
                        <td style='text-align: center;'>{$row['MName']}</td>
                        <td style='text-align: center;'>{$row['MDate']}</td>
                        <td style='text-align: center;'>{$row['MPrice']}</td>
                        <td style='text-align: center;'>{$row['MStatus']}</td>
                        <td style='text-align: center; padding: 20px; display: flex; align-items: center; gap: 30px; justify-content: center;'>
                            <a href='machinery.php?delete={$row['MID']}' style='text-decoration: none; color: white; background-color: black; padding: 10px 40px 10px 40px; cursor: pointer; border-radius: 50px;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                            <a href='machinery.php?edit={$row['MID']}' style='text-decoration: none; color: white; background-color: black; padding: 10px 55px 10px 55px; cursor: pointer; border-radius: 50px;'>Edit</a>
                        </td>
                    </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>


<div class="main-cont" style="margin-top: -400px;">

<h2 style="font-size: 45px; margin-left: 100px;"><?= isset($edit_task) ? "Edit <span style='color: rgb(212, 28, 28);'>Machinery</span>" : "Add <span style='color: rgb(212, 28, 28);'>Machinery</span>"; ?></h2>

<form method="post">
    <?php if (isset($edit_task)): ?>
        <input type="hidden" name="taskID" value="<?= $edit_task['MID']; ?>">
    <?php endif; ?>

    <div class="main" style=" z-index: 1; display: flex; flex-direction: column;justify-content: center; gap: 35px; align-items: center; flex-wrap: wrap; background-color: rgba(217, 217, 217, 0.32);
        width: 48%; padding: 65px; border-radius: 40px; margin-left: 430px; margin-top: 100px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">

    <div class="left" style=" z-index: 1; display: flex; align-items: center; gap: 56px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Machine Name</label>
        <input type="text" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtname" value="<?= isset($edit_task) ? $edit_task['MName'] : ''; ?>" required>
    </div>
   
    <div class="left" style="display: flex; align-items: center; gap: 61px;">
        <label style=" font-size: 24px; color: rgb(66, 66, 66);">Purchase Date</label>
        <input type="date" style=" z-index: 1; width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtdate" value="<?= isset($edit_task) ? $edit_task['MDate'] : ''; ?>" required>
    </div>
    
    <div class="left" style="display: flex; align-items: center; gap: 156px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Status</label>
        <select name="txtstatus" style="width: 401px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" required>
            <option value="">Select Condition</option>
            <option value="Running" <?= isset($edit_task) && $edit_task['MStatus'] == "Running" ? "selected" : ""; ?>>Running</option>
            <option value="Overloaded" <?= isset($edit_task) && $edit_task['MStatus'] == "Overloaded" ? "selected" : ""; ?>>Overloaded</option>
            <option value="Stopped" <?= isset($edit_task) && $edit_task['MStatus'] == "Stopped" ? "selected" : ""; ?>>Stopped</option>
            <option value="Contaminated" <?= isset($edit_task) && $edit_task['MStatus'] == "Contaminated" ? "selected" : ""; ?>>Contaminated</option>
        </select>
    </div>
   

    <div class="left" style="display: flex; align-items: center; gap: 170px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Price</label>
        <input type="text" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtprice" value="<?= isset($edit_task) ? $edit_task['MPrice'] : ''; ?>" required>
    </div>


    <input type="submit" style="width: 250px; margin-top: 30px; height: 50px; background-color: rgb(32, 32, 32); color: rgb(255, 255, 255); border-radius: 50px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;" name="<?= isset($edit_task) ? "update_task" : "btnassign"; ?>" value="<?= isset($edit_task) ? "Update Machinery" : "Add Machinery"; ?>" >

    
    <!-- Success or Error Message -->
    <?php if (isset($_SESSION['message'])): ?>
        <p style="color: green; font-weight: bold; text-align: center;"><?= $_SESSION['message']; ?></p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>




    </div>

    
    
</form>

</div>


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
