<?php
include 'connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnassign'])) {
    $pid = mysqli_real_escape_string($conn, $_POST['txtpid']);
    $pname = mysqli_real_escape_string($conn, $_POST['txtname']);
    $pdetails = mysqli_real_escape_string($conn, $_POST['txtdetails']);
    $quan = mysqli_real_escape_string($conn, $_POST['txtquan']);
    $id = $_SESSION['LoginID'];

    // Check if Product ID exists in the Products table
    $checkQuery = "SELECT * FROM Products WHERE id = '$pid'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Product exists, proceed with insertion
        $sql = "INSERT INTO ProductManufacturing (ProductId, PName, PManufacturingDetails, PManufacturingQuantity, PlantManagerId) 
                VALUES ('$pid', '$pname', '$pdetails', '$quan', '$id')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $_SESSION['message'] = "Process Added Successfully";
        } else {
            $_SESSION['message'] = "Process not Assigned. Database Error.";
        }
    } else {
        // Product ID does not exist, show an error message
        $_SESSION['message'] = "Error: The Product ID ($pid) does not exist in the Products table.";
    }

    header("Location: productmanfac.php");
    exit();
}


// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM ProductManufacturing WHERE PManufacturingID = '$taskID'");
    header("Location: productmanfac.php");
    exit();
}

// FETCH TASK DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM ProductManufacturing WHERE PManufacturingID = '$taskID'");
    $edit_task = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_task'])) {
    $taskID = mysqli_real_escape_string($conn, $_POST['taskID']);
    $pid = mysqli_real_escape_string($conn, $_POST['txtpid']);
    $pname = mysqli_real_escape_string($conn, $_POST['txtname']);
    $pdetails = mysqli_real_escape_string($conn, $_POST['txtdetails']);
    $quan = mysqli_real_escape_string($conn, $_POST['txtquan']);


    $sql = "UPDATE ProductManufacturing SET ProductId='$pid', PName='$pname', PManufacturingDetails='$pdetails' ,PManufacturingQuantity='$quan' WHERE PManufacturingID='$taskID'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = "Process Updated Successfully";
    } else {
        $_SESSION['message'] = "Failed to update Process";
    }

    header("Location: productmanfac.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="product manfac.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="body-container">

            <div class="nav-bar">
    
                <img class="logo-img" src="../Machinery  Equipment/01.jpg.png" alt="">
               
                <div class="nav-btns">
        
                    <a class="profile-btn" href="../../8-PlantManager/plantmngrhome.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1">
    
                <div class="info">
                    <label for="">TECHSPACE</label>
                    <h1>PRODUCT MANUFACTURING PROCESS</h1>
                    <p>"Techspace is a leading apparel manufacturing company specializing in high-quality, innovative, and sustainable clothing solutions. We combine advanced technology with expert craftsmanship to produce stylish and durable garments that meet global industry standards."</p>
                </div>
                
            </div>
    
        </div>

    </div>

    <!------------------------------------------------------------------------------------------------------>
    <div class="container">
    <h1 style="font-size: 45px; margin-top: 70px; margin-left: 100px;"><span style="color: rgb(206, 40, 40);">Product</span> Details</h1>

    <table class="content-table" style="border-collapse: collapse; margin-left: 380px; margin-top: 70px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
        <thead>
            <tr style="background-color: black; color:white; font-size: 20px;">
                <th style="text-align: center; padding: 20px; width: 200px;">Image</th>
                <th style="text-align: center; width: 300px;">Product ID</th>
                <th style="text-align: center; width: 300px;">Name</th>
                <th style="text-align: center; width: 300px;">Type</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM Products";
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<tr>
                        <td style='text-align: center; font-size: 20px;'>
                            <img src='../../shopping cart/uploaded_img/" . $row['image'] . "' height='100' alt='Product Image'>
                        </td>
                        <td style='text-align: center; padding: 20px;'>{$row['id']}</td>
                        <td style='text-align: center;'>{$row['name']}</td>
                        <td style='text-align: center;'>{$row['type']}</td>
                    </tr>";
                }
            }
            ?>
        </tbody>

    </table>
</div>


     <!------------------------------------------------------------------------------------------------------>


    <div class="container">
    <h1 style="font-size: 45px; margin-top: 170px; margin-left: 100px;">Manufacturing <span style="color: rgb(206, 40, 40);">Process</span> Details</h1>

    <table class="content-table" style="border-collapse: collapse; margin-left: 80px; margin-top: 100px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
        <thead>
            <tr style="background-color: black; color:white; font-size: 20px;">
                <th style="text-align: center; padding: 20px;">Process Manufacturing ID </th>
                <th style="text-align: center; width: 200px;">Product ID </th>
                <th style="text-align: center; width: 200px;">Name</th>
                <th style="text-align: center; width: 300px;">Manufacturing Details</th>
                <th style="text-align: center; width: 300px;">Manufacturing Quantity</th>
                <th style="text-align: center; width: 450px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM ProductManufacturing";
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<tr style='font-size: 20px;'>
                        <td style='text-align: center; padding: 20px;'>{$row['PManufacturingID']}</td>
                        <td style='text-align: center;'>{$row['ProductId']}</td>
                        <td style='text-align: center;'>{$row['PName']}</td>
                        <td style='text-align: center;'>{$row['PManufacturingDetails']}</td>
                        <td style='text-align: center;'>{$row['PManufacturingQuantity']}</td>
                        <td style='text-align: center; display: flex; justify-content: center; align-items: center; padding: 20px; gap: 50px;'>
                            <a href='productmanfac.php?delete={$row['PManufacturingID']}' style='text-decoration: none; color: white; background-color: black; padding: 10px 40px 10px 40px; cursor: pointer; border-radius: 50px;'  onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                            <a href='productmanfac.php?edit={$row['PManufacturingID']}' style='text-decoration: none; color: white; background-color: black; padding: 10px 53px 10px 53px; cursor: pointer; border-radius: 50px;'   >Edit</a>
                        </td>
                    </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>



<h2 style="font-size: 45px; margin-top: -300px; margin-left: 100px;"><?= isset($edit_task) ? "<span style='color: rgb(206, 40, 40);'>Edit</span> Manufacturing Process" : "Add <span style='color:rgb(206, 40, 40); '>Manufacturing</span> Process"; ?></h2>

<form method="post">
    <?php if (isset($edit_task)): ?>
        <input type="hidden" name="taskID" value="<?= $edit_task['PManufacturingID']; ?>">
        <?php endif; ?>


    <div class="main" style=" z-index: 1;display: flex; flex-direction: column;justify-content: center; gap: 35px; align-items: center; flex-wrap: wrap; background-color: rgba(217, 217, 217, 0.32);
        width: 48%; padding: 65px; border-radius: 40px; margin-left: 430px; margin-top: 100px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">

    <div class="left" style="display: flex; align-items: center; gap: 200px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Product ID</label>
        <input type="text" style=" z-index: 1; width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtpid" value="<?= isset($edit_task) ? $edit_task['ProductId'] : ''; ?>" required>
    </div>
   

    <div class="left" style="display: flex; align-items: center; gap: 158px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Product Name</label>
        <input type="text" style="z-index: 1; width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtname" value="<?= isset($edit_task) ? $edit_task['PName'] : ''; ?>" required>
    </div>
   

    <div class="left" style="display: flex; align-items: center; gap: 66px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Manufacturing Process</label>
        <textarea name="txtdetails" style=" z-index: 1; width: 390px; height: 155px; padding-top: 10px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" placeholder="Enter your message" rows="7" required><?php echo isset($edit_task) ? $edit_task['PManufacturingDetails'] : ''; ?></textarea>
    </div>
   

    <div class="left" style="display: flex; align-items: center; gap: 65px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Manufacturing Quantity</label>
        <input type="number" style=" z-index: 1;width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtquan" value="<?= isset($edit_task) ? $edit_task['PManufacturingQuantity'] : ''; ?>" required>
    </div>  
    


    <input type="submit" name="<?= isset($edit_task) ? "update_task" : "btnassign"; ?>" value="<?= isset($edit_task) ? "Update Manufacturing Process" : "ADD"; ?>" style="width: 210px; margin-top: 30px; height: 50px; background-color: rgb(32, 32, 32); color: rgb(255, 255, 255); border-radius: 50px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;">

    
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


