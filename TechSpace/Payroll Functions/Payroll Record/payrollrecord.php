<?php
include 'connect.php';
session_start();

$del = "";
$deleted = "";
$d="";


if (isset($_POST['searchbtn'])) {
    $salaryid = $_POST['txtsalaryid'];

  
    
        $sql2 = "SELECT * FROM Salary WHERE  SalaryID='$salaryid'";
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
    $salaryid = $_POST['txtsalaryid'];
    $workerid = $_POST['txtworkerid'];
    $bsalary = $_POST['txtbsalary'];
    $othours = $_POST['txtothours'];
    $otrate = $_POST['txtotrate'];
    $otamount = $_POST['txtotamount'];
    $benedesc = $_POST['txtbdesc'];
    $bamount = $_POST['txtbamount'];
    $taxpercen = $_POST['txttaxper'];
    $taxmonth = $_POST['txttaxmonth'];
    $taxamount = $_POST['txttaxamount'];
    $adamount = $_POST['txtapamount'];
    $addate = $_POST['txtapdate'];
    $finals = $_POST['txtfsalary'];
    $id = $_SESSION['LoginID'];


$sql = "INSERT INTO `PayrollRecord`( `SalaryID`, `WorkerId`, `BasicSalary`, `OTHours`, `OTRate`, `OTAmount`, `BenefitDesc`, `BenefitAmount`, `TaxPercentage`, `TaxMonth`, `TAmount`, `APAmouont`, `APDate`, `FinalSalary`, `PayrollId`) VALUES 
        ('$salaryid' ,'$workerid' ,'$bsalary', ' $othours', '$otrate',' $otamount',' $benedesc','$bamount','$taxpercen','$taxmonth','$taxamount','$adamount','$addate','$finals','$id')";

        $result = mysqli_query($conn,$sql);

        if( $result)
        {
            $_SESSION['success'] = "Record Added Successfully";
            header("Location: payrollrecord.php");
            exit();
        }
        else
        {
            $_SESSION['error'] = "Insertion unsuccessful: " . mysqli_error($conn);;

        }


}


if(isset($_POST['btnupdate']))
{
    $salaryid = $_POST['txtsalaryid'];
    $workerid = $_POST['txtworkerid'];
    $bsalary = $_POST['txtbsalary'];
    $othours = $_POST['txtothours'];
    $otrate = $_POST['txtotrate'];
    $otamount = $_POST['txtotamount'];
    $benedesc = $_POST['txtbdesc'];
    $bamount = $_POST['txtbamount'];
    $taxpercen = $_POST['txttaxper'];
    $taxmonth = $_POST['txttaxmonth'];
    $taxamount = $_POST['txttaxamount'];
    $adamount = $_POST['txtapamount'];
    $addate = $_POST['txtapdate'];
    $finals = $_POST['txtfsalary'];
    $id = $_SESSION['LoginID'];


    $sql = "UPDATE PayrollRecord SET WorkerId='$workerid', BasicSalary='$bsalary', OTHours='$othours', OTRate='$otrate', OTAmount='$otamount',
    BenefitDesc='$benedesc', BenefitAmount='$bamount', TaxPercentage='$taxpercen', TaxMonth='$taxmonth', TAmount='$taxamount', APAmouont='$adamount', APDate='$addate',
    FinalSalary='$finals' WHERE SalaryID='$salaryid'";

        $result = mysqli_query($conn,$sql);
        if ($result) {
            $_SESSION['success'] = "Record Updated Successfully";
        
            // Fetch updated record
            $sql2 = "SELECT * FROM PayrollRecord WHERE SalaryID='$salaryid'";
            $result2 = mysqli_query($conn, $sql2);
            if ($result2 && mysqli_num_rows($result2) > 0) {
                $row = mysqli_fetch_assoc($result2);
            }
        
            // Redirect to prevent form resubmission
            header("Location: payrollrecord.php?edit_id=$salaryid");
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
    <link rel="stylesheet" href="payroll record.css">
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
                    <label for="">PAY ROLL RECORD AT TECHSPACE</label>
                    <h1>PAY ROLL RECORD</h1>
                    <p>"Techspace maintains accurate and efficient payroll records to ensure timely and transparent compensation for all employees. Our payroll system tracks wages, deductions, benefits, and tax compliance, adhering to industry standards and labor laws."</p>
                </div>
                
            </div>
    
        </div>

    </div>



    <!-------------------------------------------------------------------------------------------------------------->

    <h1 style="font-size: 45px; margin: 100px;"><span style="color: rgb(235, 53, 53); margin-right: 20px;">Record</span>Info</h1>

    <!---------------------------------------------LEFT----------------------------------------------------------------->

    
     
    <div class="container1">
    <table class="content-table" style="border-collapse: collapse; margin-left:45px;margin-top:100px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
        <thead>
            <tr style="background-color: black; color:white; font-size: 18px;">
                <th style="text-align: center; padding:20px;">Payroll Record ID</th>
                <th style="text-align: center; width: 150px;">Worker ID</th>
                <th style="text-align: center; width: 150px;">Salary ID</th>
                <th style="text-align: center; width: 150px;">Basic Salary</th>
                <th style="text-align: center; width: 180px;">OT amount</th>
                <th style="text-align: center; width: 180px;">Benefit Amount</th>
                <th style="text-align: center; width: 180px;">Tax Amount</th>
                <th style="text-align: center; width: 350px;">Advance payment Amount</th>
                <th style="text-align: center; width: 280px;">Final Salary    </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql4 = "SELECT * FROM PayrollRecord";
            $result4 = mysqli_query($conn, $sql4);
            if (mysqli_num_rows($result4) > 0) {
                while ($row4 = mysqli_fetch_assoc($result4)) {
                    echo "<tr style='background-color:rgba(255, 255, 255, 0.164);font-size: 23px;border-bottom:none;'>
                            <td style='text-align: center; padding: 20px; '>{$row4['PRecordID']}</td>
                            <td style='text-align: center;'>{$row4['WorkerId']}</td>
                             <td style='text-align: center; '>{$row4['SalaryID']}</td>
                            <td style='text-align: center; '>{$row4['BasicSalary']}</td>
                            <td style='text-align: center;'>{$row4['OTAmount']}</td>
                             <td style='text-align: center;'>{$row4['BenefitAmount']}</td>
                              <td style='text-align: center;'>{$row4['TAmount']}</td>
                               <td style='text-align: center;'>{$row4['APAmouont']}</td>
                                <td style='text-align: center;'>{$row4['FinalSalary']}</td>
                          </tr>";
                }
            }
            ?>
        </tbody> 
    </table>
</div>


    <form method="post">
    <div class="left1" style="display: flex; align-items: center; justify-content: center; gap: 15px; margin-top: 100px;">

        
        <input type="text" placeholder="Search Salary ID" name="txtsalaryid" value="<?php echo isset($_POST['txtsalaryid']) ? htmlspecialchars($_POST['txtsalaryid']) : ''; ?>" 
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
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Worker ID</label>
                    <input type="text" name="txtworkerid" value="<?php echo isset($row['WorkerId']) ? htmlspecialchars($row['WorkerId']) : ''; ?>"   style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Basic Salary</label>
                    <input type="text" name="txtbsalary" value="<?php echo isset($row['BasicSalary']) ? htmlspecialchars($row['BasicSalary']) : ''; ?>"  style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">OT Hours</label>
                    <input type="text" name="txtothours" value="<?php echo isset($row['OTHours']) ? htmlspecialchars($row['OTHours']) : ''; ?>"  style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">OT Rate</label>
                    <input type="text" name="txtotrate" value="<?php echo isset($row['OTRate']) ? htmlspecialchars($row['OTRate']) : ''; ?>"  style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">OT Amount</label>
                    <input type="text" name="txtotamount" id="txtot" value="<?php echo isset($row['OTAmount']) ? htmlspecialchars($row['OTAmount']) : ''; ?>"   style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>

                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Benefit Description</label>
                    <textarea  name="txtbdesc"   style="width: 390px; height: 150px; padding-top: 10px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                        <?php echo isset($row['BDesc']) ? htmlspecialchars($row['BDesc']) : ''; ?>
                    </textarea>
                </div>
            </div>
        
            <!---------------------------------------------LEFT----------------------------------------------------------------->
        
        
        
            <!---------------------------------------------RIGHT----------------------------------------------------------------->
        
            <div class="right" style="display: flex; flex-direction: column; justify-content: center; gap: 25px;">
        
            
            
            <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Benefit Amount</label>
                    <input type="text" name="txtbamount" id="txtbene" value="<?php echo isset($row['BAmount']) ? htmlspecialchars($row['BAmount']) : ''; ?>"   style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
                      
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Tax Percentage</label>
                    <input type="text" name="txttaxper" id="txttaxper" value="<?php echo isset($row['TaxPercentage']) ? htmlspecialchars($row['TaxPercentage']) : ''; ?>"   style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>

                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Tax Month</label>
                    <input type="month" name="txttaxmonth" value="<?php echo isset($row['TaxMonth']) ? htmlspecialchars($row['TaxMonth']) : ''; ?>"    style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Tax Amount</label>
                    <input type="text" name="txttaxamount" id="taxamount" value="<?php echo isset($row['TAmount']) ? htmlspecialchars($row['TAmount']) : ''; ?>"     style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Advance Payment  Amount</label>
                    <input type="text" name="txtapamount" id="txtadvance" value="<?php echo isset($row['AAmount']) ? htmlspecialchars($row['AAmount']) : ''; ?>"    style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Advance Payment Date</label>
                    <input type="date" name="txtapdate" value="<?php echo isset($row['ADate']) ? htmlspecialchars($row['ADate']) : ''; ?>"   style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>

                <div class="left1" style="display: flex; flex-direction: column; justify-content: center; gap: 15px;">
                    <label style="font-size: 25px; color: rgb(48, 48, 48);">Final Salary</label>
                    <input type="text" name="txtfsalary" id="txtfsalary" value="<?php echo isset($row['FinalSalary']) ? htmlspecialchars($row['FinalSalary']) : ''; ?>"   style="width: 390px; height: 50px; outline: none; border: none; background-color: rgba(217, 217, 217, 1); border-radius: 10px; padding-left: 10px; font-size: 20px;">
                </div>
            
            </div>     
            
            <div style="text-align: center;">
        <?php 
            if (isset($_SESSION['success'])) {
                echo "<p style='color: green; margin-top: -200px; font-size: 20px; font-weight: bold;'>{$_SESSION['success']}</p>";
                unset($_SESSION['success']); 
            } elseif (isset($_SESSION['error'])) {
                echo "<p style='color: red; font-weight: bold; margin-top: -200px; font-size: 20px;'>{$_SESSION['error']}</p>";
                unset($_SESSION['error']); 
            }
        ?>
    </div>


           
            <!---------------------------------------------RIGHT----------------------------------------------------------------->
    
        </div>

        <div class="button" style="display: flex; gap: 100px; margin-top:-200px;">
            <input type="submit" name="btnadd" value="ADD" style="width: 200px; height: 50px; border-radius: 50px; border: none; background-color: black; color: white; font-size: 20px; font-weight: 500; cursor: pointer;">
            <input type="submit" name="btnupdate" value="UPDATE" style="width: 200px; height: 50px; border-radius: 50px; border: none; background-color: black; color: white; font-size: 20px; font-weight: 500; cursor: pointer;">
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