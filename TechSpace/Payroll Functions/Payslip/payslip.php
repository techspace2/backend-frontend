<?php
include 'connect.php';
session_start();

$del = "";
$deleted = "";
$d="";


if (isset($_POST['searchbtn'])) {
    $payrollid = $_POST['txtpayrollrecordid'];

  
    
        $sql2 = "SELECT * FROM PayrollRecord WHERE  PRecordID='$payrollid'";
        $result2 = mysqli_query($conn, $sql2);

        if ($result2 && mysqli_num_rows($result2) > 0) {
            $row = mysqli_fetch_assoc($result2);
           
        } 


        if (mysqli_num_rows($result2) == 0 ) {
            $deleted = false;
            $error_message = "Worker ID not found!";
        }
        

    
}

if(isset($_POST['btnadd']))
{
    $prollid= $_POST['txtpayrollrecordid'];
    $salaryid = $_POST['txtsalary'];
    $workerid = $_POST['txtworker'];
    $basesalary = $_POST['txtbasesalary'];
    $finalsalary = $_POST['txtfinal'];
    $id = $_SESSION['LoginID'];

    $sql = "INSERT INTO PaySlip (SalaryId,WorkerId,PRollRecordId,BaseSalary,FinalSalary,PayrollId) VALUES ('$salaryid','$workerid',' $prollid','$basesalary','$finalsalary','$id')";
    $reesult =mysqli_query($conn,$sql);

    if( $reesult)
        {
            $_SESSION['success'] = "Record Added Successfully";
            header("Location: payslip.php");
            exit();
        }
        else
        {
            $_SESSION['error'] = "Insertion unsuccessful: " . mysqli_error($conn);;

        }


}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="payslip.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="body-container">

            <div class="nav-bar">
    
                <img class="logo-img" src="../Cal Salary/01.jpg.png" alt="">
               
                <div class="nav-btns">
        
                    <a class="profile-btn" href="../../5-Payroll/payrollex.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1">
    
                <div class="info">
                    <label for="">Pay Slip AT TECHSPACE</label>
                    <h1>PAY SLIP</h1>
                    <p>"This payslip is issued by Techspace, an apparel company committed to quality and innovation. It reflects the earnings, deductions, and net salary for the designated period. For any clarifications, please contact the HR department."</p>
                </div>
                
            </div>
    
        </div>

    </div>

    <!------------------------------------------------------------------------------------------------------>


    <div class="container1">
    <table class="content-table" style="border-collapse: collapse; margin-left:300px; margin-top:100px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
        <thead>
            <tr style="background-color: black; color:white; font-size: 18px;">
                <th style="text-align: center; padding:20px; width: 200px;">Pay Slip  ID</th>
                <th style="text-align: center; width: 200px;">Worker ID</th>
                <th style="text-align: center; width: 200px;">Salary ID</th>
                <th style="text-align: center; width: 200px;">Payroll Record ID</th>
                <th style="text-align: center; width: 200px;">Basic Salary</th>
                <th style="text-align: center; width: 200px;">Final Salary    </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql4 = "SELECT * FROM PaySlip";
            $result4 = mysqli_query($conn, $sql4);
            if (mysqli_num_rows($result4) > 0) {
                while ($row4 = mysqli_fetch_assoc($result4)) {
                    echo "<tr style='background-color:rgba(255, 255, 255, 0.164);font-size: 23px;border-bottom:none;'>
                            <td style='text-align: center; padding: 20px;'>{$row4['PSlipID']}</td>
                            <td style='text-align: center; '>{$row4['WorkerId']}</td>
                             <td style='text-align: center; '>{$row4['SalaryId']}</td>
                             <td style='text-align: center; '>{$row4['PRollRecordId']}</td>
                            <td style='text-align: center;'>{$row4['BaseSalary']}</td>
                                <td style='text-align: center;'>{$row4['FinalSalary']}</td>
                          </tr>";
                }
            }
            ?>
        </tbody> 
    </table>
</div>

    <form method="post">
    <div class="left1" style="display: flex; margin-top: 100px; align-items: center; justify-content: center; gap: 15px;">
       
        <input type="text" placeholder="Search Payroll ID" name="txtpayrollrecordid" value="<?php echo isset($_POST['txtpayrollrecordid']) ? htmlspecialchars($_POST['txtpayrollrecordid']) : ''; ?>" 
        style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
        
        <button name="searchbtn" id="btnsearch" style="border: none; background-color: white;">
            <img src="search.png" style="width: 50px; height: 50px; cursor: pointer;" alt="">
        </button>
    </div>


    <div class="main-flex" style="display: flex; flex-direction: column;justify-content: center; gap: 35px; align-items: center; flex-wrap: wrap; background-color: rgba(217, 217, 217, 0.32);
        width: 48%; padding: 65px; border-radius: 40px; margin-left: 430px; margin-top: 100px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">

        <div class="left1" style="display: flex; align-items: center; gap: 90px;">
            <label style="font-size: 24px; color: rgb(66, 66, 66);">Salary ID</label>
            <input type="text" name="txtsalary" value="<?php echo isset($row['SalaryID']) ? htmlspecialchars($row['SalaryID']) : ''; ?>" readonly style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;">
        </div>
    
        <div class="left1" style="display: flex; align-items: center; gap: 82px;">
            <label style="font-size: 24px; color: rgb(66, 66, 66);">Worker ID</label>
            <input type="text" name="txtworker" value="<?php echo isset($row['WorkerId']) ? htmlspecialchars($row['WorkerId']) : ''; ?>" readonly style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;">
        </div>

        <div class="left1" style="display: flex; align-items: center; gap: 58px;">
            <label style="font-size: 24px; color: rgb(66, 66, 66);">Base Salary</label>
            <input type="text" name="txtbasesalary" value="<?php echo isset($row['BasicSalary']) ? htmlspecialchars($row['BasicSalary']) : ''; ?>" readonly style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;">
        </div>

        <div class="left1" style="display: flex; align-items: center; gap: 59px;">
            <label style="font-size: 24px; color: rgb(66, 66, 66);">Final Salary</label>
            <input type="text" name="txtfinal" value="<?php echo isset($row['FinalSalary']) ? htmlspecialchars($row['FinalSalary']) : ''; ?>" readonly style="width: 390px; height: 55px; border-radius: 12px; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(226, 223, 223); outline: none;">
        </div>

        <div class="btn" style="margin-top: 30px; ">
            <input type="submit" name="btnadd" value="SAVE" style="width: 200px; height: 50px; background-color: rgb(211, 97, 20); color: rgb(255, 255, 255); border-radius: 20px; border: none; font-size: 20px; font-weight: 600; cursor: pointer;">
        </div>

        <div style="text-align: center;">
        <?php 
            if (isset($_SESSION['success'])) {
                echo "<p style='color: green; margin-top: 40px; font-size: 20px; font-weight: bold;'>{$_SESSION['success']}</p>";
                unset($_SESSION['success']); 
            } elseif (isset($_SESSION['error'])) {
                echo "<p style='color: red; font-weight: bold; margin-top: 40px; font-size: 20px;'>{$_SESSION['error']}</p>";
                unset($_SESSION['error']); 
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


