<?php
include 'connect.php';
session_start();

// INSERT TASK
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnassign'])) {
    $pid = mysqli_real_escape_string($conn, $_POST['txtpid']);
    $pname = mysqli_real_escape_string($conn, $_POST['txtname']);
    $pdetails = mysqli_real_escape_string($conn, $_POST['txtdetails']);
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);
    $id = $_SESSION['LoginID'];

    $sql = "INSERT INTO ProductDesign (ProductID, ProductName, PDesignDetails ,PDesignDate ,cadEngineerrId) 
            VALUES ('$pid', '$pname', '$pdetails','$date','$id')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = "Design Added Successfully";
    } else {
        $_SESSION['message'] = "Design not Assigned";
    }

    header("Location: productdesign.php");
    exit();
}

// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM ProductDesign WHERE PDesignID = '$taskID'");
    header("Location: productdesign.php");
    exit();
}

// FETCH TASK DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM ProductDesign WHERE PDesignID = '$taskID'");
    $edit_task = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_task'])) {
    $taskID = mysqli_real_escape_string($conn, $_POST['taskID']);
    $pid = mysqli_real_escape_string($conn, $_POST['txtpid']);
    $pname = mysqli_real_escape_string($conn, $_POST['txtname']);
    $pdetails = mysqli_real_escape_string($conn, $_POST['txtdetails']);
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);


    $sql = "UPDATE ProductDesign SET ProductID='$pid', ProductName='$pname', PDesignDate='$pdetails' ,PDesignDate='$date' WHERE PDesignID='$taskID'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = "Design Updated Successfully";
    } else {
        $_SESSION['message'] = "Failed to update Design";
    }

    header("Location: productdesign.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="product design.css">
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
        
                    <a class="profile-btn" href="../../13-CAD/cad.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1">
    
                <div class="info">
                    <label for="">TECHSPACE</label>
                    <h1>PRODUCT DESIGN</h1>
                    <p>"Techspace is a forward-thinking apparel company that merges innovative design with cutting-edge technology. Our product design focuses on functionality, comfort, and modern aesthetics, ensuring every piece enhances both performance and style."</p>
                </div>
                
            </div>
    
        </div>

    </div>

    <!------------------------------------------------------------------------------------------------------>
 
    <div class="container">
    <h1 style="font-size: 45px; margin-top: 70px; margin-left: 100px;"><span style="color: rgb(218, 34, 34);">Product</span> Details</h1>

    <table class="content-table" style="border-collapse: collapse; margin-top: 70px; margin-left: 470px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
        <thead>
            <tr style="background-color: black; color:white; font-size: 20px;">
                <th style="text-align: center; width: 200px; padding: 20px;">Image</th>
                <th style="text-align: center; width: 200px;">Product ID</th>
                <th style="text-align: center; width: 200px;">Name</th>
                <th style="text-align: center; width: 300px;">Type</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM Products";
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<tr style='font-size: 20px;'>
                        <td style='text-align: center; padding-top: 15px;'>
                            <img src='../../shopping cart/uploaded_img/" . $row['image'] . "' height='100' alt='Product Image'>
                        </td>
                        <td style='text-align: center;'>{$row['id']}</td>
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
    <h1 style="font-size: 45px; margin-top: 100px; margin-left: 100px;">Product <span style="color: rgb(218, 34, 34);">Design</span></h1>

    <table class="content-table" style="border-collapse: collapse; margin-top: 70px; margin-left: 75px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
        <thead>
            <tr style="background-color: black; color:white; font-size: 20px;">
                <th style="text-align: center; width: 200px; padding: 20px;">Product Design ID </th>
                <th style="text-align: center; width: 160px;">Product ID </th>
                <th style="text-align: center; width: 300px;">Name</th>
                <th style="text-align: center; width: 400px;">Design Description</th>
                <th style="text-align: center; width: 200px;">Date</th>
                <th style="text-align: center; width: 450px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM ProductDesign";
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<tr style='font-size: 20px;'>
                        <td style='text-align: center; padding: 20px;'>{$row['PDesignID']}</td>
                        <td style='text-align: center;'>{$row['ProductID']}</td>
                        <td style='text-align: center;'>{$row['ProductName']}</td>
                        <td style='text-align: center;'>{$row['PDesignDetails']}</td>
                        <td style='text-align: center;'>{$row['PDesignDate']}</td>
                        <td style='text-align: center; padding: 20px; display: flex; justify-content: center; align-items: center; gap: 40px;'>
                            <a href='productdesign.php?delete={$row['PDesignID']}' style='text-decoration: none; color: white; background-color: black; padding: 10px 40px 10px 40px; cursor: pointer; border-radius: 50px;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                            <a href='productdesign.php?edit={$row['PDesignID']}' style='text-decoration: none; color: white; background-color: black; padding: 10px 52px 10px 52px; cursor: pointer; border-radius: 50px;'>Edit</a>
                        </td>
                    </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<h2 style="font-size: 45px; margin-top: -420px; margin-left: 100px;"><?= isset($edit_task) ? "<span style='color: rgb(218, 34, 34);'>Edit</span> Product Design" : "Add <span style='color: rgb(218, 34, 34); '>Product</span> Design"; ?></h2>

<form method="post">
    <?php if (isset($edit_task)): ?>
        <input type="hidden" name="taskID" value="<?= $edit_task['PDesignID']; ?>">
        <?php endif; ?>

    <div class="main" style="display: flex; flex-direction: column;justify-content: center; gap: 35px; align-items: center; flex-wrap: wrap; background-color: rgba(217, 217, 217, 0.32);
        width: 48%; padding: 65px; border-radius: 40px; margin-left: 430px; margin-top: 100px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">


    <div class="left"  style="display: flex; align-items: center; gap: 148px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Product ID</label>
        <input type="text" style="z-index: 1;width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtpid" value="<?= isset($edit_task) ? $edit_task['ProductID'] : ''; ?>" required>
    </div>
        
    <div class="left"  style="display: flex; align-items: center; gap: 105px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Product Name</label>
        <input type="text" style="z-index: 1;width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtname" value="<?= isset($edit_task) ? $edit_task['ProductName'] : ''; ?>" required>
    </div>
       
    <div class="left"  style="display: flex; align-items: center; gap: 56px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Design Description</label>
        <textarea name="txtdetails" style="width: 390px; height: 150px; padding-top: 10px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" placeholder="Enter your message" rows="7" required><?php echo isset($edit_task) ? $edit_task['PDesignDetails'] : ''; ?></textarea>
    </div>
       
    <div class="left"  style="display: flex; align-items: center; gap: 130px;">
        <label style="font-size: 24px; color: rgb(66, 66, 66);">Design Date</label>
        <input type="date" style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtdate" value="<?= isset($edit_task) ? $edit_task['PDesignDate'] : ''; ?>" required>
    </div>
       
    <input type="submit" name="<?= isset($edit_task) ? "update_task" : "btnassign"; ?>" value="<?= isset($edit_task) ? "UPDATE" : "ADD"; ?>"  style="width: 200px; height: 50px; margin-top: 30px; background-color: rgb(32, 32, 32); color: rgb(255, 255, 255); border-radius: 50px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;">

    
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


