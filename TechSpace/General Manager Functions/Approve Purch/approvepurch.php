<?php 
include 'connect.php';
session_start();

// Execute the query to fetch resource orders
$sql = "SELECT * FROM purchaseorder";
$result = mysqli_query($conn, $sql);

if ($result === false) {
    echo "Error: " . mysqli_error($conn);
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'approve_') === 0) {
            $planID = str_replace('approve_', '', $key);

            // Check if status is set before using it
            if (isset($_POST['status'][$planID])) {
                $status = $_POST['status'][$planID];

                // Update the database using prepared statements
                $sql = "UPDATE purchaseorder SET POrderStatus = ? WHERE POrderID = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, 'si', $status, $planID);
                
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['message'] = "Purchase Order updated successfully!";
                } else {
                    $_SESSION['message'] = "Error updating Purchase Order";
                }

                mysqli_stmt_close($stmt);
            }
        }
    }

    // Redirect to prevent form resubmission
    header("Location: approvepurch.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Purchases</title>
    <link rel="stylesheet" href="approve purch.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<body>

    <div class="container">
        <div class="body-container">
            <div class="nav-bar">
                <img class="logo-img" src="../Leave Request/01.jpg.png" alt="Techspace Logo">
                <div class="nav-btns">
                    <a class="profile-btn" href="../../3-GM/gm.php">Back</a>
                </div>
            </div>

            <div class="back1">
                <div class="info">
                    <label for="">TECHSPACE</label>
                    <h1>APPROVE PURCHASES</h1>
                    <p>"All apparel purchase requests at Techspace must be reviewed and approved to ensure budget compliance and quality standards. Approvals are required before placing orders to maintain efficiency and cost control. This process helps in selecting high-quality apparel that aligns with our brand identity."</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Approval Form -->
    <form method="post" style="display: flex; justify-content: space-around; flex-wrap: wrap;">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="main-flex" style="display: flex; flex-direction: column; flex-wrap: wrap; align-items:center; gap: 30px; background-color: rgb(245, 243, 243); border-radius: 30px; padding: 70px; width: 750px; margin-top: 120px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);">

                <div class="left1" style="display: flex; align-items: center; gap: 70px;">
                    <label style="font-size: 25px;">Purchase Order ID</label>
                    <input type="text" style="width: 380px; height: 55px; border-radius: 10px; border: none; background-color: rgb(233, 230, 230); padding-left: 10px; font-size: 20px; outline: none;" value="<?= htmlspecialchars($row['POrderID']); ?>" readonly>
                </div>

                <div class="left1" style="display: flex; align-items: center; gap: 210px;">
                    <label style="font-size: 25px;">Name</label>
                    <input type="text" style="width: 380px; height: 55px; border-radius: 10px; border: none; background-color: rgb(233, 230, 230); padding-left: 10px; font-size: 20px; outline: none;" value="<?= htmlspecialchars($row['POrderName']); ?>" readonly>
                </div>

                <div class="left1" style="display: flex; align-items: center; gap: 180px;">
                    <label style="font-size: 25px;">Quantity</label>
                    <input type="number" style="width: 380px; height: 55px; border-radius: 10px; border: none; background-color: rgb(233, 230, 230); padding-left: 10px; font-size: 20px; outline: none;" value="<?= htmlspecialchars($row['POrderQuantity']); ?>" readonly>
                </div>

                <div class="left1" style="display: flex; align-items: center; gap: 216px;">
                    <label style="font-size: 25px;">Price</label>
                    <input type="number" style="width: 380px; height: 55px; border-radius: 10px; border: none; background-color: rgb(233, 230, 230); padding-left: 10px; font-size: 20px; outline: none;" value="<?= htmlspecialchars($row['POrderPrice']); ?>" readonly>
                </div>

                <div class="left1" style="display: flex; align-items: center; gap: 147px;">
                    <label style="font-size: 25px;">Supplier ID</label>
                    <input type="number" style="width: 380px; height: 55px; border-radius: 10px; border: none; background-color: rgb(233, 230, 230); padding-left: 10px; font-size: 20px; outline: none;" value="<?= htmlspecialchars($row['SupplierId']); ?>" readonly>
                </div>

                <div class="left1" style="display: flex; align-items: center; gap: 195px;">
                    <label style="font-size: 25px;">Status</label>
                    <select name="status[<?= $row['POrderID']; ?>]" style="width: 390px; height: 50px; font-size: 20px; padding-left: 10px; outline: none; border-radius: 5px; background-color: rgb(233, 230, 230); border: none;">
                        <option value="Approved" <?= ($row['POrderStatus'] == 'Approved') ? 'selected' : ''; ?>>Approved</option>
                        <option value="Not Approved" <?= ($row['POrderStatus'] == 'Not Approved') ? 'selected' : ''; ?>>Not Approved</option>
                    </select>
                </div>

                <input type="submit" name="approve_<?= $row['POrderID']; ?>" value="APPROVE" style="background-color: black; border-radius: 40px; cursor:pointer; border: none; margin-top: 40px; width: 300px; height: 50px; color: white; font-size: 20px;">
            </div>
        <?php endwhile; ?>
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
