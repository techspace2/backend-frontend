<?php 

include 'connect.php';
session_start();

$del = "";

// Execute the query to fetch resource orders
$sql = "SELECT * FROM ResourceOrder";
$result = mysqli_query($conn, $sql);

if ($result === false) {
    // Handle query error
    echo "Error: " . mysqli_error($conn);
    exit; // Stop further execution if the query fails
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'approve_') === 0) {
            $ROrderID = str_replace('approve_', '', $key);

            if (isset($_POST['status'][$ROrderID])) { // Ensure the status exists
                $status = mysqli_real_escape_string($conn, $_POST['status'][$ROrderID]);

                $sql = "UPDATE ResourceOrder SET status = ? WHERE ROrderID = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, 'si', $status, $ROrderID);
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                    $_SESSION['message'] = "Resource Order $ROrderID updated successfully!";
                } else {
                    $_SESSION['message'] = "Error updating Resource Order $ROrderID: " . mysqli_error($conn);
                }
            }
        }
    }
    header("Location: Resource.php");
    exit();
}


// Fetch the resource order details
$sql = "SELECT * FROM ResourceOrder";
$result = mysqli_query($conn, $sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Resource.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="body-container">

            <div class="nav-bar">
    
                <img class="logo-img" src="../Department Operation/01.jpg.png" alt="">
               
                <div class="nav-btns">
        
                    <a class="profile-btn" href="../../2-Director/directorhome.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1">
    
                <div class="info">
                    <label for="">RESOURCE ORDERS AT TECHSPACE</label>
                    <h1>RESOURCE ORDERS</h1>
                    <p>"Techspace processes resource orders efficiently to ensure a seamless supply chain for apparel production. We manage inventory, raw materials, and finished goods with precision, ensuring timely procurement and distribution."</p>
                </div>
                
            </div>
    
        </div>

    </div>

    <!-------------------------------------------------------------------------------------------------------------->

    <form method="post" style="display: flex; justify-content: space-around; gap: 30px; flex-wrap: wrap;">
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>

    <div class="main-flex" style="display: flex; flex-direction: column; flex-wrap: wrap; gap: 30px; background-color: rgb(235, 235, 235); border-radius: 30px; padding: 70px; width: 650px; margin-top: 120px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);">

        <div class="left1" style="display: flex; align-items: center; gap: 129px;">
            <label style="font-size: 25px;">Order ID</label>
            <input type="text" name="txtid" style="width: 350px; color:rgb(53, 53, 53); height: 55px; border-radius: 10px; border: none; background-color: rgb(218, 216, 216); padding-left: 10px; font-size: 22px; outline: none;" value="<?php echo htmlspecialchars($row['ROrderID']); ?>" readonly>
        </div>
    
        <div class="left1" style="display: flex; align-items: center; gap: 87px;">
            <label style="font-size: 25px;">Order Name</label>
            <input type="text" style="width: 350px; color:rgb(53, 53, 53); height: 55px; border-radius: 10px; border: none; background-color: rgb(218, 216, 216); padding-left: 10px; font-size: 22px; outline: none;" value="<?php echo htmlspecialchars($row['ROrderName']); ?>" readonly>
        </div>

        <div class="left1" style="display: flex; align-items: center; gap: 77px;">
            <label style="font-size: 25px;">Order Details</label>
            <textarea name="orderDetails" id="orderDetails"  style="width: 350px; color:rgb(53, 53, 53); height: 155px; padding-top:10px; border-radius: 10px; border: none; background-color: rgb(218, 216, 216); padding-left: 10px; font-size: 22px; outline: none;" cols="16" rows="6" readonly><?php echo htmlspecialchars($row['ROrderDetails']); ?></textarea>
        </div>
    
        <div class="left1" style="display: flex; align-items: center; gap: 54px;">
            <label  style="font-size: 25px;">Order Payment</label>
            <select name="ROrderPayment" disabled style="width: 360px; color:rgb(53, 53, 53); height: 50px; font-size: 20px; padding-left: 10px; outline: none; border-radius: 5px; background-color: rgb(218, 216, 216); border: none;">
                <option value="Select Payment Type" <?php echo ($row['ROrderPayment'] == 'Select Payment Type') ? 'selected' : ''; ?>>Select Payment Type</option>
                <option value="Cash on Delivery" <?php echo ($row['ROrderPayment'] == 'Cash on Delivery') ? 'selected' : ''; ?>>Cash on Delivery</option>
                <option value="Credit / Debit Card" <?php echo ($row['ROrderPayment'] == 'Credit / Debit Card') ? 'selected' : ''; ?>>Credit / Debit Card</option>
            </select>

        </div>   
        
        <div class="left1" style="display: flex; align-items: center; gap: 152px;">
            <label  style="font-size: 25px;">Status</label>
            <select name="status[<?php echo $row['ROrderID']; ?>]" style="width: 360px; color:rgb(53, 53, 53); height: 50px; font-size: 20px; padding-left: 10px; outline: none; border-radius: 5px; background-color: rgb(218, 216, 216); border: none;">
                <option style="background-color: rgba(0, 0, 0, 0.795); color: white;" value="Approved" <?php echo ($row['status'] == 'Approved') ? 'selected' : ''; ?>>Approved</option>
                <option style="background-color: rgba(0, 0, 0, 0.795); color: white;" value="Not Approved" <?php echo ($row['status'] == 'Not Approved') ? 'selected' : ''; ?>>Not Approved</option>
            </select>

        </div> 
    
        <!-- The Approve button for this record -->
        <input type="submit" name="approve_<?php echo $row['ROrderID']; ?>" value="APPROVE" style="background-color: black; border-radius: 10px; border: none; margin-top: 40px; width: 300px; height: 50px; color: white; font-size: 20px;margin-left:160px;">
    </div>

<?php endwhile; ?>
</form>

    <!-------------------------------------------------------------------------------------------------------------->


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

