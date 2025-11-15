<?php
include 'connect.php';
$del = null; // Initialize status
session_start();

// INSERT TASK
if (isset($_POST['btnassign'])) {
    $details = mysqli_real_escape_string($conn, $_POST['txtmessage']);
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);
    $sid = mysqli_real_escape_string($conn, $_POST['txtsid']);
    $id = $_SESSION['LoginID'];

    $sql = "INSERT INTO SupplierIssue (SIssueDetails, IssueDate, SupplerId ,PurchasingManagerId) VALUES ('$details','$date','$sid','$id')";
    $result = mysqli_query($conn, $sql);

    $del = $result ? true : false;
}

// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM SupplierIssue WHERE SIssueID = '$taskID'");
    echo "<script>localStorage.setItem('scrollPosition', window.scrollY);</script>";
    header("Location: supplierissue.php");
    exit();
}

// FETCH TASK DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM SupplierIssue WHERE SIssueID = '$taskID'");
    $edit_task = mysqli_fetch_assoc($result);
}

// UPDATE TASK
if (isset($_POST['update_task'])) {
    $taskID = $_POST['taskID'];
    $details = mysqli_real_escape_string($conn, $_POST['txtmessage']);
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);
    $sid = mysqli_real_escape_string($conn, $_POST['txtsid']);

    mysqli_query($conn, "UPDATE SupplierIssue SET SIssueDetails='$details', IssueDate='$date', SupplerId='$sid' WHERE SIssueID='$taskID'");
    
    echo "<script>localStorage.setItem('scrollPosition', window.scrollY);</script>";
    header("Location: supplierissue.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="supplier issue.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="body-container">

            <div class="nav-bar">
    
                <img class="logo-img" src="../Supplier/01.jpg.png" alt="">
               
                <div class="nav-btns">
        
                    <a class="profile-btn" href="../../6-PurchasingManager/purchasingmngr.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1">
    
                <div class="info">
                    <label for="">TECHSPACE</label>
                    <h1>SUPPLIER ISSUE</h1>
                    <p>"Techspace is a trusted supplier of high-quality apparel, delivering innovative and stylish clothing solutions to businesses and retailers. With a commitment to excellence, we provide a diverse range of fashion and corporate wear, ensuring top-tier materials and craftsmanship."</p>
                </div>
                
            </div>
    
        </div>

    </div>

    <!------------------------------------------------------------------------------------------------------>

    <div class="container1">
    <h1 style="font-size: 45px; margin-top: 70px; margin-left: 100px;">Supllier <span style="color: rgb(221, 34, 34);">Issues</span></h1>
    <table class="content-table" style="border-collapse: collapse; margin-left: 130px; margin-top: 70px;">

        <thead>
            <tr style="background-color: black; color:white; font-size: 18px;">
                <th style="text-align: center; padding:20px; width: 160px;">Supplier ID</th>
                <th style="text-align: center; width:260px; ">Supplier Issue ID</th>
                <th style="text-align: center; width: 400px;">Details</th>
                <th style="text-align: center; width: 260px;"> Date</th>
                <th style="text-align: center; width: 470px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM SupplierIssue";
            $result2 = mysqli_query($conn, $sql2);

            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                echo "<tr style='background-color:rgba(255, 255, 255, 0.164);font-size: 20px;border-bottom:none;'>
                            <td style='text-align: center; padding: 20px;'>{$row['SupplerId']}</td>
                            <td style='text-align: center;'>{$row['SIssueID']}</td>
                            <td style='text-align: center;'>{$row['SIssueDetails']}</td>
                            <td style='text-align: center;'>{$row['IssueDate']}</td>
                            <td style='width: 470px; display: flex; padding: 20px; justify-content:center; align-items:center; gap:60px; font-size: 21px;' >

                                <a href='supplierissue.php?delete={$row['SIssueID']}' class='delete-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 50px 10px 50px; border-radius: 50px; text-align: center;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                                <a href='supplierissue.php?edit={$row['SIssueID']}' class='option-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 65px 10px 65px; border-radius: 50px; text-align: center;'>Edit</a>
                           
                            </td>
                        </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<h2 style="font-size: 45px; margin-left: 100px; margin-top:90px;"><?php echo isset($edit_task) ? "Edit Task" : "Add <span style='color:rgb(221, 34, 34);'>Supllier</span> Issues"; ?></h2>

<form method="post">

    <?php if (isset($edit_task)): ?>
        <input type="hidden" name="taskID" value="<?php echo $edit_task['SIssueID']; ?>">
    <?php endif; ?>

            <div class="main" style="display: flex; flex-direction: column;justify-content: center; gap: 35px; align-items: center; flex-wrap: wrap; background-color: rgba(217, 217, 217, 0.32);
        width: 48%; padding: 65px; border-radius: 40px; margin-left: 430px; margin-top: 100px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">

            <div class="left" style="display: flex; align-items: center; gap: 100px;">
                <label style="font-size: 24px; color: rgb(66, 66, 66);">Supplier ID</label>
                <input type="text" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtsid" value="<?php echo isset($edit_task) ? $edit_task['SupplerId'] : ''; ?>" required>
            </div>
            
            <div class="left" style="display: flex; align-items: center; gap: 79px;">
                <label style="font-size: 24px; color: rgb(66, 66, 66);">Issue Details</label>
                <textarea name="txtmessage" style="width: 390px; height: 155px; padding-top: 10px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" placeholder="Enter your message" rows="7" required><?php echo isset($edit_task) ? $edit_task['SIssueDetails'] : ''; ?></textarea>
            </div> 
    
            <div class="left" style="display: flex; align-items: center; gap: 102px;">
                <label style="font-size: 24px; color: rgb(66, 66, 66);">Issue Date</label>
                <input type="date" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtdate" value="<?php echo isset($edit_task) ? $edit_task['IssueDate'] : ''; ?>" required>
            </div>
           
            <div class="btns" style="margin-top: 30px;">      
            <?php if (isset($edit_task)): ?>
                <input type="submit" name="update_task" style="width: 200px; height: 50px; background-color: rgb(211, 97, 20); color: rgb(255, 255, 255); border-radius: 20px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;" value="Update Issue" class="update" style="background-color: rgb(209, 140, 11); color: white; width:370px;">
            <?php else: ?>
                <input type="submit" name="btnassign" style="width: 200px; height: 50px; background-color: rgb(29, 29, 28); color: rgb(255, 255, 255); border-radius: 20px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;" value="Add Issue" style="background-color: black; color: white; width:370px;" >
            <?php endif; ?>
            </div>
          

            <div style="text-align: center;">
                <?php 
                    if ($del === true) {
                        echo "<p style='color: green; margin-top: 40px; font-size: 20px;  font-weight: bold;'>Supllier Issue Successfully</p>";
                    } elseif ($del === false) {
                        echo "<p style='color: red; font-weight: bold; margin-top: 40px; font-size: 20px;'>Issue not Added</p>";
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