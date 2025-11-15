<?php
include 'connect.php';
session_start();

// Handle leave request approval/rejection
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['LRequestID']) && isset($_POST['status'])) {
        $planID = mysqli_real_escape_string($conn, $_POST['LRequestID']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        // Update the request status
        $sql = "UPDATE LeaveRequest SET RequestStatus = ? WHERE LRequestID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'si', $status, $planID);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $_SESSION['message'] = "Leave Request $planID updated to $status successfully!";
        } else {
            $_SESSION['message'] = "Error updating Request ID $planID: " . mysqli_error($conn);
        }

        // Redirect to prevent form resubmission
        header("Location: Leavereq.php");
        exit();
    }
}

// Fetch leave requests
$sql = "SELECT * FROM LeaveRequest";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request</title>
    <link rel="stylesheet" href="Leave req.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap">

</head>
<body>
    <div class="container">
        <div class="body-container">
            <div class="nav-bar">
                <img class="logo-img" src="01.jpg.png" alt="">
                <div class="nav-btns">
                    <a class="profile-btn" href="../../3-GM/gm.php">Back</a>
                </div>
            </div>
            <div class="back1">
                <div class="info">
                    <label>LEAVE REQUEST AT TECHSPACE</label>
                    <h1>LEAVE REQUEST</h1>
                    <p>"Techspace is a dynamic apparel company driven by a passionate team dedicated to innovation, quality, and style. Our staff brings creativity and expertise to every stage.we believe in teamwork, excellence, and customer satisfaction, making us a trusted name in the industry."</p>
                </div>
            </div>
        </div>
    </div>

   
    <form method="post">
    <div class="form-container" style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 30px;">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="main-flex" style="display: flex; flex-direction: column; padding: 65px; flex-wrap: wrap; gap: 25px; border: none; border-radius: 30px; width: 32%; background-color: rgba(221, 221, 221, 0.4); margin-top: 70px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
                <div class="left1" style="display: flex; align-items: center; gap: 99px;">
                    <label style="font-size: 23px;">Request ID</label>
                    <input type="text" style="width: 360px; height: 45px;outline: none; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(224, 222, 222); border-radius: 10px; " value="<?= htmlspecialchars($row['LRequestID']) ?>" readonly>
                </div>
                <div class="left1" style="display: flex; align-items: center; gap: 70px;">
                    <label style="font-size: 23px;">Request Type</label>
                    <select name="requestType" disabled style="width: 370px; height: 50px; font-size: 20px; padding-left: 10px; outline: none; border-radius: 10px; background-color: rgb(218, 216, 216); border: none;">
                        <option style="background-color: rgba(0, 0, 0, 0.795); color: white;" value="Annual Leave" <?= ($row['LRequestType'] == 'Annual Leave') ? 'selected' : ''; ?>>Annual Leave</option>
                        <option style="background-color: rgba(0, 0, 0, 0.795); color: white;" value="Sick Leave" <?= ($row['LRequestType'] == 'Sick Leave') ? 'selected' : ''; ?>>Sick leave</option>
                    </select>
                </div>
                <div class="left1" style="display: flex; align-items: center; gap: 110px;">
                    <label style="font-size: 23px;">Start Date</label>
                    <input type="date" style="width: 360px; height: 45px;outline: none; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(224, 222, 222); border-radius: 10px; " value="<?= htmlspecialchars($row['StartDate']) ?>" readonly>
                </div>
                <div class="left1" style="display: flex; align-items: center; gap: 119px;">
                    <label style="font-size: 23px;">End Date</label>
                    <input type="date" style="width: 360px; height: 45px;outline: none; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(224, 222, 222); border-radius: 10px; " value="<?= htmlspecialchars($row['EndDate']) ?>" readonly>
                </div>
                <div class="left1" style="display: flex; align-items: center; gap: 148px;">
                    <label style="font-size: 23px;">Status</label>
                    <input type="text" style="width: 360px; height: 45px;outline: none; font-size: 20px; padding-left: 10px; border: none; background-color: rgb(224, 222, 222); border-radius: 10px; " value="<?= htmlspecialchars($row['RequestStatus']) ?>" readonly>
                </div>

                <div class="btns" style="display: flex; justify-content: space-around; margin-top: 60px;">
                    <form method="post">
                        <input type="hidden" name="LRequestID" value="<?= $row['LRequestID'] ?>">
                        <button type="submit" name="status" value="Approved" style="width: 220px; height:55px; background-color: black; color: white; border-radius: 50px; border: none; font-size: 18px; cursor: pointer;">
                            APPROVE
                        </button>
                    </form>
                    <form method="post">
                        <input type="hidden" name="LRequestID" value="<?= $row['LRequestID'] ?>">
                        <button type="submit" name="status" value="Rejected" style="width: 220px; height:55px; background-color: black; color: white; border-radius: 50px; border: none; font-size: 18px; cursor: pointer;">
                            REJECT
                        </button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
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
