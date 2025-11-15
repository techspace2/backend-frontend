<?php  
include 'connect.php';
session_start();
if (!isset($_SESSION['LoginID']) || empty($_SESSION['LoginID'])) {
    echo "Session LoginID not set!";
    exit();  // Stop execution if LoginID is not set
}


if(isset($_POST['btnprofile']))
{
    $clientloginid = $_SESSION['LoginID'];

    // Check if a profile exists for this ClientLoginID in ClientProfile table
    $sql = "SELECT * FROM ClientProfile WHERE login_id = '$clientloginid'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Profile exists, redirect to Update Profile
        header("Location: http://localhost/TechSpace/ClientProfile/updateprofile.php");
    } else {
        // No profile found, redirect to Setup Profile
        header("Location: http://localhost/TechSpace/ClientProfile/setprofile.php");
    }
    exit();  // Exit after redirection to ensure no further script execution
}

    $del="";

    if(isset($_POST['btnsubmit']))
    {
        $name = $_POST['txtname'];
        $email = $_POST['txtemail'];
        $reveiw = $_POST['txtarea'];
        $id = ($_SESSION['LoginID']);

        $sql = "INSERT INTO ClientReview (CReviewName,CReviewEmail, CReviewDesc ,ClientID , ChairmanId) VALUES ('$name','$email','$reveiw','$id','1')";
        $result = mysqli_query($conn,$sql);

        if($result)
        {
            $del=true;
        }
        else
        {
            $del=false;
        }
    
    
    }

    $deleted ="";

    if(isset($_POST['txtsub']))
    {
        $emailnews=$_POST['txtnews'];
        $id = ($_SESSION['LoginID']);

        $sql2="INSERT INTO ClientNewsLetter (ClientNewsLetterEmail,ClientID) VALUES ('$emailnews','$id')";
        $result2 = mysqli_query($conn,$sql2);

        if($result2)
        {
            $deleted=true;
        }
        else
        {
            $deleted=false;
        }
    }

    if(isset($_POST['add_to_cart'])){

        $id  =  $_SESSION['LoginID'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = 1;
     
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' && login_id='$id'");
     
        if(mysqli_num_rows($select_cart) > 0){
           $message[] = 'product already added to cart';
        }else{
           $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name, price, image, quantity ,login_id) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity','$id')");
           $message[] = 'product added to cart succesfully';
        }
     
     }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="client.css">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


    <script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form");
    const email = document.getElementById("txtemail");
    const name = document.getElementById("txtname");
    const area = document.getElementById("txtarea");

    const form2 = document.getElementById("form2");
    const news = document.getElementById("txtnews");

    form.addEventListener("submit", function (e) {
        if (!validateInputs()) {
            e.preventDefault();
        }
    });

    form2.addEventListener("submit", function (e) {
        if (!validateNews()) {
            e.preventDefault();
        }
    });

    const setError = (element, message) => {
        const inputControl = element.parentElement;
        let errorDisplay = inputControl.querySelector(".error");

        if (!errorDisplay) {
            errorDisplay = document.createElement("div");
            errorDisplay.classList.add("error");
            inputControl.appendChild(errorDisplay);
        }

        errorDisplay.innerText = message;
        errorDisplay.style.color = "red";
        element.style.border = "2px solid red";
    };

    const setSuccess = (element) => {
        const inputControl = element.parentElement;
        let errorDisplay = inputControl.querySelector(".error");

        if (errorDisplay) {
            errorDisplay.innerText = "";
        }

        element.style.border = "2px solid green";
    };

    const isValidEmail = (email) => {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email.toLowerCase());
    };

    const validateEmail = () => {
        const emailValue = email.value.trim();
        if (emailValue === "") {
            setError(email, "Email is required");
            return false;
        } else if (!isValidEmail(emailValue)) {
            setError(email, "Provide a valid email address");
            return false;
        } else {
            setSuccess(email);
            return true;
        }
    };

    const validateNews = () => {
        const newsValue = news.value.trim();
        if (newsValue === "") {
            setError(news, "Email is required");
            return false;
        } else if (!isValidEmail(newsValue)) {
            setError(news, "Provide a valid email address");
            return false;
        } else {
            setSuccess(news);
            return true;
        }
    };

    const validateName = () => {
        const nameValue = name.value.trim();
        if (nameValue === "") {
            setError(name, "Name is required");
            return false;
        } else {
            setSuccess(name);
            return true;
        }
    };

    const validateArea = () => {
        const areaValue = area.value.trim();
        if (areaValue === "") {
            setError(area, "Review is required");
            return false;
        } else {
            setSuccess(area);
            return true;
        }
    };

    const validateInputs = () => {
        let isEmailValid = validateEmail();
        let isNameValid = validateName();
        let isAreaValid = validateArea();

        return isEmailValid && isNameValid && isAreaValid;
    };

    email.addEventListener("input", validateEmail);
    name.addEventListener("input", validateName);
    area.addEventListener("input", validateArea);
    news.addEventListener("input", validateNews);
});

</script>


<script type="text/javascript">

function closeSuccessMessage()
{
    document.querySelectorAll('.success-message').forEach(msg => msg.remove());
}       


</script>

</head>
<body style="background-image: url(who-we-are-banner-pattern.webp);">

<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="success-message">
            <div class="message-box">
                <button class="close-btn" onclick="closeSuccessMessage()">&times;</button>
                <p>' . htmlspecialchars($msg) . '</p>
            </div>
        </div>';
    }
}
?>



    <div class="nav-bar">

        <img class="logo-img" src="01.jpg.png" alt="">

        <p style="margin-left:300px;">Sign up and GET 20% OFF for your first order. Sign Up now</p>
       
        <div class="nav-btns">

       <!--<a href="" class="profile-btn">PROFILE</a>-->

       <form method="post">
        <div class="btns" style="display:flex; align-items:center; margin-left:430px;">
            <input type="submit" name="btnprofile" class="logout-bttn" value="PROFILE">
            <a class="logout-btn"href="../../Home/Thiz/index.html" style="padding-left:29px; padding-top:8px; width:120px;">LOGOUT</a> 
        </div>
        
        </form>
      
        </div>

        <div class="carsec">
        
        <?php
           $id  =  $_SESSION['LoginID'];
       
       $select_rows = mysqli_query($conn, "SELECT * FROM `cart` WHERE login_id='$id'") or die('query failed');
       $row_count = mysqli_num_rows($select_rows);
 
       ?>
 
       <a href="../../shopping cart/cart.php" class="amm"><img src="cart.png" alt=""><span><?php echo $row_count; ?></span> </a>
       
     </div>



    </div>
        
    
    
    <div class="slideshow-container">


        <div class="slideshow" >

            <img src="slide3.png" class="slide">
            <img src="slide4.png" class="slide">
            <img src="slide2.png" class="slide">
            <img src="slide7.png" class="slide">
            <img src="slide5.png" class="slide">
            <img src="slide8.png" class="slide">
            <img src="slide3.png" class="slide">
        
        </div>

        <div class="slideshow-content">
            <a href="../Orders UI/page 1.php" class="shop-btn">Shop Now</a>
        </div>
    
    </div>

    <div class="brand-logo">

        <h1>Brands</h1>

        <div class="brands">
            <img src="br1.png" alt="">
            <img src="br2.png" alt="">
            <img src="br3.png" alt="">
            <img src="br4.png" alt="">
            <img src="br5.png" alt="">
            <img src="br6.png" alt="">
        </div>

    </div>

    <div class="cont">

        <h1>We provide best <br> customer experiences</h1>

        <div class="right-side">
            <img src="_.png" alt="">
            <p>we ensure our customer have the best shopping experience</p>
        </div>

    </div>

    <div class="badges">

        <img src="Group 1.png" alt="">
        <img src="Group 2.png" alt="">
        <img src="Group 3.png" alt="">
        <img src="Group 4.png" alt="">

    </div>

    <div class="shop-stock">

        <div class="card1">
            <img src="card3.png" alt="">
            <a href="../Best Seller/bestseller.php">Best Seller</a>
        </div>
    
        <div class="card1">
            <img src="menfashion.png" alt="">
            <a href="../Men Fashion/menfashion.php">Men Fashion</a>
        </div>
    
        <div class="card1">
            <img src="card1.png" alt="">
            <a href="../Women Fashion/womenfashion.php">Women Fashion</a>
        </div>

    </div>


    <div class="cart-info">

        <h1>Featured Products</h1><br>

        <div class="container">

<section class="products">



<div class="box-container">

  <?php
  
  $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id IN (6,7,8,9  )");
  if(mysqli_num_rows($select_products) > 0){
     while($fetch_product = mysqli_fetch_assoc($select_products)){
  ?>

  <form action="" method="post">
     <div class="box">

         <img src="../../shopping cart/uploaded_img/<?php echo $fetch_product['image']; ?>" alt="Product Image">

        <h3><?php echo $fetch_product['name']; ?></h3>
        <h2> <?php echo $fetch_product['description']; ?></h2><br>
        <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>


        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
        <input type="submit" class="btn" value="add to cart" name="add_to_cart">
     </div>
  </form>


  <?php
     };
  };
  ?>

</div>

</section>





    </div>

    <form method="post" id="form2">

    <div class="subscribe">

        <h1>Subscribe our Newsletter to get updates <br> to our latest collections</h1>

            <div class="register" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">

                <div class="sub-data" style=" display:flex ; flex-direction: column; justify-content: center; align-items:center;">
                <input type="text" placeholder="Enter your email" name="txtnews" id="txtnews">
                <div style="font-size: 16px;" class="error"></div>
                <button type="submit" name="txtsub" style="background-color: black; color:white; width: 180px; height:48px; font-size: 20px; margin-top:10px;" >Subscribe</button> 
                </div>

            <div class="msg" style="align-items: center;">
                <?php 
                if ($deleted=== true) {
                        echo '<div style="color: green; font-size:18px; margin-top:23px; font-weight: bold;">Email registered .</div>';
                } 
                ?>
            </div>
            </div>

            

        
        


    </div>

    </form>

    <form method="post" id="form" >

    <h1 class="cus-rev">Customer Reviews</h1>

    <div class="nn">
        <table class="content-table">
            <thead>
            <tr style="background-color: black; text-align: center; font-size: 25px">
                <th style="padding: 20px 240px;"> Name </th>
                <th style="padding: 20px 240px;"> Email </th>
                <th style="padding: 20px 240px;"> Reviews </th>
            </tr>
            </thead>
            
            <tbody>
                <?php
                $sql = "SELECT * FROM ClientReview";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($rows = mysqli_fetch_assoc($result)) {
                        echo '<tr style="background-color:rgba(255, 255, 255, 0); border-bottom: none; font-size: 20px;">
                                <td style="text-align: center;">' . $rows["CReviewName"] . '</td>
                                <td style="text-align: center;">' . $rows["CReviewEmail"] . '</td>
                                <td style="text-align: center;">' . $rows["CReviewDesc"] . '</td>
                            </tr>';
                    }
                }
                ?>

            </tbody>
        </table>


    </div>



    <h1 class="submit-rev">Submit Your Review</h1>

    <div class="flex-details">

        <div class="up">

            <div class="left">
                <label for="">Name</label>
                <input type="text" placeholder="Your Name" id="txtname" name="txtname">
                <div class="error"></div>
            </div>
          
            <div class="right">
                <label for="">Email</label>
                <input type="email" placeholder="example@gmail.com" id="txtemail" name="txtemail">
                <div class="error"></div>
            </div>
    
        </div>

        <div class="comment">

            <label for="">Write Your Review</label>
            <textarea name="txtarea" id="txtarea" placeholder="Write your Review"></textarea>
            <div class="error"></div>

            <div class="msg" >
            <?php 
              if ($del=== true) {
                     echo '<div style="color: green; font-size:22px; margin-top:20px;">Review Submitted Successfully</div>';
              } elseif ($del ===false) {
                     echo '<div style="color: red; font-weight: bold;">Error: Review is not Submitted</div>';
             }

             ?>
             </div>

            <!-- mek design ek css krhn mn a ek button ekk kra-->
            <input type="submit" name="btnsubmit" value="Submit Review">
        </div>

    </div>


    <div class="find">

        <h1>Find Out</h1>
        
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d426434.85603920877!2d79.80467619898397!3d6.785665883198465!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae237dd59bd3b33%3A0x820142f6a9f05ae0!2sTechSpase%20(Pvt)%20Ltd!5e0!3m2!1sen!2slk!4v1739638438304!5m2!1sen!2slk" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    
    </div>
    </form>

    <div class="footer" style="font-size: 16px;">
        
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