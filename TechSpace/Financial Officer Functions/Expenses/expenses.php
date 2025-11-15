<?php
include 'connect.php';
session_start();

$del = "";

if(isset($_POST['btnadd']))
{
    $desc = $_POST['txtdesc'];
    $amount = $_POST['txtamount'];
    $type = $_POST['txttype'];
    $id = $_SESSION['LoginID'];

    // Using prepared statements to prevent SQL injection
    $sql = "INSERT INTO Expense (EDesc, EAmount, EType, FinancialOfficerId) VALUES (?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sdsi", $desc, $amount, $type, $id);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $del = true;
        } else {
            $del = false;
        }

        mysqli_stmt_close($stmt);
    } else {
        $del = false; // In case the query preparation fails
    }
}

// DELETE TASK
if (isset($_GET['delete'])) {
    $taskID = $_GET['delete']; // Get the ID from the URL

    // Make sure the ID is an integer before using it
    if (is_numeric($taskID)) {
        // Prepare the delete statement
        $stmt = mysqli_prepare($conn, "DELETE FROM Expense WHERE EID = ?");
        mysqli_stmt_bind_param($stmt, "i", $taskID); // Bind the ID to the query

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: expenses.php?deleted=1"); // Redirect after successful deletion
            exit();
        } else {
            // Handle errors in case of a failed execution
            echo "Error: Could not execute the deletion query.";
        }
    } else {
        // Handle cases where the ID is not a valid number
        echo "Error: Invalid ID.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="expenses.css">
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
                    <label for="">EXPENSES AT TECHSPACE</label>
                    <h1>EXPENSES</h1>
                    <p>"Techspace incurs various expenses to ensure the quality and efficiency of its apparel production. These include raw material costs for fabrics and accessories, manufacturing and labor expenses, marketing and advertising costs, logistics and shipping fees, as well as operational overhead."</p>
                </div>
                
            </div>
    
        </div>

    </div>

    <!------------------------------------------------------------------------------------------------------>

    <div class="container1">
        <h1 style="font-size: 45px; margin: 100px;">Expenses</h1>
        <table class="content-table" style="border-collapse: collapse; margin-left: 120px;">
            <thead>
                <tr style="background-color: black; color:white; font-size:20px;">
                    <th style="text-align: center; padding:20px; width:150px;">Expense ID</th>
                    <th style="text-align: center; width:850px;"> Description </th>
                    <th style="text-align: center; width:300px;"> Source</th>
                    <th style="text-align: center; width:300px;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql2 = "SELECT * FROM Expense";
                $result2 = mysqli_query($conn, $sql2);

                if (mysqli_num_rows($result2) > 0) {
                    while ($row = mysqli_fetch_assoc($result2)) {
                        echo "<tr style='background-color:rgba(255, 255, 255, 0.164);font-size: 20px;border-bottom:none; font-size:18px;'>
                                <td style='text-align: center; padding:20px; '>{$row['EID']}</td>
                                <td style='text-align: left;'>{$row['EDesc']}</td>
                                <td style='text-align: center;'>{$row['EType']}</td>
                                <td style='text-align: center;'>{$row['EAmount']}</td>
                               <td style='width: 380px; display: flex; justify-content:center; align-items:center; gap:60px; font-size: 21px;'>
                                    <a href='expenses.php?delete={$row['EID']}' class='delete-btn' style='text-decoration: none; color: white; border: none; background-color: black; padding: 10px 50px 10px 50px; border-radius: 50px; text-align: center;' onclick='return confirm(\"Are you sure you want to delete this?\");'>Delete</a>
                                </td>


                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='text-align: center; padding: 20px; font-size: 22px;'>No transactions found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


    <form method="post">
    <div class="main-flex" style="display: flex; flex-direction: column; justify-content: center; gap: 35px; align-items: center; flex-wrap: wrap; background-color: rgba(217, 217, 217, 0.32);
        width: 48%; padding: 65px; border-radius: 40px; margin-left: 430px; margin-top: 100px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
 
                   


        <div class="left1" style="display: flex; align-items: center; gap: 130px;">
            <label style="font-size: 27px; color: rgb(66, 66, 66);">Description</label>
            <input type="text" name="txtdesc" style="width: 400px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;">
        </div>

        <div class="left1" style="display: flex; align-items: center; gap: 174px;">
            <label style="font-size: 27px; color: rgb(66, 66, 66);">Amount</label>
            <input type="text" name="txtamount" style="width: 400px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;">
        </div>
    
        <div class="left" style="display: flex; align-items: center; gap: 100px;">
            <label style="font-size: 27px; color: rgb(66, 66, 66);">Expense Type</label>
            <select name="txttype" id="" style="width: 410px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;">
                <option value="Local Orders"> Salaries</option>
                <option value="Export Orders"> Raw Materials</option>
                <option value="Printing">Delivery Costs</option>
                <option value="Additional Expenses">Additional Expenses</option>
            </select>
        </div>

        <div class="btn" style="margin-top: 60px;">
            <input type="submit" name="btnadd" value="ADD" style="width: 300px; height: 60px; background-color: rgb(32, 32, 32); color: rgb(255, 255, 255); border-radius: 50px; border: none; font-size: 23px; font-weight: 600; cursor: pointer;">
        </div>

        <div style="text-align: center;">
            <?php 
                if ($del === true) {
                    echo "<p style='color: green; margin-top: 40px; font-size: 20px; font-weight: bold;'>Revenue added successfully!</p>";
                } elseif ($del === false) {
                    echo "<p style='color: red; font-weight: bold; margin-top: 40px; font-size: 20px;'>Revenue not added.</p>";
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

