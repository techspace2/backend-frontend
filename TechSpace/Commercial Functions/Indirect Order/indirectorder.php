<?php
include 'connect.php';
$del = null; // Initialize status
session_start();

// INSERT TASK
if (isset($_POST['btnassign'])) {
    $desc = mysqli_real_escape_string($conn, $_POST['txtdesc']);
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);
    $price = mysqli_real_escape_string($conn, $_POST['txtprice']);
    $quan = mysqli_real_escape_string($conn, $_POST['txtquan']); 
    $id = $_SESSION['LoginID'];

    $sql = "INSERT INTO IndirectOrder (InOrderDesc, InOrderDate, InOrderPrice , InOrderQuantity, CommercialExecutiveId) VALUES ('$desc', '$date', '$price' ,'$quan','$id')";
    $result = mysqli_query($conn, $sql);

    $del = $result ? true : false;
}

// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM IndirectOrder WHERE InOrderID = '$taskID'");
    echo "<script>localStorage.setItem('scrollPosition', window.scrollY);</script>";
    header("Location: indirectorder.php");
    exit();
}

// FETCH TASK DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM IndirectOrder WHERE InOrderID = '$taskID'");
    $edit_task = mysqli_fetch_assoc($result);
}

// UPDATE TASK
if (isset($_POST['update_task'])) {
    $taskID = $_POST['taskID'];
    $desc = mysqli_real_escape_string($conn, $_POST['txtdesc']);
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);
    $price = mysqli_real_escape_string($conn, $_POST['txtprice']);
    $quan = mysqli_real_escape_string($conn, $_POST['txtquan']); 

    mysqli_query($conn, "UPDATE IndirectOrder SET InOrderDesc='$desc', InOrderDate='$date', InOrderPrice='$price' , InOrderQuantity='$quan' WHERE InOrderID='$taskID'");
    
    echo "<script>localStorage.setItem('scrollPosition', window.scrollY);</script>";
    header("Location: indirectorder.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="indirect order.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="body-container">

            <div class="nav-bar">
    
                <img class="logo-img" src="../Business Transaction/01.jpg.png" alt="">
               
                <div class="nav-btns">
        
                    <a class="profile-btn" href="../../7-CommericalEx/commercialex.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1">
    
                <div class="info">
                    <label for="">TECHSPACE</label>
                    <h1>INDIRECT ORDER</h1>
                    <p>"Techspace follows an Indirect Order process for apparel procurement, ensuring efficiency and quality control. Orders are placed through authorized suppliers, streamlining inventory management and reducing costs. This approach allows Techspace to maintain high standards while focusing on innovation and customer satisfaction."</p>
                </div>
                
            </div>
    
        </div>

    </div>

    <!------------------------------------------------------------------------------------------------------------------------------>


    
    <div class="container1">
    <h1 style="margin-left: 100px; margin-top: 70px; font-size: 45px;"><span style="color: rgb(226, 31, 31);">Supplier</span> Details</h1>
    <table class="content-table" style="margin-top: 70px; border-collapse: collapse; margin-left: 110px;">

        <thead>
            <tr style="background-color: black; color:white; font-size: 20px;">
                <th style="text-align: center; padding:20px;">Indirect Order ID</th>
                <th style="text-align: center; width: 400px;">Description</th>
                <th style="text-align: center; width: 200px;">Date</th>
                <th style="text-align: center; width: 200px;">Price</th>
                <th style="text-align: center; width: 200px;">Quantity</th>
                <th style="text-align: center; width: 450px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM IndirectOrder";
            $result2 = mysqli_query($conn, $sql2);

            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                echo "<tr style='background-color:rgba(255, 255, 255, 0.164);font-size: 20px;border-bottom:none;'>
                            <td style='text-align: center; padding: 15px; '>{$row['InOrderID']}</td>
                            <td style='text-align: center;'>{$row['InOrderDesc']}</td>
                            <td style='text-align: center;'>{$row['InOrderDate']}</td>
                            <td style='text-align: center;'>{$row['InOrderPrice']}</td>
                             <td style='text-align: center;'>{$row['InOrderQuantity']}</td>
                            <td style='width: 450px; padding: 15px; display: flex; justify-content:center; align-items:center; gap:60px; font-size: 21px;' >

                                <a href='indirectorder.php?delete={$row['InOrderID']}' class='delete-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 50px 10px 50px; border-radius: 50px; text-align: center;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                                <a href='indirectorder.php?edit={$row['InOrderID']}' class='option-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 65px 10px 65px; border-radius: 50px; text-align: center;'>Edit</a>
                           
                            </td>
                        </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>


<h2 style="font-size: 45px; margin-left: 100px; margin-top:90px;"><?php echo isset($edit_task) ? "Edit <span style='color: rgb(226, 31, 31); '>Task</span>" : "Add <span style='color: rgb(226, 31, 31); '>Indirect</span> Order"; ?></h2>

<form method="post">

    <?php if (isset($edit_task)): ?>
        <input type="hidden" name="taskID" value="<?php echo $edit_task['InOrderID']; ?>">
    <?php endif; ?>

    <div class="main-flex" style="display: flex; flex-direction: column;justify-content: center; gap: 35px; align-items: center; flex-wrap: wrap; background-color: rgba(217, 217, 217, 0.32);
        width: 48%; padding: 65px; border-radius: 40px; margin-left: 430px; margin-top: 100px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2); flex-wrap: wrap;">

            <div class="left"  style="display: flex; align-items: center; gap: 70px;">
                <label style="font-size: 24px; color: rgb(66, 66, 66);">Order Description</label>
                <input type="text"  style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtdesc" value="<?php echo isset($edit_task) ? $edit_task['InOrderDesc'] : ''; ?>" required>
            </div>
            
            <div class="left"  style="display: flex; align-items: center; gap: 210px;">
                <label style="font-size: 24px; color: rgb(66, 66, 66);">Date</label>
                <input type="date"  style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtdate" value="<?php echo isset($edit_task) ? $edit_task['InOrderDate'] : ''; ?>" required>
            </div>
            
            <div class="left"  style="display: flex; align-items: center; gap: 205px;">
                <label style="font-size: 24px; color: rgb(66, 66, 66);">Price</label>
                <input type="text"  style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtprice" value="<?php echo isset($edit_task) ? $edit_task['InOrderPrice'] : ''; ?>" required>
            </div>
           
            <div class="left"  style="display: flex; align-items: center; gap: 165px;">
                <label style="font-size: 24px; color: rgb(66, 66, 66);">Quantity</label>
                <input type="text"  style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtquan" value="<?php echo isset($edit_task) ? $edit_task['InOrderQuantity'] : ''; ?>" required>
            </div>
            
            <div class="btns" style="margin-top: 30px;">
                <?php if (isset($edit_task)): ?>
                    <input type="submit" name="update_task" value="Update Indirect Order" class="update" style="width: 260px; height: 50px; background-color: rgb(211, 97, 20); color: rgb(255, 255, 255); border-radius: 50px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;">
                <?php else: ?>
                    <input type="submit" name="btnassign" value="Add Indirect Order" style="width: 260px; height: 50px; background-color: rgb(39, 39, 39); color: rgb(255, 255, 255); border-radius: 50px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;" >
                <?php endif; ?>
            </div>
          
            <div style="text-align: center;">
                <?php 
                    if ($del === true) {
                        echo "<p style='color: green; margin-top: 40px; font-size: 20px;  font-weight: bold;'>Order Added Successfully</p>";
                    } elseif ($del === false) {
                        echo "<p style='color: red; font-weight: bold; margin-top: 40px; font-size: 20px;'>Order not Assigned</p>";
                    }
                ?>
            </div>

        </div>

    </div>

    
    
</form>

   
    <!------------------------------------------------------------------------------------------------------------------------------>

    

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