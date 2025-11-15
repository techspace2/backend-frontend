<?php
include 'connect.php';
session_start();

$del = "";

// ADD TRANSACTION
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnadd'])) {
    $account = trim($_POST['txtaccount']); 
    $date = trim($_POST['txtdate']);
    $time = trim($_POST['txttime']);
    $details = trim($_POST['txtdetails']);
    $amount = trim($_POST['txtamount']);
    $status = trim($_POST['txtselect']);
    $id = $_SESSION['LoginID'] ?? null;

    if ($id) {
        $sql = "INSERT INTO Transactions (AccountId, TransactionDate, TransactionTime, TransactionDetails, TransactionAmount, TransactionStatus, FinancialOfficerId) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssdsd", $account, $date, $time, $details, $amount, $status, $id);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: transaction.php?success=1");
            exit();
        } else {
            $del = false;
        }
    } else {
        $del = false;
    }
}

// DELETE TRANSACTION
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete'];

    $stmt = mysqli_prepare($conn, "DELETE FROM Transactions WHERE TransactionID = ?");
    mysqli_stmt_bind_param($stmt, "i", $taskID);
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: transaction.php?deleted=1");
        exit();
    }
}

// FETCH TRANSACTION DETAILS FOR EDITING
$edit_task = null;
if (isset($_GET['edit'])) {
    $taskID = $_GET['edit'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM Transactions WHERE TransactionID = ?");
    mysqli_stmt_bind_param($stmt, "i", $taskID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $edit_task = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

// UPDATE TRANSACTION
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_task'])) {
    $taskID = $_POST['taskID'];
    $account = trim($_POST['txtaccount']); 
    $date = trim($_POST['txtdate']);
    $time = trim($_POST['txttime']);
    $details = trim($_POST['txtdetails']);
    $amount = trim($_POST['txtamount']);
    $status = trim($_POST['txtselect']);

    $sql = "UPDATE Transactions SET AccountId=?, TransactionDate=?, TransactionTime=?, TransactionDetails=?, TransactionAmount=?, TransactionStatus=? WHERE TransactionID=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssdsi", $account, $date, $time, $details, $amount, $status, $taskID);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: transaction.php?updated=1");
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Page</title>
    <link rel="stylesheet" href="transaction.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap">

    
</head>
<body>

    <div class="container">
        <div class="body-container">
            <div class="nav-bar">
                <img class="logo-img" src="01.jpg.png" alt="Logo">
                <div class="nav-btns">
                    <a class="profile-btn" href="../../4-FinancialOfficer/financialofficer.php">Back</a>  <!-- Add a valid href -->
                </div>
            </div>

            <div class="back1">
                <div class="info">
                    <label>TRANSACTION INFO AT TECHSPACE</label>
                    <h1>TRANSACTION DETAILS</h1>
                    <p>"Our system provides detailed invoices, including product descriptions, quantities, prices, payment methods, and transaction dates. Customers receive instant confirmations and tracking updates for a hassle-free shopping experience."</p>
                </div>
            </div>
        </div>
    </div>

    
    <div class="container1">
        <h1 style="font-size: 45px; margin-top: 70px; margin-left:100px;"><span style="color: red; margin-right:12px;">Account</span> Details</h1>
        <table class="content-table" style="border-collapse: collapse; margin-top:70px; margin-left:220px;">
            <thead>
                <tr style="background-color: black; color:white; font-size:22px;">
                    <th style="text-align: center; padding:20px; width:200px;">Account ID</th>
                    <th style="text-align: center; width:600px;">Name </th>
                    <th style="text-align: center; width:600px;">Used Department</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql2 = "SELECT * FROM Account";
                $result2 = mysqli_query($conn, $sql2);

                if (mysqli_num_rows($result2) > 0) {
                    while ($row = mysqli_fetch_assoc($result2)) {
                        echo "<tr style='background-color:rgba(255, 255, 255, 0.164);font-size: 23px;border-bottom:none;'>
                                <td style='text-align: center; padding:15px;'>{$row['AccountID']}</td>
                                <td style='text-align: center;'>{$row['AccountName']}</td>
                                <td style='text-align: center;'>{$row['UsedDepartment']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align: center; font-size: 20px;'>No transactions found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>



    <div class="container1">
    <h1 style="font-size: 45px; margin-top: 90px; margin-left:100px;"><span style="color: red; margin-right:12px;">Transaction</span> Details</h1>
        <table class="content-table" style="border-collapse: collapse; margin-top:70px; margin-left:63px;">
            <thead>
                <tr style="background-color: black; color:white; font-size:22px;">
                    <th style="text-align: center; padding:18px; width:200px;">Transaction ID</th>
                    <th style="text-align: center; width:210px;">Date</th>
                    <th style="text-align: center; width:210px;">Time</th>
                    <th style="text-align: center; width:210px;">Details</th>
                    <th style="text-align: center;width:210px;">Amount</th>
                    <th style="text-align: center;width:210px;">Status</th>
                    <th style="text-align: center;width:460px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql2 = "SELECT * FROM Transactions ";
                $result2 = mysqli_query($conn, $sql2);

                if (mysqli_num_rows($result2) > 0) {
                    while ($row = mysqli_fetch_assoc($result2)) {
                        echo "<tr style='background-color:rgba(255, 255, 255, 0.164);font-size: 22px;border-bottom:none;'>
                                <td style='text-align: center; padding:15px;width: 210px;'>{$row['TransactionID']}</td>
                                <td style='text-align: center; width: 210px;'>{$row['TransactionDate']}</td>
                                <td style='text-align: center; width: 210px;'>{$row['TransactionTime']}</td>
                                <td style='text-align: center; width: 210px;'>{$row['TransactionDetails']}</td>
                                <td style='text-align: center;'>$" . number_format($row['TransactionAmount'], 2) . "</td>
                                <td style='text-align: center;'>{$row['TransactionStatus']}</td>
                                <td style='width: 460px; display: flex; justify-content:center; align-items:center; gap:60px; font-size: 21px; padding:15px;' >

                                        <a href='transaction.php?delete={$row['TransactionID']}' class='delete-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 50px 10px 50px; border-radius: 50px; text-align: center;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                                        <a href='transaction.php?edit={$row['TransactionID']}' class='option-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 65px 10px 65px; border-radius: 50px; text-align: center;'>Edit</a>
                                
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

    <h2 style="font-size:40px; margin-left:100px; margin-top:100px;"><?php echo isset($edit_task) ? "Edit Transaction" : "Add Transaction"; ?></h2>

    <form method="post" >

            <input type="hidden" name="taskID" value="<?php echo isset($edit_task) ? $edit_task['TransactionID'] : ''; ?>">

        <div class="main-flex" style="display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 30px; background-color:rgb(241, 237, 237); width:55%; padding:70px;
            border-radius:40px; margin-left:350px; margin-top:100px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">

            <div class="left1"  style="display: flex; align-items: center; gap: 176px;">
                <label style="font-size: 30px;">Account ID</label>
                <input type="text" name="txtaccount" style="width: 400px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" value="<?php echo isset($edit_task) ? $edit_task['AccountId'] : ''; ?>" required>
            </div>  
        
            <div class="left1" style="display: flex; align-items: center; gap: 270px;">
                <label style="font-size: 30px;">Date</label>
                <input type="date"  style="width: 400px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txtdate" value="<?php echo isset($edit_task) ? $edit_task['TransactionDate'] : ''; ?>" required>
            </div>
       
            <div class="left1" style="display: flex; align-items: center; gap: 265px;">
                <label style="font-size: 30px;">Time</label>
                <input type="time" style="width: 400px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" name="txttime" value="<?php echo isset($edit_task) ? $edit_task['TransactionTime'] : ''; ?>" required>
            </div>  
       
            <div class="left1" style="display: flex; align-items: center; gap: 240px;">
                <label style="font-size: 30px;">Details</label>
                <textarea name="txtdetails" style="width: 400px; height: 155px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" required><?php echo isset($edit_task) ? $edit_task['TransactionDetails'] : ''; ?></textarea>
            </div>
                
            <div class="left1" style="display: flex; align-items: center; gap: 230px;">
                <label style="font-size: 30px;">Amount</label>
                <input type="number" step="0.01" name="txtamount" style="width: 400px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" value="<?php echo isset($edit_task) ? $edit_task['TransactionAmount'] : ''; ?>" required>
            </div>
        
            <div class="left1" style="display: flex; align-items: center; gap: 76px;">
                <label style="font-size: 30px;">Transaction Status</label>
                <select name="txtselect" style="width: 410px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;" required>
                    <option value="Completed" <?php if (isset($edit_task) && $edit_task['TransactionStatus'] == "Completed") echo "selected"; ?>>Completed</option>
                    <option value="Not Completed" <?php if (isset($edit_task) && $edit_task['TransactionStatus'] == "Not Completed") echo "selected"; ?>>Not Completed</option>
                </select>
            </div>
        
            <div class="btns" style="display: flex; align-items: center; gap:100px; margin-top: 70px;">
                <?php if (isset($edit_task)) { ?>
                    <input type="submit" style="width:300px; height:50px; border-radius:50px; border:none; background-color: black; color: white; font-size: 20px;" name="update_task" value="UPDATE TRANSACTION">
                <?php } else { ?>
                    <input type="submit" style="width:300px; height:50px; border-radius:50px; border:none; background-color: black; color: white; font-size: 20px;" name="btnadd" value="ADD TRANSACTION">
                <?php } ?>
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
