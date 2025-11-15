<?php 
include 'connect.php';
session_start();

// INSERT TASK
if (isset($_POST['btnadd'])) {
    $name = mysqli_real_escape_string($conn, $_POST['txtitem']);
    $type = mysqli_real_escape_string($conn, $_POST['txttype']);
    $status = mysqli_real_escape_string($conn, $_POST['txtdetails']);
    $id = $_SESSION['LoginID'];

    $sql = "INSERT INTO CompanyOperation (COperationName, COperationType, status, DirectorId) 
            VALUES ('$name', '$type', '$status', '$id')";
    $result = mysqli_query($conn, $sql);
    
    $_SESSION['message'] = $result ? "Production Schedule Added Successfully" : "Failed to Add Production Schedule";
    header("Location: compoperation.php");
    exit();
}

// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM CompanyOperation WHERE COperationID = '$taskID'");
    header("Location: compoperation.php");
    exit();
}

// FETCH TASK DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = mysqli_real_escape_string($conn, $_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM CompanyOperation WHERE COperationID = '$taskID'");
    if ($result) {
        $edit_task = mysqli_fetch_assoc($result);
    }
}

// UPDATE TASK
if (isset($_POST['update_task'])) {
    $scheduleID = mysqli_real_escape_string($conn, $_POST['COperationID']);
    $operationName = mysqli_real_escape_string($conn, $_POST['txtitem']);
    $operationType = mysqli_real_escape_string($conn, $_POST['txttype']);
    $status = mysqli_real_escape_string($conn, $_POST['txtdetails']);

    $sql_update = "UPDATE CompanyOperation 
                   SET COperationName='$operationName', COperationType='$operationType', status='$status' 
                   WHERE COperationID='$scheduleID'";

    if (mysqli_query($conn, $sql_update)) {
        $_SESSION['message'] = "Production Schedule Updated Successfully";
        header("Location: compoperation.php");
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
    <title>Document</title>
    <link rel="stylesheet" href="comp operation.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
        
            <div class="back1">
    
                <div class="info">
                    <label for="">COMP. OPERATION AT TECHSPACE</label>
                    <h1>COMPANY OPERATION</h1>
                    <p>"We streamline production processes while maintaining exceptional quality standards. Techspace is committed to delivering stylish, performance-driven apparel that enhances everyday experiences."</p>
                </div>
                
            </div>
    
        </div>

    </div>

    <!------------------------------------------------------------------------------------------------------------------------------>
   
    <div class="container1">
    <table class="content-table" style="border-collapse: collapse; margin-left:60px;margin-top:100px;">
        <thead>
            <tr style="background-color: black; color:white; font-size: 18px;">
                <th style="text-align: center; padding:20px;">Operation ID</th>
                <th style="text-align: center;">Company Operation Name</th>
                <th style="text-align: center;">Company Operation Type</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM CompanyOperation";
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<tr style='background-color:rgba(255, 255, 255, 0.164);font-size: 23px;border-bottom:none;'>
                            <td style='text-align: center; width:200px;display: flex; justify-content:center; align-items:center;'>{$row['COperationID']}</td>
                            <td style='text-align: center; width:500px;'>{$row['COperationName']}</td>
                            <td style='text-align: center;width:400px;display: flex; justify-content:center; align-items:center;'>{$row['COperationType']}</td>
                            <td style='text-align: center;width:200px;'>{$row['status']}</td>
                            <td style='width: 480px; display: flex; justify-content:center; align-items:center; gap:60px; font-size: 21px;margin-top:15px;'>
                                <a href='?edit={$row['COperationID']}' class='edit-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 75px 10px 75px; border-radius: 50px; text-align: center;margin-top:0px;'>Edit</a>
                                <a href='?delete={$row['COperationID']}' class='delete-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 60px 10px 60px; border-radius: 50px; text-align: center;margin-top:0px;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                            </td>
                          </tr>";
                }
            }
            ?>
        </tbody> 
    </table>
</div>


  <!-- FORM FOR ADDING & EDITING -->
<form method="POST" action="">

    <input type="hidden" name="COperationID" value="<?= isset($edit_task) ? $edit_task['COperationID'] : '' ?>">

    <div class="main-flex" style="display:flex; flex-direction: column; background-color: rgb(235, 232, 232); padding:60px 30px 40px 320px;gap:20px;width:40%;margin-left:410px;border-radius: 50px;margin-top:80px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">

    <label style="font-size: 28px;">Operation Name</label>
    <input type="text" style="width:441px; height:60px; font-size: 23px; padding-left:10px; border-radius: 10px; background-color: white; outline: none; border: none;" name="txtitem" value="<?= isset($edit_task) ? $edit_task['COperationName'] : '' ?>" required>

    <label style="font-size: 28px;">Operation Type</label>
    <select name="txttype" style="width:450px; font-size: 23px; padding-left:10px; height:60px; border-radius: 10px; background-color: white; outline: none; border: none;">
        <option value="Manufacturing Operations" <?= isset($edit_task) && $edit_task['COperationType'] == 'Manufacturing Operations' ? 'selected' : '' ?>>Manufacturing Operations</option>
        <option value="Export Operations" <?= isset($edit_task) && $edit_task['COperationType'] == 'Export Operations' ? 'selected' : '' ?>>Export Operations</option>
        <option value="Support Functions" <?= isset($edit_task) && $edit_task['COperationType'] == 'Support Functions' ? 'selected' : '' ?>>Support Functions</option>
        <option value="Sales & Distribution" <?= isset($edit_task) && $edit_task['COperationType'] == 'Sales & Distribution' ? 'selected' : '' ?>>Sales & Distribution</option>
        <option value="Financial & Legal Operations" <?= isset($edit_task) && $edit_task['COperationType'] == 'Financial & Legal Operations' ? 'selected' : '' ?>>Financial & Legal Operations</option>
    </select>

    <label style="font-size: 28px;">Status</label>
    <select name="txtdetails" style="width:450px; font-size: 23px; padding-left:10px; height:60px; border-radius: 10px; background-color: white; outline: none; border: none;">
        <option value="Ongoing" <?= isset($edit_task) && $edit_task['status'] == 'Ongoing' ? 'selected' : '' ?>>Ongoing</option>
        <option value="Completed" <?= isset($edit_task) && $edit_task['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
        <option value="Pending" <?= isset($edit_task) && $edit_task['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
        <option value="In Progress" <?= isset($edit_task) && $edit_task['status'] == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
    </select>

    <button type="submit" name="btnadd" style="width:300px; height:50px; font-weight:400; background-color: black; color: white; font-size:23px; border-radius: 40px; outline:none;margin-top:30px;margin-left:80px;cursor:pointer;">ADD</button>

    </div>
  
    
    <?php if (isset($edit_task)): ?>
        <button type="submit" name="update_task">UPDATE</button>
    <?php endif; ?>
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