<?php
include 'connect.php';
session_start();

$del = "";
$deleted = "";
$d="";



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $workerid = $_POST['txtworkerid'];
    $basicSalary = $_POST['txtsalary'];
    $otid = $_POST['txtotid'];
    $othours = $_POST['txtothours'];
    $otrate = $_POST['txtotrate'];
    $otamount = $_POST['txtotamount'];
    $bid = $_POST['txtbid'];
    $bdesc = $_POST['txtbdesc'];
    $bamount = $_POST['txtbamount'];
    $tid = $_POST['txttaxid'];
    $taxPercentage = $_POST['txttaxper'];
    $taxMonth = $_POST['txttaxmonth'];
    $tamount = $_POST['txttaxamount'];
    $aid = $_POST['txtapid'];
    $aamount = $_POST['txtapamount'];
    $adate = $_POST['txtapdate'];
    $finalSalary = $_POST['txtfsalary'];
    $id = $_SESSION['LoginID'];  // Make sure session is active and LoginID is set

    $sql = "INSERT INTO Salary (WorkerId, BasicSalary, OTID, OTHours, OTRate, OTAmount, BID, BDesc, BAmount, TID, TaxPercentage, TaxMonth, TAmount, AID, AAmount, ADate, FinalSalary, PayrollId) 
            VALUES ('$workerid', '$basicSalary', '$otid', '$othours', '$otrate', '$otamount', '$bid', '$bdesc', '$bamount', '$tid', '$taxPercentage', '$taxMonth', '$tamount', '$aid', '$aamount', '$adate', '$finalSalary', '$id')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Record Added Successfully";
        header("Location: CalSalary.php");
        exit();
    } else {
        $_SESSION['error'] = "Insertion unsuccessful: " . mysqli_error($conn);;
        
    }
}



if (isset($_POST['searchbtn'])) {
    $workerid = $_POST['txtworkerid'];

  
    
        $sql2 = "SELECT * FROM OTPayment WHERE  WorkerId='$workerid'";
        $result2 = mysqli_query($conn, $sql2);

        if ($result2 && mysqli_num_rows($result2) > 0) {
            $row = mysqli_fetch_assoc($result2);
            $deleted = true;
        } else {
            $deleted = false;
            $error_message = "No record found in the OT Table with the given ID.";
        }


        $sql3 = "SELECT * FROM SpecialBenefit WHERE  WorkerId='$workerid'";
        $result3 = mysqli_query($conn, $sql3);

        if ($result3 && mysqli_num_rows($result3) > 0) {
            $row2 = mysqli_fetch_assoc($result3);
            $deleted = true;
        } else {
            $deleted = false;
            $error_message = "No record found with the given ID.";
        }


        $sql4 = "SELECT * FROM Tax WHERE  WorkerId='$workerid'";
        $result4 = mysqli_query($conn, $sql4);

        if ($result4 && mysqli_num_rows($result4) > 0) {
            $row3 = mysqli_fetch_assoc($result4);
            $deleted = true;
        } else {
            $deleted = false;
            $error_message = "No record found in the Tax Table with the given ID.";
        }


        $sql5 = "SELECT * FROM AdvancePayment WHERE  WorkerId='$workerid'";
        $result5 = mysqli_query($conn, $sql5);

        if ($result5 && mysqli_num_rows($result5) > 0) {
            $row4 = mysqli_fetch_assoc($result5);
            $deleted = true;
        } else {
            $deleted = false;
            $error_message = "No record found with the given ID.";
        }


        if (mysqli_num_rows($result2) == 0 && mysqli_num_rows($result3) == 0 && mysqli_num_rows($result4) == 0 && mysqli_num_rows($result5) == 0) {
            $deleted = false;
            $error_message = "Worker ID not found!";
        }
        

    
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Cal Salary.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    <script type="text/javascript">
    function cal() {
        var bsalary = parseFloat(document.getElementById('txtsalary').value);
        var taxper = parseFloat(document.getElementById('txttaxper').value);
        
        var ot = parseFloat(document.getElementById('txtot').value) || 0;  // Default to 0 if not a valid number
        var benefit = parseFloat(document.getElementById('txtbene').value) || 0;  // Default to 0 if not a valid number
        var advance = parseFloat(document.getElementById('txtadvance').value) || 0;  // Default to 0 if not a valid number

        // Clear previous error message
        document.getElementById('txtt').textContent = "";

        // Validate input fields
        if (isNaN(bsalary) || bsalary <= 0) {
            document.getElementById('txtt').textContent = "Basic Salary can't be empty or invalid.";
        } else if (isNaN(taxper) || taxper < 0) {
            document.getElementById('txtt').textContent = "Tax Percentage can't be empty or invalid.";
        } else {
            var tax = bsalary * (taxper / 100);
            document.getElementById('taxamount').value = tax.toFixed(2); // Display tax amount with 2 decimal places
            
            // Calculate the final salary: Basic Salary + OT + Benefits - Advance - Tax
            var finalSalary = (bsalary + ot + benefit + advance) - tax;
            document.getElementById('txtfsalary').value = finalSalary.toFixed(2); // Display final salary
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
        
                    <a class="profile-btn" href="../../5-Payroll/payrollex.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1">
    
                <div class="info">
                    <label for="">SALARY INFO AT TECHSPACE</label>
                    <h1>SALARY</h1>
                    <p>"The salary structure at Techspace, an apparel company, is designed to be competitive and fair, reflecting industry standards and employee expertise. Compensation varies based on roles, experience, and performance, ensuring that skilled professionals are rewarded appropriately."</p>
                </div>
                
            </div>
    
        </div>

    </div>




    <!-------------------------------------------------------------------------------------------------------------->

    <h1 style="font-size: 45px; margin: 100px;">Calculate <span style="color: rgb(235, 53, 53); margin-left: 10px;">Salary</span></h1>

    <!---------------------------------------------LEFT----------------------------------------------------------------->

    <div class="container1">
    <table class="content-table" style="border-collapse: collapse; margin-left:50px;margin-top:100px;">
        <thead>
            <tr style="background-color: black; color:white; font-size: 18px;">

                <th style="text-align: center; padding: 20px;">Worker ID</th>
                <th style="text-align: center;">Salary ID</th>
                <th style="text-align: center; width: 150px;">Basic Salary</th>
                <th style="text-align: center; width: 80px;">OT ID</th>
                <th style="text-align: center; width: 120px;">OT amount</th>
                <th style="text-align: center; width: 150px;">Benefit ID</th>
                <th style="text-align: center; width: 150px;">Benefit Amount</th>
                <th style="text-align: center; width: 120px;">Tax ID</th>
                <th style="text-align: center; width: 130px;">Tax Amount</th>
                <th style="text-align: center; width: 250px;">Advance Payment ID</th>
                <th style="text-align: center; width: 250px;">Advance payment Amount</th>
                <th style="text-align: center; width: 190px;">Final Salary    </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql6 = "SELECT * FROM Salary";
            $result6 = mysqli_query($conn, $sql6);
            if (mysqli_num_rows($result6) > 0) {
                while ($row6 = mysqli_fetch_assoc($result6)) {
                    echo "<tr style='background-color:rgba(255, 255, 255, 0.164);font-size: 20px;border-bottom:none;'>
                            <td style='text-align: center; padding: 20px; '>{$row6['WorkerId']}</td>
                             <td style='text-align: center; ;'>{$row6['SalaryID']}</td>
                            <td style='text-align: center;'>{$row6['BasicSalary']}</td>
                            <td style='text-align: center;'>{$row6['OTID']}</td>
                            <td style='text-align: center;'>{$row6['OTAmount']}</td>
                            <td style='text-align: center;'>{$row6['BID']}</td>
                             <td style='text-align: center;'>{$row6['BAmount']}</td>
                              <td style='text-align: center;'>{$row6['TID']}</td>
                              <td style='text-align: center;'>{$row6['TAmount']}</td>
                               <td style='text-align: center;'>{$row6['AID']}</td>
                               <td style='text-align: center;'>{$row6['AAmount']}</td>
                                <td style='text-align: center;'>{$row6['FinalSalary']}</td>
                          </tr>";
                }
            }
            ?>
        </tbody> 
    </table>
</div>



    <form method="post">
    <div class="left1" style="display: flex; justify-content: center; gap: 15px; margin-top: 100px;">
        
        <input type="text" name="txtworkerid" placeholder="Search worker ID" value="<?php echo isset($_POST['txtworkerid']) ? htmlspecialchars($_POST['txtworkerid']) : ''; ?>" 
        style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
        
        <button name="searchbtn" id="btnsearch" style="border: none; background-color: white;">
            <img src="search.png" style="width: 50px; height: 50px; cursor: pointer;" alt="">
        </button>
    </div>




    <div class="main-flex" style="display: flex; flex-direction: column; align-items: center; gap: 100px; margin-top: 100px; background-color: rgba(236, 234, 234, 0.527); padding: 90px; border-radius: 40px;
        width: 70%; margin-left: 200px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">

        <div class="main" style="display: flex; justify-content: center; align-items: center; gap: 300px; flex-wrap: wrap; ">


        
            <div class="left" style="display: flex; flex-direction: column; justify-content: center; gap: 25px;">
    
            
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">OT ID</label>
                    <input type="text" name="txtotid" value="<?php echo isset($row['OTPaymentID']) ? htmlspecialchars($row['OTPaymentID']) : ''; ?>" readonly  style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">OT Hours</label>
                    <input type="text" name="txtothours" value="<?php echo isset($row['OTHours']) ? htmlspecialchars($row['OTHours']) : ''; ?>" readonly style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">OT Rate</label>
                    <input type="text" name="txtotrate" value="<?php echo isset($row['OTRate']) ? htmlspecialchars($row['OTRate']) : ''; ?>" readonly style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">OT Amount</label>
                    <input type="text" name="txtotamount" id="txtot" value="<?php echo isset($row['OTAmount']) ? htmlspecialchars($row['OTAmount']) : ''; ?>" readonly  style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Benefit ID</label>
                    <input type="text" name="txtbid" value="<?php echo isset($row2['SBenefitID']) ? htmlspecialchars($row2['SBenefitID']) : ''; ?>" readonly  style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Benefit Description</label>
                    <textarea  name="txtbdesc" readonly  style="width: 390px; height: 150px; padding-top: 10px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                        <?php echo isset($row2['SBenefitDesc']) ? htmlspecialchars($row2['SBenefitDesc']) : ''; ?>
                    </textarea>
                </div>

            
            </div>
        
            <!---------------------------------------------LEFT----------------------------------------------------------------->
        
        
        
            <!---------------------------------------------RIGHT----------------------------------------------------------------->
        
            <div class="right" style="display: flex; flex-direction: column; justify-content: center; gap: 25px;">
    
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Benefit Amount</label>
                    <input type="text" name="txtbamount" id="txtbene" value="<?php echo isset($row2['SBenefitAmount']) ? htmlspecialchars($row2['SBenefitAmount']) : ''; ?>" readonly  style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Tax ID</label>
                    <input type="text" name="txttaxid" value="<?php echo isset($row3['TaxID']) ? htmlspecialchars($row3['TaxID']) : ''; ?>"readonly  style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Tax Percentage</label>
                    <input type="text" name="txttaxper" id="txttaxper" value="<?php echo isset($row3['TaxPercentage']) ? htmlspecialchars($row3['TaxPercentage']) : ''; ?>" readonly  style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>

                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Tax Month</label>
                    <input type="month" name="txttaxmonth" value="<?php echo isset($row3['TaxMonth']) ? htmlspecialchars($row3['TaxMonth']) : ''; ?>"  readonly  style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
        
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Advance Payment ID</label>
                    <input type="text" name="txtapid" value="<?php echo isset($row4['ADPaymentID']) ? htmlspecialchars($row4['ADPaymentID']) : ''; ?>"  readonly  style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Advance Amount</label>
                    <input type="text" name="txtapamount" id="txtadvance" value="<?php echo isset($row4['ADPAmount']) ? htmlspecialchars($row4['ADPAmount']) : ''; ?>"  readonly  style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Date</label>
                    <input type="date" name="txtapdate" value="<?php echo isset($row4['APDate']) ? htmlspecialchars($row4['APDate']) : ''; ?>" readonly  style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
            </div>
           
            <!---------------------------------------------RIGHT----------------------------------------------------------------->
    
            
        </div>


        <div class="mmmm" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">

        
        <p id="txtt"></p>
                 <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Basic Salary</label>
                    <input type="text" name="txtsalary" id="txtsalary" style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>

                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px; margin-top: 30px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Tax Amount</label>
                    <input type="text" name="txttaxamount" id="taxamount"  style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>

                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px; margin-top: 30px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Final Salary</label>
                    <input type="text" name="txtfsalary" id="txtfsalary"  style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
        </form>
        
       
       


       <div style="text-align: center;">
    <?php 
        if (!empty($error_message)) {
            echo "<p style='color: red; font-weight: bold; margin-top: 40px; font-size: 20px;'>$error_message</p>";
        } elseif (isset($_SESSION['success'])) {
            echo "<p style='color: green; margin-top: 40px; font-size: 20px; font-weight: bold;'>{$_SESSION['success']}</p>";
            unset($_SESSION['success']); 
        }
    ?>
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
    
    <div class="button" style="display: flex; justify-content: center; align-items: center; margin-top: 0px; gap: 40px;">
        <input type="button" onclick="cal()" value="CALCULATE" style="width: 200px; height: 50px; border-radius: 50px; border: none; background-color: black; color: white; font-size: 20px; font-weight: 500; cursor: pointer;">
            
    <input type="submit" name="add" value="ADD" style="width: 200px; height: 50px; border-radius: 50px; border: none; background-color: black; color: white; font-size: 20px; font-weight: 500; cursor: pointer;">
  



    

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