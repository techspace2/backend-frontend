
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Stafffeedback.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>


    <div class="container">

        <div class="body-container">

            <div class="nav-bar">
    
                <img class="logo-img" src="../Assign  Tasks/01.jpg.png" alt="">
               
                <div class="nav-btns">
        
                    <a class="profile-btn" href="../../1-Chairman/chairmanhome.php">Back</a>
                       
                </div>
               
            </div>
        
            <div class="back1">
    
                <div class="info">
                    <label for="">STAFF FEEDBACK AT TECHSPACE</label>
                    <h1>Staff Feedback</h1>
                    <p>"We at Techspace truly appreciate our Staff' valuable feedback! Your insights help us continuously improve our apparel, ensuring top-notch quality, comfort, and style. We take pride in delivering exceptional products that meet your expectations"</p>
                </div>
                
            </div>
    
        </div>

    </div>

   

    <!-- Methana indan pahalata karapan oni tika -->

    <div class="nn">
        <table class="content-table">
            <thead>
            <tr>
                <th> Name </th>
                <th> Role </th>
                <th> Email </th>
                <th> Reviews </th>
            </tr>
            </thead>
            
            <tbody>
                <?php

                include 'connect.php';
                $sql = "SELECT * FROM StaffFeedback";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($rows = mysqli_fetch_assoc($result)) {
                        echo '<tr style="border-bottom: none; background-color:rgba(255, 255, 255, 0);">
                                <td style="background-color:rgba(255, 255, 255, 0);">' . $rows["SName"] . '</td>
                                <td style="background-color:rgba(255, 255, 255, 0);">' . $rows["SRole"] . '</td>
                                <td style="background-color:rgba(255, 255, 255, 0);">' . $rows["SEmail"] . '</td>
                                <td style="background-color:rgba(255, 255, 255, 0);">' . $rows["SReview"] . '</td>
                                
                            </tr>';
                    }
                }
                ?>

            </tbody>
        </table>


    </div>


                  <!------------------------------------------------------------------------------------------------------------->

    <div class="footer" style="font-size: 16px;">

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
margin-top: 100px;
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
    <a href=""><img src="../../1-Chairman/facebook.png"><p class="fb">Facebook</p></a>
    <a href=""><img src="../../1-Chairman/twitter.png"><p class="twit">Twitter</p></a>
    <a href=""><img src="../../1-Chairman/instagram.png"><p class="insta">Instagram</p></a>
    <a href=""><img src="../../1-Chairman/linkedin.png"><p class="linkdin">Linkedin</p></a>
    <a href=""><img src="../../1-Chairman/youtube.png"><p class="yt">Youtube</p></a>
    <a href=""><img src="../../1-Chairman/tik-tok.png"><p class="tiktok">TikTok</p></a>
    
</div>

<div class="foot3">

    <label for="">CONTACT US</label>
    <a href=""><img src="../../1-Chairman/call.png">: <p>+(94)11 4727222</p> </a>
    <a href=""><img src="../../1-Chairman/telephone.png">: <p>+(94)11 2547252</p> </a>
    <a href=""><img src="../../1-Chairman/email.png">: <p>info@techspace.com</p> </a>

</div>

<div class="foot4">

    <label for="">VISIT US</label>
    <p>No, 25, Rheinland Place, Wadduwa <br>Kaluthara, Sri Lanka.</p>
    <img src="01.jpg.png" alt="">
        
</div>

</div>





</body>







































