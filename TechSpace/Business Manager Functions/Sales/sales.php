<?php
include 'connect.php';
session_start();

// INSERT TASK
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnassign'])) {
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);
    $type = mysqli_real_escape_string($conn, $_POST['txtselect']);
    $pid = mysqli_real_escape_string($conn, $_POST['txtpid']);
    $pname = mysqli_real_escape_string($conn, $_POST['txtname']);
    $uprice = mysqli_real_escape_string($conn, $_POST['txtuprice']);
    $usold = mysqli_real_escape_string($conn, $_POST['txtusold']);
    $amount = mysqli_real_escape_string($conn, $_POST['txtamount']);
    $id = $_SESSION['LoginID'];

    $sql = "INSERT INTO Sales (SalesDate, SalesCategoury, productID, ProductName,ProductUnitPrice,TotalUnitsSold,TotalAmount,BusinessManagerId) 
            VALUES ('$date', '$type', '$pid','$pname','$uprice','$usold','$amount','$id')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = "Sale Added Successfully";
    } else {
        $_SESSION['message'] = "Sale not Assigned";
    }

    header("Location: sales.php");
    exit();
}

// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM Sales WHERE SalesID = '$taskID'");
    header("Location: sales.php");
    exit();
}

// FETCH TASK DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM Sales WHERE SalesID = '$taskID'");
    $edit_task = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_task'])) {
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);
    $type = mysqli_real_escape_string($conn, $_POST['txtselect']);
    $pid = mysqli_real_escape_string($conn, $_POST['txtpid']);
    $pname = mysqli_real_escape_string($conn, $_POST['txtname']);
    $uprice = mysqli_real_escape_string($conn, $_POST['txtuprice']);
    $usold = mysqli_real_escape_string($conn, $_POST['txtusold']);
    $amount = mysqli_real_escape_string($conn, $_POST['txtamount']);

    $sql = "UPDATE Sales SET SalesDate='$date', SalesCategoury='$type', productID='$pid', ProductName='$pname', ProductUnitPrice='$uprice', TotalUnitsSold='$usold', 
    TotalAmount='$amount' WHERE SalesID='$taskID'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = "Sale Updated Successfully";
    } else {
        $_SESSION['message'] = "Failed to update Sale";
    }

    header("Location: sales.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="sales.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <script>
    function calculateTotal() {
        // Get input values
        let unitPrice = parseFloat(document.querySelector('input[name="txtuprice"]').value);
        let unitsSold = parseFloat(document.querySelector('input[name="txtusold"]').value);

        // Ensure values are valid numbers
        if (!isNaN(unitPrice) && !isNaN(unitsSold)) {
            let totalAmount = unitPrice * unitsSold;
            document.querySelector('input[name="txtamount"]').value = totalAmount.toFixed(2);
        } else {
            alert("Please enter valid numeric values for Unit Price and Units Sold.");
        }
    }
</script>


</head>
<body>

    <div class="container">

        <div class="body-container">

            <div class="nav-bar">
    
                <img class="logo-img" src="01.jpg.png" alt="">
               
                <div class="nav-btns">
        
                    <a class="profile-btn" href="../../11-BusinessDevManager/bdm.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1">
    
                <div class="info">
                    <label for="">SALES AT TECHSPACE</label>
                    <h1>SALES</h1>
                    <p>"Techspace offers a stylish and innovative range of apparel designed for modern professionals. Our collection blends comfort, quality, and cutting-edge fashion to meet the needs of every customer. With a focus on premium materials and trend-driven designs, Techspace ensures a perfect balance of functionality and style."</p>
                </div>
                
            </div>
    
        </div>

    </div>

    <!------------------------------------------------------------------------------------------------------>
    <div class="container">
    <h1 style="font-size: 45px; margin-top: 70px; margin-left: 100px;"><span style="color: rgb(209, 20, 20);">Product</span> Details</h1>

    <table class="content-table" style="border-collapse: collapse; font-size: 20px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2); margin-top: 70px; margin-left: 400px;">
        <thead>
            <tr style="background-color: black; color:white;">
                <th style="text-align: center; width: 200px; padding: 20px;">Product ID</th>
                <th style="text-align: center; width: 300px;">Name</th>
                <th style="text-align: center; width: 300px;">Type</th>
                <th style="text-align: center; width: 250px">Unit Price</th>
        
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM Products";
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<tr style='font-size: 20px;'>
                        <td style='text-align: center; padding: 15px;'>{$row['id']}</td>
                        <td style='text-align: center;'>{$row['name']}</td>
                        <td style='text-align: center;'>{$row['type']}</td>
                        <td style='text-align: center;'>{$row['price']}</td>
                    </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>


    <!------------------------------------------------------------------------------------------------------>
    <div class="container1">
    <h1 style="font-size: 45px; margin-top: -100px; margin-left: 100px;">Sales</h1>

    <table class="content-table" style="border-collapse: collapse; margin-top: 70px; margin-left: 35px;">

        <thead>
            <tr style="background-color: black; color:white; font-size: 20px;">
                <th style="text-align: center; padding:20px;width: 140px;">Sale ID</th>
                <th style="text-align: center; width: 160px;">Product ID</th>
                <th style="text-align: center; width: 300px;">Product Name</th>
                <th style="text-align: center; width: 300px;">Sales Categoury</th>
                <th style="text-align: center; width: 200px;">Units Sold</th>
                <th style="text-align: center; width: 200px;">Total Amount</th>
                <th style="text-align: center; width: 450px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM Sales";
            $result2 = mysqli_query($conn, $sql2);

            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                echo "<tr style='background-color:rgba(255, 255, 255, 0.164);font-size: 20px;border-bottom:none;'>
                            <td style='text-align: center; padding: 20px; '>{$row['SalesID']}</td>
                            <td style='text-align: center;'>{$row['productID']}</td>
                            <td style='text-align: center;'>{$row['ProductName']}</td>
                            <td style='text-align: center;'>{$row['SalesCategoury']}</td>
                            <td style='text-align: center;'>{$row['TotalUnitsSold']}</td>
                            <td style='text-align: center;'>{$row['TotalAmount']}</td>
                            <td style='width: 450px; padding: 20px; display: flex; justify-content:center; align-items:center; gap:60px; font-size: 21px;' >

                                <a href='sales.php?delete={$row['SalesID']}' class='delete-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 50px 10px 50px; border-radius: 50px; text-align: center;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                                <a href='sales.php?edit={$row['SalesID']}' class='option-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 65px 10px 65px; border-radius: 50px; text-align: center;'>Edit</a>
                           
                            </td>
                        </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

   <h2 style="font-size: 45px; margin-top: 100px; margin-left: 100px;"><?= isset($edit_task) ? "<span style='color: rgb(209, 20, 20); '>Edit</span> Sale" : "Add <span style='color: rgb(209, 20, 20);'>Sale</span>"; ?></h2>

<form method="post">
    <?php if (isset($edit_task)): ?>
    <input type="hidden" name="taskID" value="<?= $edit_task['SalesID']; ?>">
    <?php endif; ?>

    <div class="main" style="display: flex; flex-direction: column;justify-content: center; gap: 35px; align-items: center; flex-wrap: wrap; background-color: rgba(217, 217, 217, 0.32);
        width: 48%; padding: 65px; border-radius: 40px; margin-left: 430px; margin-top: 100px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">

    <div class="left" style="display: flex; align-items: center; gap: 108px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Sale Date</label>
        <input type="date" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtdate" value="<?= isset($edit_task) ? $edit_task['SalesDate'] : ''; ?>" required>
    </div>

    <div class="left" style="display: flex; align-items: center; gap: 103px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Sale Type</label>
            <select name="txtselect" style="width: 401px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" required>
            <option value="">Select Sale Type</option>
            <option value="Online Sales" <?php if (isset($edit_task) && $edit_task['SalesCategoury'] == "Online Sales") echo "selected"; ?>>Online Sales</option>
            <option value="InStore Sales" <?php if (isset($edit_task) && $edit_task['SalesCategoury'] == "InStore Sales") echo "selected"; ?>>InStore Sales</option>
        </select>
    </div>
    
    <div class="left" style="display: flex; align-items: center; gap: 94px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Product ID</label>
        <input type="number" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtpid" value="<?= isset($edit_task) ? $edit_task['productID'] : ''; ?>" required>
    </div>
        
    <div class="left" style="display: flex; align-items: center; gap: 50px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Product Name</label>
        <input type="text" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtname" value="<?= isset($edit_task) ? $edit_task['ProductName'] : ''; ?>" required>
    </div>
    
    <div class="left" style="display: flex; align-items: center; gap: 100px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Unit Price</label>
        <input type="number" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtuprice" value="<?= isset($edit_task) ? $edit_task['ProductUnitPrice'] : ''; ?>" required>
    </div>
   
    <div class="left" style="display: flex; align-items: center; gap: 95px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Units Sold</label>
        <input type="number" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtusold" value="<?= isset($edit_task) ? $edit_task['TotalUnitsSold'] : ''; ?>" required>
    </div> 
    
    <input type="button" style="width: 180px; height: 50px; background-color: rgb(219, 101, 23); color: rgb(255, 255, 255); border-radius: 10px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;" onclick="calculateTotal()" value="CALCULATE">

    <div class="left" style="display: flex; align-items: center; gap: 56px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Total Amount</label>
        <input type="number" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtamount" value="<?= isset($edit_task) ? $edit_task['TotalAmount'] : ''; ?>" required>
    </div>
    

    <input type="submit" name="<?= isset($edit_task) ? "update_task" : "btnassign"; ?>" value="<?= isset($edit_task) ? "Update Sale" : "Add Sale"; ?>" style="width: 200px; height: 50px; background-color: rgb(32, 32, 32); color: rgb(255, 255, 255); border-radius: 50px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;">

    
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

