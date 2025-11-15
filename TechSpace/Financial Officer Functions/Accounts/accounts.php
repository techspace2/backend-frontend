<?php
include 'connect.php';
session_start();

$del = "";

// Ensure session ID exists
$id = $_SESSION['LoginID'] ?? null;

if (!$id) {
    die("Unauthorized access. Please log in.");
}

// INSERT TASK
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnassign'])) {
    $name = trim($_POST['txtname']);
    $department = trim($_POST['txtselect']);
    $password = $_POST['txtpassword'];

    $sql = "INSERT INTO Account (AccountName, UsedDepartment, AccountPassword, FinancialOfficerId) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $name, $department, $password, $id);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: accounts.php?success=1"); // Redirect after successful submission
        exit();
    } else {
        $del = false;
    }

    mysqli_stmt_close($stmt);
}

// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];

    $stmt = mysqli_prepare($conn, "DELETE FROM Account WHERE AccountID = ?");
    mysqli_stmt_bind_param($stmt, "i", $taskID);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: accounts.php?deleted=1");
        exit();
    }
}

// FETCH TASK DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = $_GET['edit'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM Account WHERE AccountID = ?");
    mysqli_stmt_bind_param($stmt, "i", $taskID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $edit_task = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

// UPDATE TASK
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_task'])) {
    $taskID = $_POST['taskID'];
    $name = trim($_POST['txtname']);
    $department = trim($_POST['txtselect']);
    $password = $_POST['txtpassword'];

    $sql = "UPDATE Account SET AccountName=?, UsedDepartment=?, AccountPassword=? WHERE AccountID=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $name, $department, $password, $taskID);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: accounts.php?updated=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="accounts.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="body-container">

            <div class="nav-bar">
    
                <img class="logo-img" src="../Transaction Details/01.jpg.png" alt="">
               
                <div class="nav-btns">
        
                    <a class="profile-btn" href="../../4-FinancialOfficer/financialofficer.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1">
    
                <div class="info">
                    <label for="">ACCOUNTS AT TECHSPACE</label>
                    <h1>ACCOUNTS</h1>
                    <p>"Techspace is a dynamic apparel company specializing in innovative and stylish clothing. Our accounts department ensures seamless financial operations, including budgeting, invoicing, payroll, and financial reporting."</p>
                </div>
                
            </div>
    
        </div>

    </div>

    <!------------------------------------------------------------------------------------------------------>


    <div class="container1">
        <h1 style="font-size: 45px; margin-left: 100px; margin-top: 70px;">Accouont Details</h1>
        <table class="content-table" style="border-collapse: collapse; margin-left: 80px; margin-top: 50px;">
            <thead>
                <tr style="background-color: black; color:white; font-size: 20px;">
                    <th style="text-align: center; padding:20px; width: 100px;">Account ID</th>
                    <th style="text-align: center; width: 450px;">Name </th>
                    <th style="text-align: center; width: 200px;">Used Department</th>
                    <th style="text-align: center; width: 400px;">Password</th>
                    <th style="text-align: center; width: 400px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql2 = "SELECT * FROM Account";
                $result2 = mysqli_query($conn, $sql2);

                if (mysqli_num_rows($result2) > 0) {
                    while ($row = mysqli_fetch_assoc($result2)) {
                        echo "<tr style='background-color:rgba(255, 255, 255, 0.164);font-size: 25px;border-bottom:none; font-size: 20px;'>
                                <td style='text-align: center; padding: 15px;'>{$row['AccountID']}</td>
                                <td style='text-align: center;'>{$row['AccountName']}</td>
                                <td style='text-align: center; width: 200px;'>{$row['UsedDepartment']}</td>
                                <td style='text-align: center; width: 300px;'>{$row['AccountPassword']}</td>
                                <td style='width: 400px; padding: 15px; display: flex; justify-content:center; align-items:center; gap:60px; font-size: 21px;' >

                                        <a href='accounts.php?delete={$row['AccountID']}' class='delete-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 50px 10px 50px; border-radius: 50px; text-align: center;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                                        <a href='accounts.php?edit={$row['AccountID']}' class='option-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 65px 10px 65px; border-radius: 50px; text-align: center;'>Edit</a>
                                
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





    <h2 style="font-size: 45px; margin-left: 100px; margin-top:90px;"><?php echo isset($edit_task) ? "Edit Task" : "Add Account"; ?></h2>

<form method="post">

    <?php if (isset($edit_task)): ?>
        <input type="hidden" name="taskID" value="<?php echo $edit_task['AccountID']; ?>">
    <?php endif; ?>

    <div class="main-flex" style="display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 40px; background-color: rgb(241, 240, 240); padding: 60px; width: 50%;
        border-radius: 50px; margin-left: 400px; margin-top: 130px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">

        <div class="left" style="display: flex; align-items: center; gap: 105px;">
            <label style="font-size: 30px;">Account Name</label>
            <input type="text" name="txtname" style="width: 400px; height: 55px; font-size: 20px; outline: none; border: none; border-radius: 10px; background-color: rgb(228, 227, 227); padding-left: 10px;" value="<?php echo isset($edit_task) ? $edit_task['AccountName'] : ''; ?>" required>
        </div> 
    
       

            <div class="left" style="display: flex; align-items: center; gap: 145px;">

                <label style="font-size: 30px;">Department</label>
                <select name="txtselect" style="width: 410px; height: 55px; font-size: 20px; outline: none; border: none; border-radius: 10px; background-color: rgb(228, 227, 227); padding-left: 10px;"  required>
                    <option value="Financial Department" <?php if (isset($edit_task) && $edit_task['UsedDepartment'] == "Financial Department") echo "selected"; ?>>Financial Department</option>
                    <option value="Sales Department" <?php if (isset($edit_task) && $edit_task['UsedDepartment'] == "Sales Department") echo "selected"; ?>>Sales Department</option>
                    <option value="HR & Compliance Department" <?php if (isset($edit_task) && $edit_task['UsedDepartment'] == "HR & Compliance Department") echo "selected"; ?>>HR & Compliance Department</option>
                    <option value="Business Deveopment Department" <?php if (isset($edit_task) && $edit_task['UsedDepartment'] == "Business Deveopment Department") echo "selected"; ?>>Business Deveopment Department</option>
                    <option value="Payroll Department" <?php if (isset($edit_task) && $edit_task['UsedDepartment'] == "Payroll Department") echo "selected"; ?>>Payroll Department</option>
                </select>

            </div>
           
            <div class="left" style="display: flex; align-items: center; gap: 60px;">
                <label style="font-size: 30px;">Account Password</label>
                <input type="text" name="txtpassword" style="width: 400px; height: 55px; font-size: 20px; outline: none; border: none; border-radius: 10px; background-color: rgb(228, 227, 227); padding-left: 10px;" value="<?php echo isset($edit_task) ? $edit_task['AccountPassword'] : ''; ?>" required>
            </div>
           

            <div class="btns" style="display: flex; align-items: center; margin-top: 40px; justify-content: center; gap: 100px;">
                <?php if (isset($edit_task)): ?>
                <input type="submit" name="update_task" value="Update Account" class="update" style="width: 250px; height: 50px; color: white; font-size: 20px; border-radius: 50px; border: none; background-color: rgb(230, 117, 12);">
                <?php else: ?>
                <input type="submit" name="btnassign" value="Add Account"  style="width: 250px; height: 50px; color: white; font-size: 20px; border-radius: 50px; border: none; background-color: rgb(26, 26, 26);" >
                <?php endif; ?>
            </div>
           

            <div >
            <?php 
                    if (isset($_GET['success'])) { 
                        echo "<p style='color: green; font-size:22px;'>Account Added Successfully!</p>"; 
                    } elseif (isset($_GET['updated'])) { 
                        echo "<p style='color: blue; font-size:22px;'>Account Updated Successfully!</p>"; 
                    } elseif (isset($_GET['deleted'])) { 
                        echo "<p style='color: red; font-size:22px;'>Account Deleted Successfully!</p>"; 
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