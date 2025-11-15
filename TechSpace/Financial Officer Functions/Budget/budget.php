<?php
include 'connect.php';
session_start();

$del = "";

// Ensure $id is an integer
$id = (int)$_SESSION['LoginID'] ?? null;

if (!$id) {
    die("Unauthorized access. Please log in.");
}

// INSERT TASK
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnassign'])) {
    $desc = trim($_POST['txtdesc']);
    $amount = trim($_POST['txtamount']);

    // Construct the SQL query (no prepared statements)
    $sql = "INSERT INTO Budget (BDetails, BAmount, FinancialManagerId) VALUES ('$desc', '$amount', $id)";

    if (mysqli_query($conn, $sql)) {
        header("Location: budget.php?success=1"); // Redirect after successful submission
        exit();
    } else {
        $del = false;
        echo "Error: " . mysqli_error($conn); // Output error if something goes wrong
    }
}

// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];

    // Check if task ID is numeric before deleting
    if (is_numeric($taskID)) {
        $sql = "DELETE FROM Budget WHERE BID = $taskID";
        if (mysqli_query($conn, $sql)) {
            header("Location: budget.php?deleted=1");
            exit();
        } else {
            echo "Error: Could not execute the deletion query.";
        }
    } else {
        echo "Error: Invalid ID.";
    }
}

// FETCH TASK DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = $_GET['edit'];

    $sql = "SELECT * FROM Budget WHERE BID = $taskID";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $edit_task = mysqli_fetch_assoc($result);
    }
}

// UPDATE TASK
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_task'])) {
    $taskID = $_POST['taskID'];
    $desc = trim($_POST['txtdesc']);
    $amount = trim($_POST['txtamount']);

    // Construct the SQL query for update
    $sql = "UPDATE Budget SET BDetails='$desc', BAmount='$amount' WHERE BID=$taskID";

    if (mysqli_query($conn, $sql)) {
        header("Location: budget.php?updated=1");
        exit();
    } else {
        echo "Error: Could not execute the update query.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Management</title>
    <link rel="stylesheet" href="budget.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap">

</head>
<body>

<div class="container">

    <div class="body-container">

        <div class="nav-bar">
            <img class="logo-img" src="../Transaction Details/01.jpg.png" alt="Logo">
            <div class="nav-btns">
                <a class="profile-btn" href="../../4-FinancialOfficer/financialofficer.php">Back</a>
            </div>
        </div>

        <div class="back1">
            <div class="info">
                <label for="">BUDGETS AT TECHSPACE</label>
                <h1>BUDGET</h1>
                <p>"Techspace’s apparel company budget focuses on efficient resource allocation to ensure quality production and sustainable growth. It includes expenses for raw materials, manufacturing, marketing, distribution, and operational costs."</p>
            </div>
        </div>

    </div>
</div>

<!------------------------------------------------------------------------------------------------------>

<div class="container1">
    <h1 style="font-size: 45px; margin-left: 100px; margin-top: 70px;;">Account Details</h1>
    <table class="content-table" style="border-collapse: collapse; margin-left: 100px; margin-top: 50px;">
        <thead>
            <tr style="background-color: rgb(26, 25, 25); color:white; font-size: 20px;">
                <th style="text-align: center; padding:20px;">Budget ID</th>
                <th style="text-align: center; width: 800px;">Description</th>
                <th style="text-align: center;">Amount</th>
                <th style="text-align: center; width: 430px;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM Budget";
            $result2 = mysqli_query($conn, $sql2);

            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<tr style='background-color:rgba(255, 255, 255, 0.164);font-size: 22px;border-bottom:none;'>
                            <td style='text-align: center; padding: 15px; width:200px;'>{$row['BID']}</td>
                            <td style='text-align: left;'>{$row['BDetails']}</td>
                            <td style='text-align: center;width: 200px;'>{$row['BAmount']}</td>
                            <td style='width: 430px; display: flex; padding: 15px; justify-content:center; align-items:center; gap:40px; font-size: 21px;' >
                                <a href='budget.php?delete={$row['BID']}' class='delete-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 50px 10px 50px; border-radius: 50px; text-align: center;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                                <a href='budget.php?edit={$row['BID']}' class='option-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 65px 10px 65px; border-radius: 50px; text-align: center;'>Edit</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align: center; font-size: 20px;'>No transactions found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<h2 style="font-size: 45px; margin-left: 100px; margin-top:90px;"><?php echo isset($edit_task) ? "Edit Budget" : "Assign Budget"; ?></h2>

<form method="post">

    <?php if (isset($edit_task)): ?>
        <input type="hidden" name="taskID" value="<?php echo $edit_task['BID']; ?>">
    <?php endif; ?>

    <div class="main-flex" style="display: flex; flex-direction: column; justify-content: center;align-items: center;gap: 50px; background-color: rgb(241, 239, 239); padding: 60px; width: 50%;
        border-radius: 40px; margin-left: 400px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">

        <div class="left" style="display: flex; align-items: center; justify-content: center; gap: 90px;">
            <label style="font-size: 25px;">Budget Description</label>
            <input type="text" name="txtdesc" style="width: 400px; height: 50px; border-radius: 10px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); font-size: 18px; padding-left: 10px;" value="<?php echo isset($edit_task) ? $edit_task['BDetails'] : ''; ?>" required>
        </div> 
        
        <div class="left" style="display: flex; align-items: center; justify-content: center; gap: 133px;">
            <label style="font-size: 25px;">Budget Amount</label>
            <input type="text" name="txtamount" style="width: 400px; height: 50px; border-radius: 10px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); font-size: 18px; padding-left: 10px;" value="<?php echo isset($edit_task) ? $edit_task['BAmount'] : ''; ?>" required>
        </div>
      
        <div class="btns" style="display: flex; gap: 70px; margin-top: 30px;">
            <?php if (isset($edit_task)): ?>
            <input type="submit" name="update_task" style="width: 200px; height: 50px; font-size: 20px; background-color: black; color: white; border: none; border-radius: 50px;"  value="Update Task" class="update">
            <?php else: ?>
            <input type="submit" name="btnassign" style="width: 200px; height: 50px; font-size: 20px; background-color: black; color: white; border: none; border-radius: 50px;"  value="Assign Budget" style="background-color: black; color: white; width:370px;">
            <?php endif; ?>
        </div>
       

        <div style="display: flex;flex-direction: column;align-items: center;justify-content: center;">
            <?php 
                if (isset($_GET['success'])) { 
                    echo "<p style='color: green; font-size:22px;'>Budget Added Successfully!</p>"; 
                } elseif (isset($_GET['updated'])) { 
                    echo "<p style='color: blue; font-size:22px;'>Budget Updated Successfully!</p>"; 
                } elseif (isset($_GET['deleted'])) { 
                    echo "<p style='color: red; font-size:22px;'>Budget Deleted Successfully!</p>"; 
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
