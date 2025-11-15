<?php
include 'connect.php';
$del = null; // Initialize status
session_start();

// INSERT TASK
if (isset($_POST['btnassign'])) {
    $name = mysqli_real_escape_string($conn, $_POST['txtname']);
    $quantity = mysqli_real_escape_string($conn, $_POST['txtquantity']);
    $price = mysqli_real_escape_string($conn, $_POST['txtprice']);
    $status = mysqli_real_escape_string($conn, $_POST['txtstatus']);
    $sid = mysqli_real_escape_string($conn, $_POST['txtsid']);
    $id = $_SESSION['LoginID'];

    $sql = "INSERT INTO PurchaseOrder (POrderName, POrderQuantity, POrderPrice , POrderStatus,SupplierId, PurchasingManagerId) VALUES ('$name', '$quantity', '$price' ,'$status','$sid','$id')";
    $result = mysqli_query($conn, $sql);

    $del = $result ? true : false;
}

// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM PurchaseOrder WHERE POrderID = '$taskID'");
    echo "<script>localStorage.setItem('scrollPosition', window.scrollY);</script>";
    header("Location: purchorders.php");
    exit();
}

// FETCH TASK DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM PurchaseOrder WHERE POrderID = '$taskID'");
    $edit_task = mysqli_fetch_assoc($result);
}

// UPDATE TASK
if (isset($_POST['update_task'])) {
    $taskID = $_POST['taskID'];
    $name = mysqli_real_escape_string($conn, $_POST['txtname']);
    $quantity = mysqli_real_escape_string($conn, $_POST['txtquantity']);
    $price = mysqli_real_escape_string($conn, $_POST['txtprice']);
    $status = mysqli_real_escape_string($conn, $_POST['txtstatus']);
    $sid = mysqli_real_escape_string($conn, $_POST['txtsid']);

    mysqli_query($conn, "UPDATE PurchaseOrder SET POrderName='$name', POrderQuantity='$quantity', POrderPrice='$price' , POrderStatus='$status', SupplierId='$sid' WHERE POrderID='$taskID'");
    
    echo "<script>localStorage.setItem('scrollPosition', window.scrollY);</script>";
    header("Location: purchorders.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="purch orders.css">
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
                    <h1>PURCHASE ORDERS</h1>
                    <p>"Techspace streamlines the purchase order process to ensure a seamless supply chain for our apparel business. Our purchase orders clearly outline product details, quantities, pricing, and delivery timelines, helping us maintain efficiency and accuracy in procurement."</p>
                </div>
                
            </div>
    
        </div>

    </div>

    <!------------------------------------------------------------------------------------------------------>

    <div class="container1">
    <h1 style="font-size: 45px; margin-top: 70px; margin-left: 100px;"><span style="color: rgb(231, 48, 48);">Supplier</span> Details</h1>
    <table class="content-table" style="border-collapse: collapse; margin-top: 70px; margin-left: 50px;">

        <thead>
            <tr style="background-color: black; color:white; font-size: 18px;">
                  <th style="text-align: center; padding:20px; width: 160px;">Purchase Order ID</th>
                <th style="text-align: center;  width:200px;">Supplier ID</th>
                <th style="text-align: center; width: 350px;">Name</th>
                <th style="text-align: center; width:150px;">Quantity</th>
                <th style="text-align: center; width: 180px;">Price</th>
                <th style="text-align: center; width: 220px;">Status</th>
                <th style="text-align: center; width: 500px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM PurchaseOrder";
            $result2 = mysqli_query($conn, $sql2);

            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                echo "<tr style='background-color:rgba(255, 255, 255, 0.164);font-size: 25px;border-bottom:none;'>
                             <td style='text-align: center; padding:20px;'>{$row['POrderID']}</td>
                            <td style='text-align: center; '>{$row['SupplierId']}</td>
                            <td style='text-align: center;'>{$row['POrderName']}</td>
                            <td style='text-align: center;'>{$row['POrderQuantity']}</td>
                             <td style='text-align: center;'>{$row['POrderPrice']}</td>
                              <td style='text-align: center;'>{$row['POrderStatus']}</td>
                            <td style='width: 380px; padding: 20px; display: flex; justify-content:center; align-items:center; gap:60px; font-size: 21px;' >

                                <a href='purchorders.php?delete={$row['POrderID']}' class='delete-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 50px 10px 50px; border-radius: 50px; text-align: center;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                                <a href='purchorders.php?edit={$row['POrderID']}' class='option-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 65px 10px 65px; border-radius: 50px; text-align: center;'>Edit</a>
                           
                            </td>
                        </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<h2 style="font-size: 45px; margin-left: 100px; margin-top:90px;"><?php echo isset($edit_task) ? "Edit Task" : "Add <span style='color: rgb(231, 48, 48);'>Purchase</span> Orders"; ?></h2>

<form method="post">

    <?php if (isset($edit_task)): ?>
        <input type="hidden" name="taskID" value="<?php echo $edit_task['POrderID']; ?>">
    <?php endif; ?>

    <div class="main-flex" style="display: flex; flex-direction: column;justify-content: center; gap: 35px; align-items: center; flex-wrap: wrap; background-color: rgba(217, 217, 217, 0.32);
        width: 48%; padding: 65px; border-radius: 40px; margin-left: 430px; margin-top: 100px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">

            <div class="left" style="display: flex; align-items: center; gap: 105px;">
                <label style="font-size: 24px; color: rgb(66, 66, 66);">Supplier ID</label>
                <input type="test" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtsid" value="<?php echo isset($edit_task) ? $edit_task['SupplierId'] : ''; ?>" required> 
            </div>  
           
            <div class="left" style="display: flex; align-items: center; gap: 88px;">
                <label style="font-size: 24px; color: rgb(66, 66, 66);">Order Name</label>
                <input type="email" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtname" value="<?php echo isset($edit_task) ? $edit_task['POrderName'] : ''; ?>" required>
            </div>
            
            <div class="left" style="display: flex; align-items: center; gap: 122px;">
                <label style="font-size: 24px; color: rgb(66, 66, 66);">Quantity</label>
                <input type="text" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtquantity" value="<?php echo isset($edit_task) ? $edit_task['POrderQuantity'] : ''; ?>" required>
            </div>
            
            <div class="left" style="display: flex; align-items: center; gap: 154px;">
                <label style="font-size: 24px; color: rgb(66, 66, 66);">Price</label>
                <input type="text" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtprice" value="<?php echo isset($edit_task) ? $edit_task['POrderPrice'] : ''; ?>" required>
            </div>
            
            <div class="left" style="display: flex; align-items: center; gap: 69px;">
                <label style="font-size: 24px; color: rgb(66, 66, 66);">Order Status</label>
                <select name="txtstatus"  style="width: 400px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" required>
                    <option value="Approved" <?php if (isset($edit_task) && $edit_task['POrderStatus'] == "Approved") echo "selected"; ?>>Approved</option>
                    <option value="Not Approved" <?php if (isset($edit_task) && $edit_task['POrderStatus'] == "Not Approved") echo "selected"; ?>>Not Approved</option>
                </select>
            </div>
                    
            <div class="btns" style="margin-top: 30px;">
            <?php if (isset($edit_task)): ?>
                <input type="submit" name="update_task" value="Update Order" class="update"  style="width: 200px; height: 50px; background-color: rgb(211, 97, 20); color: rgb(255, 255, 255); border-radius: 20px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;">
            <?php else: ?>
                <input type="submit" name="btnassign" value="Add Order"  style="width: 200px; height: 50px; background-color: rgb(34, 34, 33); color: rgb(255, 255, 255); border-radius: 20px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;">
            <?php endif; ?>
            </div>
           

            <div style="text-align: center;">
                <?php 
                    if ($del === true) {
                        echo "<p style='color: green; margin-top: 40px; font-size: 20px;  font-weight: bold;'>Order Added Successfully</p>";
                    } elseif ($del === false) {
                        echo "<p style='color: red; font-weight: bold; margin-top: 40px; font-size: 20px;'>Order not Added</p>";
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

