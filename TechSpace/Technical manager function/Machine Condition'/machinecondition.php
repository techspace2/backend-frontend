<?php
include 'connect.php';
session_start();

// INSERT TASK
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnassign'])) {
    $midd = mysqli_real_escape_string($conn, $_POST['txtid']);
    $name = mysqli_real_escape_string($conn, $_POST['txtname']);
    $status = mysqli_real_escape_string($conn, $_POST['txtstatus']); 
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);
    $id = $_SESSION['LoginID'];

    $sql = "INSERT INTO machinecondition (MachineID, MachineName, MachineCondition, MCheckDate, technicalmanagerId) 
            VALUES ('$midd','$name', '$status', '$date','$id')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = "Machine Condition Added Successfully";
    } else {
        $_SESSION['message'] = "Machine not Assigned";
    }

    header("Location: machinecondition.php");
    exit();
}

// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM machinecondition WHERE MCID = '$taskID'");
    header("Location: machinecondition.php");
    exit();
}

// FETCH TASK DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM machinecondition WHERE MCID = '$taskID'");
    $edit_task = mysqli_fetch_assoc($result);
}

// UPDATE TASK
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_task'])) {
    $taskID = $_POST['taskID'];
    $midd = mysqli_real_escape_string($conn, $_POST['txtid']);
    $name = mysqli_real_escape_string($conn, $_POST['txtname']);
    $status = mysqli_real_escape_string($conn, $_POST['txtstatus']); 
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);

    mysqli_query($conn, "UPDATE machinecondition SET MachineName='$name', MCheckDate='$date', MachineID='$midd', MachineCondition='$status' WHERE MCID='$taskID'");

    $_SESSION['message'] = "Machine Consition Updated Successfully";

    header("Location: machinecondition.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="machine condition.css">
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
        
                    <a class="profile-btn" href="../../12-TechEngineer/techeng.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1" style=" margin-top: 432px;">
    
                <div class="info">
                    <label for="">TECHSPACE</label>
                    <h1>MACHINE CONDITIONS</h1>
                    <p>"Techspace ensures optimal machine conditions in its apparel manufacturing by maintaining regular inspections, preventive maintenance, and real-time monitoring. Our state-of-the-art machinery is calibrated for precision, efficiency, and durability, minimizing downtime and ensuring high-quality production. By adhering to strict maintenance protocols, we enhance productivity, reduce defects, and ensure seamless operations."</p>
                </div>
                
            </div>
    
        </div>

    </div>


    <div class="container1">
    <h1 style="font-size: 45px; margin-left: 100px; margin-top: 70px;"><span style="color: rgb(212, 28, 28);">Machine</span> Details</h1>

    <table class="content-table" style="border-collapse: collapse; margin-top: 70px; margin-left: 550px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
        <thead>
            <tr style="background-color: black; color:white; font-size: 20px;">
                <th style="text-align: center; padding: 20px; width:200px;">Machine  ID</th>
                <th style="text-align: center; width: 250px;">Machine Name</th>
                <th style="text-align: center; width: 250px;">Purchased Date</th>
                <th style="text-align: center; width: 250px;">Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM machinery";
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<tr style='font-size: 20px;'>
                        <td style='text-align: center; padding: 20px;'>{$row['MID']}</td>
                        <td style='text-align: center;'>{$row['MName']}</td>
                        <td style='text-align: center;'>{$row['MDate']}</td>
                        <td style='text-align: center;'>{$row['MPrice']}</td>
                    </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>


    

<div class="container">
    <h1 style="font-size: 45px; margin-left: 100px; margin-top: 170px;"><span style="color: rgb(212, 28, 28);">Equipment Condition</span> Details</h1>

    <table class="content-table" style="border-collapse: collapse; margin-top: 70px; margin-left: 250px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
        <thead>
            <tr style="background-color: black; color:white; font-size: 20px;">
                <th style="text-align: center; padding: 20px;">Machine Condition ID</th>
                <th style="text-align: center;width: 300px;">Machine ID</th>
                <th style="text-align: center; width: 200px;">Machine Name</th>
                <th style="text-align: center; width: 200px;">Condition</th>
                <th style="text-align: center; width: 200px;">Check Date</th>
                <th style="text-align: center; width: 450px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM machinecondition";
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<tr style='font-size: 20px;'>
                        <td style='text-align: center; padding: 20px;'>{$row['MCID']}</td>
                        <td style='text-align: center;'>{$row['MachineID']}</td>
                        <td style='text-align: center;'>{$row['MachineName']}</td>
                        <td style='text-align: center;'>{$row['MachineCondition']}</td>
                        <td style='text-align: center;'>{$row['MCheckDate']}</td>
                        <td style='text-align: center; padding: 20px; display: flex; align-items: center; gap: 30px; justify-content: center;'>
                            <a href='machinecondition.php?delete={$row['MCID']}' style='text-decoration: none; color: white; background-color: black; padding: 10px 40px 10px 40px; cursor: pointer; border-radius: 50px;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                            <a href='machinecondition.php?edit={$row['MCID']}' style='text-decoration: none; color: white; background-color: black; padding: 10px 55px 10px 55px; cursor: pointer; border-radius: 50px;'>Edit</a>
                        </td>
                    </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>


<div class="main-cont" style="margin-top: -400px;">

<h2 style="font-size: 45px; margin-left: 100px;"><?= isset($edit_task) ? "Edit <span style='color: rgb(212, 28, 28);'>Machinery</span>" : "Add <span style='color: rgb(212, 28, 28);'>Machinery Conditions</span>"; ?></h2>

<form method="post">
    <?php if (isset($edit_task)): ?>
        <input type="hidden" name="taskID" value="<?= $edit_task['MCID']; ?>">
    <?php endif; ?>

    <div class="main" style=" z-index: 1; display: flex; flex-direction: column;justify-content: center; gap: 35px; align-items: center; flex-wrap: wrap; background-color: rgba(217, 217, 217, 0.32);
        width: 48%; padding: 65px; border-radius: 40px; margin-left: 430px; margin-top: 100px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">

    <div class="left" style=" z-index: 1; display: flex; align-items: center; gap: 100px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Machine ID</label>
        <input type="text" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtid" value="<?= isset($edit_task) ? $edit_task['MachineID'] : ''; ?>" required>
    </div>
   
    <div class="left" style="display: flex; align-items: center; gap: 61px;">
        <label style=" font-size: 24px; color: rgb(66, 66, 66);">Machine Name</label>
        <input type="text" style=" z-index: 1; width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtname" value="<?= isset($edit_task) ? $edit_task['MachineName'] : ''; ?>" required>
    </div>
    
    <div class="left" style="display: flex; align-items: center; gap: 123px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Condition</label>
        <select name="txtstatus" style="width: 401px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" required>
            <option value="">Select Condition</option>
            <option value="Running" <?= isset($edit_task) && $edit_task['MachineCondition'] == "Running" ? "selected" : ""; ?>>Running</option>
            <option value="Overloaded" <?= isset($edit_task) && $edit_task['MachineCondition'] == "Overloaded" ? "selected" : ""; ?>>Overloaded</option>
        </select>
    </div>
   

    <div class="left" style="display: flex; align-items: center; gap: 73px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Checked Date</label>
        <input type="date" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtdate" value="<?= isset($edit_task) ? $edit_task['MCheckDate'] : ''; ?>" required>
    </div>


    <input type="submit" style="width: 250px; margin-top: 30px; height: 50px; background-color: rgb(32, 32, 32); color: rgb(255, 255, 255); border-radius: 50px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;" name="<?= isset($edit_task) ? "update_task" : "btnassign"; ?>" value="<?= isset($edit_task) ? "UPDATE" : "ADD"; ?>" >

    
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