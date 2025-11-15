<?php
include 'connect.php';
session_start();

$del = "";
$deleted = "";
$rows = []; // Initialize $rows to avoid undefined variable notice

if (isset($_POST['btnsubmit'])) {
    $name = $_POST['txtname'];
    $date = $_POST['txtdate'];
    $info = $_POST['txtinfo'];
    $id = $_SESSION['LoginID'];
    $suc = $_POST['txtsuccess'];

    // Validate inputs
    if (empty($name) || empty($date) || empty($info) || empty($id) || empty($suc)) {
        $del = false;
        $error_message = "All fields are required.";
    } else {
        $sql = "INSERT INTO DepartmentOperation (DOperationName, DOperationDate, DOperationInfo, DirectorId, sucessRate) VALUES ('$name', '$date', '$info', '$id', '$suc')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $del = true;
        } else {
            $del = false;
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}

if (isset($_POST['searchbtn'])) {
    $lid = $_POST['txtid'];

    if (empty($lid)) {
        $deleted = false;
        $error_message = "Please enter an ID to search.";
    } else {
        $sql2 = "SELECT * FROM DepartmentOperation WHERE DOperationID='$lid'";
        $result2 = mysqli_query($conn, $sql2);

        if ($result2 && mysqli_num_rows($result2) > 0) {
            $rows = mysqli_fetch_assoc($result2);
            $deleted = true;
        } else {
            $deleted = false;
            $error_message = "No record found with the given ID.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="dept opr.css">
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
        
                    <a class="profile-btn" href="../../2-Director/directorhome.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1">
    
                <div class="info">
                    <label for="">DEPT.OPERATION AT TECHSPACE</label>
                    <h1>Department Operation</h1>
                    <p>"The Department Operations at Techspace oversee the seamless functioning of our apparel business, ensuring efficiency in production, supply chain management, quality control, and distribution."</p>
                </div>
                
            </div>
    
        </div>

    </div>


    <form method="post">
        <div class="left1" style="display: flex; align-items: center; gap: 20px; margin-left:100px; margin-top:80px;">
            <input type="text" name="txtid" placeholder="Search Operation ID" value="<?php echo isset($_POST['txtid']) ? htmlspecialchars($_POST['txtid']) : ''; ?>"> 
            <button name="searchbtn" id="btnsearch" style="border: none; background-color: white;"><img src="search.png" style="width: 50px; height: 50px; cursor: pointer;" alt=""></button>
        </div>
    </form>

    <form method="post" >

        <div class="main" style="display: flex; align-items: center; justify-content: center; gap: 470px; margin-left: 60px; border: none; border-radius: 40px; padding: 60px; 
            background-color: rgba(245, 244, 244, 0.781); margin-right: 60px; flex-wrap: wrap; margin-top:100px;  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">

            <div class="main-flex" style="display: flex; flex-direction: column; gap: 35px;">
                    
                <div class="left1" style="display: flex; align-items: center; gap: 75px;">
                    <label style="font-size: 32px;">Department Name</label>
                    <input type="text" style="color: rgba(32, 32, 32, 0.78);" name="txtname" value="<?php echo isset($rows['DOperationName']) ? htmlspecialchars($rows['DOperationName']) : ''; ?>" readonly>
                </div>
                
                <div class="left1" style="display: flex; align-items: center; gap: 120px;">
                    <label style="font-size: 32px;">Operation Date</label>
                    <input type="date" style="color: rgba(32, 32, 32, 0.78);" name="txtdate" value="<?php echo isset($rows['DOperationDate']) ? htmlspecialchars($rows['DOperationDate']) : ''; ?>" readonly>    
                </div>
                
                <label style="font-size: 32px;">Operation Info</label>
                <textarea name="txtinfo" style="width:700px; border-radius: 10px; height:300px; font-size:23px; border:none; outline: none; color: rgba(32, 32, 32, 0.78); background-color: #e4e2e2; padding-left: 20px; padding-top: 15px;" cols="10" rows="7" readonly><?php echo isset($rows['DOperationInfo']) ? htmlspecialchars($rows['DOperationInfo']) : ''; ?></textarea>
        
            </div>

            <div class="left1" style="display: flex; flex-direction: column; gap:40px; align-items: center;">
                <label style="font-size: 32px; color:rgba(32, 32, 32, 0.78);">Success Rate</label>
                <input type="text" style="width:360px; height: 360px; border-radius: 50%; background-color: rgba(23, 24, 24, 1); color:rgba(187, 241, 214, 1); text-align: center; font-size: 150px;" name="txtsuccess" value="<?php echo isset($rows['sucessRate']) ? htmlspecialchars($rows['sucessRate']) : ''; ?>" readonly>
            </div> 

        </div>

        

    </form>

    

    <form method="post">

        <h1 style="font-size:45px; margin:100px;">Add Operation</h1>
        <div class="main-flex" style="display: flex; justify-content: center; align-items: center; margin-top:100px; flex-direction: column; gap: 35px; margin-left: 60px; border: none; 
            border-radius: 40px; padding: 60px; background-color: rgba(245, 244, 244, 0.781); margin-left: 330px; flex-wrap: wrap; width:60%; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
            
            <div class="left1" style="display: flex; align-items: center; gap: 75px;">
                <label style="font-size: 32px;">Department Name :</label>
                <input type="text" name="txtname">
            </div>
            
            <div class="left1" style="display: flex; align-items: center; gap: 136px;">
                <label style="font-size: 32px;">Operation Date</label>
                <input type="date" name="txtdate">
            </div>

            <div class="left1" style="display: flex; flex-direction: column; gap:40px; justify-content: center;">
                <label style="font-size: 32px;">Operation Info</label>
                <textarea name="txtinfo" id="" style="width:710px; border-radius: 10px; height:300px; font-size:23px; border:none; outline: none; background-color: #e4e2e2; padding-left: 20px; padding-top: 15px;" cols="5" rows="7" value="value="<?php echo ($rows) ? htmlspecialchars($rows['DOperationInfo']) : ''; ?>" readonly"></textarea>
            </div>
            

            <div class="left1" style="display: flex; align-items: center; gap: 150px;">
                <label style="font-size: 32px;">Success Rate</label>
                <input type="text" name="txtsuccess" id="" >
            </div>


            <input type="submit" name="btnsubmit" value="ADD" id="btnadd" class="bbb" style="width:200px; height: 60px; background-color: black; color: white; font-weight: 550; margin-top:40px; cursor: pointer;">

            <div class="msg">
                    <?php 
                    if ($del=== true) {
                            echo '<div style="color: green; font-size:22px; margin-top:20px;">Record Added Successfully</div>';
                    } elseif ($del ===false) {
                            echo '<div style="color: red; font-weight: 500; font-size:20px;">Error: Record is not Added !</div>';
                    }

                    ?>
                </div>
    </form>
        <style>

            input{
                width: 380px;
                height: 55px;
                border-radius: 10px;
                outline: none;
                background-color: #e4e2e2;
                border: none;
                padding-left: 10px;
                font-size: 24px;
            }


        </style>

        </div>

        

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
 
