<?php
include 'connect.php';
session_start();
$del = null;
$deleted = null;

// INSERT TASK
if (isset($_POST['btnassign'])) {
    $type = mysqli_real_escape_string($conn, $_POST['txtname']);
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);
    $id = $_SESSION['LoginID'];
    
    $sql = "INSERT INTO FactoryOperation (FOperationInfo, FOperationDate, GeneralManagerId) VALUES ('$type', '$date', '$id')";
    $del = mysqli_query($conn, $sql);
}

if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];
    
    $sql = "DELETE FROM FactoryOperation WHERE FOperationID = '$taskID'";
    if (mysqli_query($conn, $sql)) {
        echo "<script> window.location.href='factoperation.php';</script>";
    } else {
        echo "<script>alert('Error deleting task: " . mysqli_error($conn) . "');</script>";
    }
    exit(); // Ensure script stops after deletion
}


// FETCH TASK DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = $_GET['edit'];
    
    $sql = "SELECT * FROM FactoryOperation WHERE FOperationID = '$taskID'";
    $result = mysqli_query($conn, $sql);
    $edit_task = mysqli_fetch_assoc($result);
}

if (isset($_POST['update_task'])) {
    $taskID = $_POST['taskID'];
    $type = mysqli_real_escape_string($conn, $_POST['txtname']);
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);
    
    $sql = "UPDATE FactoryOperation SET FOperationInfo = '$type', FOperationDate = '$date' WHERE FOperationID = '$taskID'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Task Updated Successfully!');</script>";
       
    } else {
        echo "<script>alert('Error updating task: " . mysqli_error($conn) . "');</script>";
    }
    header("Location: factoperation.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="fact operation.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="body-container">

            <div class="nav-bar">
    
                <img class="logo-img" src="../Leave Request/01.jpg.png" alt="">
               
                <div class="nav-btns">
        
                    <a class="profile-btn" href="../../3-GM/gm.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1">
    
                <div class="info">
                    <label for="">FACT. OPERATION AT TECHSPACE</label>
                    <h1>FACTORY OPERATION</h1>
                    <p>"Techspace is a leading apparel manufacturing company known for its efficient and high-quality factory operations. Our production facility is equipped with advanced machinery and follows streamlined processes to ensure precision in cutting, stitching, and finishing."</p>
                </div>
                
            </div>
    
        </div>

    </div>

    <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

            <div class="container1">
            <h1 style="margin:70px; font-size:45px;">Factory Operations</h1>
            <table class="content-table" style="border-collapse: collapse; margin-left:200px;">

                <thead>
                    <tr style="background-color: black; color:white; font-size:20px;">
                        <th style="text-align: center; padding:23px; width:300px;">Factory Operation ID</th>
                        <th style="text-align: center;"> Operatoin Details</th>
                        <th style="text-align: center;width:300px;">Operation Date</th>
                        <th style="text-align: center;width:510px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql2 = "SELECT * FROM FactoryOperation";
                    $result2 = mysqli_query($conn, $sql2);

                    if (mysqli_num_rows($result2) > 0) {
                        while ($row = mysqli_fetch_assoc($result2)) {
                        echo "<tr style='background-color:rgba(255, 255, 255, 0.164);font-size: 23px;border-bottom:none;'>
                                    <td style='text-align: center; padding:23px; '>{$row['FOperationID']}</td>
                                    <td style='text-align: center;'>{$row['FOperationInfo']}</td>
                                    <td style='text-align: center;'>{$row['FOperationDate']}</td>
                                    <td style='width: 450px; padding:23px; display: flex; justify-content:center; align-items:center; gap:60px; font-size: 21px;' >

                                        <a href='factoperation.php?delete={$row['FOperationID']}' class='delete-btn' style='text-decoration: none; color: white; border: none; background-color: rgb(24, 23, 23);  padding: 10px 50px 10px 50px; border-radius: 50px; text-align: center;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                                        <a href='factoperation.php?edit={$row['FOperationID']}' class='option-btn' style='text-decoration: none; color: white; border: none; background-color: rgb(24, 23, 23);  padding: 10px 65px 10px 65px; border-radius: 50px; text-align: center;'>Edit</a>
                                
                                    </td>
                                </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>




        <h1 style="font-size: 45px; margin-top: 100px; margin-left:70px; color:rgba(46, 46, 46, 0.94);"><?php echo isset($edit_task) ? "Edit Task" : "Assign Task"; ?></h1>

<form method="post">

    <?php if (isset($edit_task)): ?>
        <input type="hidden" name="taskID" value="<?php echo $edit_task['FOperationID']; ?>">
    <?php endif; ?>

    <div class="main-flex">

    
        <div class="main-flex" style="display: flex; flex-direction: column; align-items: center; gap: 35px; justify-content: center; background-color: rgb(236, 233, 233); padding: 55px; width: 43%; 
        border-radius: 30px; margin-left: 480px; margin-top: 70px;box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">

            <div class="left1" style="display: flex; align-items: center; gap: 34px;">
                <label style="font-size: 28px;">Operation Name</label><br>
                <input type="text" style="width: 400px; height: 55px; font-size: 25px; padding-left: 10px; outline: none; border-radius: 10px; background-color: rgb(216, 211, 211); border: none;" name="txtname" value="<?php echo isset($edit_task) ? $edit_task['FOperationInfo'] : ''; ?>" required>
            </div>
            
            <div class="left1" style="display: flex; align-items: center; gap: 70px;">
                <label style="font-size: 28px;">Date Issue</label><br>
                <input type="date" style="width: 400px; height: 55px; font-size: 25px; padding-left: 10px; outline: none; border-radius: 10px; background-color: rgb(216, 211, 211); border: none;" name="txtdate" value="<?php echo isset($edit_task) ? $edit_task['FOperationDate'] : ''; ?>" required>
            </div>
           
            <?php if (isset($edit_task)): ?>
                <input type="submit" name="update_task" value="Update Task" class="update" style="background-color: rgb(209, 140, 11); color: white; width:270px;">
            <?php else: ?>
                <input type="submit" style="width: 300px; height: 55px; font-size: 25px; margin-top: 40px; padding-left: 10px; outline: none; border-radius: 50px; cursor: pointer; color:white; background-color: rgb(24, 23, 23); border: none;"  name="btnassign" value="Assign Task" style="background-color: black; color: white; width:370px;" >
            <?php endif; ?>

            <div style="text-align: center;">
                <?php 
                    if ($del === true) {
                        echo "<p style='color: green; margin-top: 40px; font-size: 20px;  font-weight: bold;'>Factory Operation Added Successfully</p>";
                    } elseif ($del === false) {
                        echo "<p style='color: red; font-weight: bold; margin-top: 40px; font-size: 20px;'>Insertion unsucessfull</p>";
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