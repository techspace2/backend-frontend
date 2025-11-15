<?php 

include 'connect.php';
session_start();

$del = "";

if (isset($_POST['btnadd'])) {
    $info = mysqli_real_escape_string($conn, $_POST['txtinfo']);
    $date = mysqli_real_escape_string($conn, $_POST['txtdate']);
    $id = $_SESSION['LoginID'];

    $sql_insert = "INSERT INTO DailySchedule (DScheduleInfo, ScheduleDate, GeneralManagerId) VALUES ('$info', '$date', '$id')";
    $insert_result = mysqli_query($conn, $sql_insert);

    if ($insert_result) {
        $del = true;
        // **Prevent form resubmission on refresh**
        header("Location: ".$_SERVER['PHP_SELF']); 
        exit();
    } else {
        $del = false;
    }
}

// Fetch updated records AFTER inserting
$sql = "SELECT * FROM DailySchedule";
$schedule_result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Schedule</title>
    <link rel="stylesheet" href="Daily schedule.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap">

</head>
<body>

    <div class="container">
        <div class="body-container">
            <div class="nav-bar">
                <img class="logo-img" src="../Leave Request/01.jpg.png" alt="">
                <div class="nav-btns">
                    <a class="profile-btn" href="../../3-GM/gm.php">Back</a>
                </div>
            </div>
        
            <div class="back1">
                <div class="info">
                    <label>DAILY SCHEDULE AT TECHSPACE</label>
                    <h1>DAILY SCHEDULE</h1>
                    <p>"Techspace follows a structured daily schedule to ensure efficiency and quality in apparel production. The day begins with a team briefing to outline tasks and goals. Design and production teams collaborate to develop and refine apparel pieces, while quality control ensures high standards."</p>
                </div>
            </div>
        </div>
    </div>

    <!-------------------------------- DISPLAY EXISTING SCHEDULES ---------------------------------->

    <form method="post" style="display: flex; flex-wrap: wrap; justify-content: space-around;">
        <?php while ($row = mysqli_fetch_assoc($schedule_result)) : ?>

            
            <div class="main-flex1" style="display: flex; flex-direction: column; align-items: center; gap: 35px;  background-color: rgba(217, 217, 217, 0.32); padding: 55px; width: 38%; border-radius: 30px;  margin-top: 100px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
                
                <div class="left2" style="display: flex; align-items: center; gap: 85px;">  
                    <label style="font-size: 25px;">Daily Schedule ID</label>
                    <input type="text" style="width: 400px; height: 55px; font-size: 25px; padding-left: 10px; outline: none; border-radius: 10px; background-color: rgb(226, 223, 223); border: none;" value="<?php echo htmlspecialchars($row['DScheduleID']); ?>" readonly>
                </div>
                
                <div class="left2" style="display: flex; align-items: center; gap: 132px;">
                    <label style="font-size: 25px;">Schedule Info</label>
                    <textarea  style="width: 400px; height: 180px; border:none; outline: none; font-size: 18px; background-color: rgb(226, 223, 223); padding-left: 10px; padding-top: 5px; outline: none; border-radius: 10px;" readonly><?php echo htmlspecialchars($row['DScheduleInfo']); ?></textarea>
                </div>
                
                <div class="left2" style="display: flex; align-items: center; gap: 125px;">
                    <label style="font-size: 25px;">Schedule Date</label>
                    <input type="text" style="width: 400px; height: 55px; font-size: 25px; padding-left: 10px; outline: none; border-radius: 10px; background-color: rgb(226, 223, 223); border: none;" value="<?php echo htmlspecialchars($row['ScheduleDate']); ?>" readonly>
                </div>
            
            </div>
        
            <?php endwhile; ?>
    </form>

    <!-------------------------------- ADD NEW SCHEDULE FORM ---------------------------------->

    <h1 style="font-size:40px; margin-left:70px;margin-top:100px;">Add Daily Schedule</h1>

    <form method="post">
        <div class="main-flex" style="display: flex; flex-direction: column; align-items: center; gap: 35px; justify-content: center;  background-color: rgba(217, 217, 217, 0.32); padding: 55px; width: 44%; border-radius: 30px; margin-left: 460px; margin-top: 100px; box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);">
            <div class="left1" style="display: flex; align-items: center; gap: 132px;">
                <label style="font-size: 30px;">Schedule Info</label>
                <textarea style="width: 400px; height: 180px; border:none; outline: none; font-size: 18px; background-color: rgb(226, 223, 223); padding-left: 10px; padding-top: 5px; outline: none; border-radius: 10px;" name="txtinfo" required></textarea>
            </div>
            <div class="left1" style="display: flex; align-items: center; gap: 125px;">
                <label style="font-size: 30px;">Schedule Date</label>
                <input type="date" style="width: 400px; height: 55px; font-size: 25px; padding-left: 10px; outline: none; border-radius: 10px; background-color: rgb(226, 223, 223); border: none;" name="txtdate" required>
            </div>
            <input type="submit" name="btnadd" value="ADD" style="width: 250px; height: 50px; font-size: 24px; background-color: black; color: white; border-radius: 10px; border: none; cursor: pointer; margin-top: 30px;">
            <div style="text-align: center;">
                <?php 
                    if ($del === true) {
                        echo "<p style='color: green; margin-top: 40px; font-size: 20px; font-weight: bold;'>Daily Schedule Added Successfully</p>";
                    } elseif ($del === false) {
                        echo "<p style='color: red; font-weight: bold; margin-top: 40px; font-size: 20px;'>Daily Schedule Insertion Unsuccessful</p>";
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
