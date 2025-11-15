<?php
include 'connect.php';
$del = null; // Initialize status
session_start();

// INSERT TASK
if (isset($_POST['btnassign'])) {
    $message = mysqli_real_escape_string($conn, $_POST['txtmessage']);
    $type = mysqli_real_escape_string($conn, $_POST['txtselect']);
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);
    $id = $_SESSION['LoginID'];

    $sql = "INSERT INTO Task (taskMessage, taskType, taskDate , ChairmanId) VALUES ('$message', '$type', '$date' ,'$id')";
    $result = mysqli_query($conn, $sql);

    $del = $result ? true : false;
}

// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM Task WHERE taskID = '$taskID'");
    echo "<script>localStorage.setItem('scrollPosition', window.scrollY);</script>";
    header("Location: task.php");
    exit();
}

// FETCH TASK DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM Task WHERE taskID = '$taskID'");
    $edit_task = mysqli_fetch_assoc($result);
}

// UPDATE TASK
if (isset($_POST['update_task'])) {
    $taskID = $_POST['taskID'];
    $message = mysqli_real_escape_string($conn, $_POST['txtmessage']);
    $type = mysqli_real_escape_string($conn, $_POST['txtselect']);
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);

    mysqli_query($conn, "UPDATE Task SET taskMessage='$message', taskType='$type', taskDate='$date' WHERE taskID='$taskID'");
    
    echo "<script>localStorage.setItem('scrollPosition', window.scrollY);</script>";
    header("Location: task.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Tasks</title>
    <link rel="stylesheet" href="task.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&display=swap" rel="stylesheet">

</head>
<body onload="restoreScrollPosition()">

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

<div class="container" >
    <div class="body-container">
        <div class="nav-bar">
            <img class="logo-img" src="01.jpg.png" alt="Logo">
            <div class="nav-btns">
                <a class="profile-btn" href="../../1-Chairman/chairmanhome.php">Back</a>
            </div>
        </div>
        <div class="back1">
            <div class="info">
                <label for="">TASKS AT TECHSPACE</label>
                <h1>Assign Tasks</h1>
                <p>Ensures smooth operations and efficiency. Each manager is responsible for overseeing their respective department, ensuring timely execution of tasks, and maintaining quality standards.</p>
            </div>
        </div>
    </div>
</div>

<div class="container1">
    <h1>Tasks</h1>
    <table class="content-table">

        <thead>
            <tr style="background-color: black; color:white;">
                <th style="text-align: center; padding:35px;">Task ID</th>
                <th style="text-align: center;">Relevant Manager</th>
                <th style="text-align: center;">Task Description</th>
                <th style="text-align: center;">Task Date</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM Task";
            $result2 = mysqli_query($conn, $sql2);

            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                echo "<tr style='background-color:rgba(255, 255, 255, 0.164);font-size: 25px;border-bottom:none;'>
                            <td style='text-align: center; '>{$row['taskID']}</td>
                            <td style='text-align: center;'>{$row['taskType']}</td>
                            <td style='text-align: center;'>{$row['taskMessage']}</td>
                            <td style='text-align: center;'>{$row['taskDate']}</td>
                            <td style='width: 380px; display: flex; justify-content:center; align-items:center; gap:60px; font-size: 21px;' >

                                <a href='task.php?delete={$row['taskID']}' class='delete-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 50px 10px 50px; border-radius: 50px; text-align: center;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                                <a href='task.php?edit={$row['taskID']}' class='option-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 65px 10px 65px; border-radius: 50px; text-align: center;'>Edit</a>
                           
                            </td>
                        </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<h2 style="font-size: 45px; margin-left: 100px; margin-top:90px;"><?php echo isset($edit_task) ? "Edit Task" : "Assign Task"; ?></h2>

<form method="post">

    <?php if (isset($edit_task)): ?>
        <input type="hidden" name="taskID" value="<?php echo $edit_task['taskID']; ?>">
    <?php endif; ?>

    <div class="main-flex">

        <div class="left">
            <label>Task Message</label><br>
            <textarea name="txtmessage" placeholder="Enter your message" rows="7" required><?php echo isset($edit_task) ? $edit_task['taskMessage'] : ''; ?></textarea><br><br>
        </div> 
    
        <div class="right">

            <label>Manager Type</label><br>
            <select name="txtselect"  required>
                <option value="">Select Manager Type</option>
                <option value="Commercial Executive" <?php if (isset($edit_task) && $edit_task['taskType'] == "Commercial Executive") echo "selected"; ?>>Commercial Executive</option>
                <option value="Purchasing Manager" <?php if (isset($edit_task) && $edit_task['taskType'] == "Purchasing Manager") echo "selected"; ?>>Purchasing Manager</option>
                <option value="HR & Compliance Manager" <?php if (isset($edit_task) && $edit_task['taskType'] == "HR & Compliance Manager") echo "selected"; ?>>HR & Compliance Manager</option>
                <option value="Payroll Executive" <?php if (isset($edit_task) && $edit_task['taskType'] == "Payroll Executive") echo "selected"; ?>>Payroll Executive</option>
                <option value="Stores Manager" <?php if (isset($edit_task) && $edit_task['taskType'] == "Stores Manager") echo "selected"; ?>>Stores Manager</option>
                <option value="Plant Manager" <?php if (isset($edit_task) && $edit_task['taskType'] == "Plant Manager") echo "selected"; ?>>Plant Manager</option>
                <option value="Business Development Manager" <?php if (isset($edit_task) && $edit_task['taskType'] == "Business Development Manager") echo "selected"; ?>>Business Development Manager</option>
                <option value="Technical Manager" <?php if (isset($edit_task) && $edit_task['taskType'] == "Technical Manager") echo "selected"; ?>>Technical Manager</option>
            </select><br><br>

            <label>Date Issue:</label><br>
            <input type="date" name="txtdate" value="<?php echo isset($edit_task) ? $edit_task['taskDate'] : ''; ?>" required><br><br>

            <?php if (isset($edit_task)): ?>
                <input type="submit" name="update_task" value="Update Task" class="update" style="background-color: rgb(209, 140, 11); color: white; width:370px;">
            <?php else: ?>
                <input type="submit" name="btnassign" value="Assign Task" style="background-color: black; color: white; width:370px;" >
            <?php endif; ?>

            <div style="text-align: center;">
                <?php 
                    if ($del === true) {
                        echo "<p style='color: green; margin-top: 40px; font-size: 20px;  font-weight: bold;'>Task Assigned Successfully</p>";
                    } elseif ($del === false) {
                        echo "<p style='color: red; font-weight: bold; margin-top: 40px; font-size: 20px;'>Task Not Assigned</p>";
                    }
                ?>
            </div>

        </div>

    </div>

    
    
</form>

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
</html>
