<?php
include 'connect.php';
$del = null; // Initialize status
session_start();

// INSERT TASK
if (isset($_POST['btnassign'])) {
    $details = mysqli_real_escape_string($conn, $_POST['txtmessage']);
    $term = mysqli_real_escape_string($conn, $_POST['txtterm']);
    $sdate = mysqli_real_escape_string($conn, $_POST['txtsdate']);
    $edate = mysqli_real_escape_string($conn, $_POST['txtedate']);
    $sid = mysqli_real_escape_string($conn, $_POST['txtsid']);
    $id = $_SESSION['LoginID'];

    $sql = "INSERT INTO SupplierContract (SContractDetails, SContractTerm, SContractStartDate ,SContractEndDate, SupplierId, PurchasingManagerId) VALUES ('$details', '$term', '$sdate' ,'$edate','$sid','$id')";
    $result = mysqli_query($conn, $sql);

    $del = $result ? true : false;
}

// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM SupplierContract WHERE SContractID = '$taskID'");
    echo "<script>localStorage.setItem('scrollPosition', window.scrollY);</script>";
    header("Location: supcontract.php");
    exit();
}

// FETCH TASK DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM SupplierContract WHERE SContractID = '$taskID'");
    $edit_task = mysqli_fetch_assoc($result);
}

// UPDATE TASK
if (isset($_POST['update_task'])) {
    $taskID = $_POST['taskID'];
    $details = mysqli_real_escape_string($conn, $_POST['txtmessage']);
    $term = mysqli_real_escape_string($conn, $_POST['txtterm']);
    $sdate = mysqli_real_escape_string($conn, $_POST['txtsdate']);
    $edate = mysqli_real_escape_string($conn, $_POST['txtedate']);
    $sid = mysqli_real_escape_string($conn, $_POST['txtsid']);

    mysqli_query($conn, "UPDATE SupplierContract SET SContractDetails='$details', SContractTerm='$term', SContractStartDate='$sdate', SContractEndDate='$edate', SupplierId='$sid' WHERE SContractID='$taskID'");
    
    echo "<script>localStorage.setItem('scrollPosition', window.scrollY);</script>";
    header("Location: supcontract.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="sup contract.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="body-container">

            <div class="nav-bar">
    
                <img class="logo-img" src="../Supplier/01.jpg.png"alt="">
               
                <div class="nav-btns">
        
                    <a class="profile-btn" href="../../6-PurchasingManager/purchasingmngr.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1">
    
                <div class="info">
                    <label for="">CONTRACTS AT TECHSPACE</label>
                    <h1>SUPPLIER CONTRACT</h1>
                    <p>"This Supplier Contract is made between Techspace and the Supplier, outlining the terms of supply for apparel products. The Supplier agrees to provide high-quality materials and garments as per the specifications set by Techspace, ensuring compliance with industry standards and delivery timelines."</p>
                </div>
                
            </div>
    
        </div>

    </div>

    <!------------------------------------------------------------------------------------------------------>

<div class="container1">
    <h1 style="font-size: 45px; margin-top: 70px; margin-left: 100px;">Tasks</h1>
    <table class="content-table" style="border-collapse: collapse; margin-top: 70px; margin-left: 95px;">

        <thead>
            <tr style="background-color: black; color:white; font-size: 18px;">
                <th style="text-align: center; padding:20px; width:230px;">Supplier ID</th>
                <th style="text-align: center; width:250px; ">Supplier Contract ID</th>
                <th style="text-align: center; width: 250px;">Terms</th>
                <th style="text-align: center; width: 200px; ">Start Date</th>
                <th style="text-align: center; width: 200px;">End Date</th>
                <th style="text-align: center; width: 500px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM SupplierContract";
            $result2 = mysqli_query($conn, $sql2);

            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                echo "<tr style='background-color:rgba(255, 255, 255, 0.164);font-size: 20px;border-bottom:none;'>
                            <td style='text-align: center; padding: 20px; '>{$row['SupplierId']}</td>
                            <td style='text-align: center;'>{$row['SContractID']}</td>
                            <td style='text-align: center;'>{$row['SContractTerm']}</td>
                            <td style='text-align: center;'>{$row['SContractStartDate']}</td>
                             <td style='text-align: center;'>{$row['SContractEndDate']}</td>
                            <td style='width: 500px; padding: 20px; display: flex; justify-content:center; align-items:center; gap:60px; font-size: 21px;' >

                                <a href='supcontract.php?delete={$row['SContractID']}' class='delete-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 50px 10px 50px; border-radius: 50px; text-align: center;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                                <a href='supcontract.php?edit={$row['SContractID']}' class='option-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 65px 10px 65px; border-radius: 50px; text-align: center;'>Edit</a>
                           
                            </td>
                        </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>



<h2 style="font-size: 45px; margin-left: 100px; margin-top:90px;"><?php echo isset($edit_task) ? "Edit Task" : "Add <span style='color: rgb(235, 50, 50);'>Supllier</span> Contract"; ?></h2>

<form method="post">

    <?php if (isset($edit_task)): ?>
        <input type="hidden" name="taskID" value="<?php echo $edit_task['SContractID']; ?>">
    <?php endif; ?>

        <div class="main" style="display: flex; flex-direction: column;justify-content: center; gap: 35px; align-items: center; flex-wrap: wrap; background-color: rgba(217, 217, 217, 0.32);
        width: 48%; padding: 65px; border-radius: 40px; margin-left: 430px; margin-top: 100px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">



            <div class="left" style="display: flex; align-items: center; gap: 135px;">
                <label  style="font-size: 24px; color: rgb(66, 66, 66);">Supplier ID</label>
                <input type="text" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtsid" value="<?php echo isset($edit_task) ? $edit_task['SupplierId'] : ''; ?>" required>
            </div>
            
            <div class="left" style="display: flex; align-items: center; gap: 79px;">
                <label  style="font-size: 24px; color: rgb(66, 66, 66);">Contract Details</label>
                <textarea name="txtmessage" style="width: 390px; height: 155px; border-radius: 12px; font-size: 20px; padding-left: 10px; padding-top: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" placeholder="Enter your message" rows="7" required><?php echo isset($edit_task) ? $edit_task['SContractDetails'] : ''; ?></textarea>
            </div> 
       
            <div class="left" style="display: flex; align-items: center; gap: 88px;">
                <label  style="font-size: 24px; color: rgb(66, 66, 66);">Contract Terms</label>
                <input type="text" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtterm" value="<?php echo isset($edit_task) ? $edit_task['SContractTerm'] : ''; ?>" required>
            </div>
          
            <div class="left" style="display: flex; align-items: center; gap: 147px;">
                <label  style="font-size: 24px; color: rgb(66, 66, 66);">Start Date</label>
                <input type="date" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtsdate" value="<?php echo isset($edit_task) ? $edit_task['SContractStartDate'] : ''; ?>" required>
            </div>
           
            <div class="left" style="display: flex; align-items: center; gap: 156px;">
                <label  style="font-size: 24px; color: rgb(66, 66, 66);">End Date</label>
                <input type="date" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtedate" value="<?php echo isset($edit_task) ? $edit_task['SContractEndDate'] : ''; ?>" required>
            </div>
           
            <div class="btns" style="margin-top: 30px;">
            <?php if (isset($edit_task)): ?>
                <input type="submit" name="update_task" value="Update Contract" class="update" style="width: 200px; height: 50px; background-color: rgb(211, 97, 20); color: rgb(255, 255, 255); border-radius: 20px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;">
            <?php else: ?>
                <input type="submit" name="btnassign" value="Add Contract" style="width: 200px; height: 50px; background-color: rgb(31, 30, 30); color: rgb(255, 255, 255); border-radius: 20px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;" >
            <?php endif; ?>

            </div>
           
            <div style="text-align: center;">
                <?php 
                    if ($del === true) {
                        echo "<p style='color: green; margin-top: 40px; font-size: 20px;  font-weight: bold;'>Contract Addded Successfully</p>";
                    } elseif ($del === false) {
                        echo "<p style='color: red; font-weight: bold; margin-top: 40px; font-size: 20px;'>Contract not Added</p>";
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

