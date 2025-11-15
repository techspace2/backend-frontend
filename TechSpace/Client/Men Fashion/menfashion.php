<?php 
    include 'connect.php';
    session_start();
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
           $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name, price, image, quantity, login_id) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity','$id')");
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
    <link rel="stylesheet" href="menfashion.css">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <script type="text/javascript">
   document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form2");
    const emailInput = document.getElementById("txtnews");
    const errorDiv = emailInput.nextElementSibling; // The div for showing errors

    // Function to display an error message
    const setError = (message) => {
        errorDiv.innerText = message;
        errorDiv.style.color = "red";
        emailInput.style.border = "2px solid red";
    };

    // Function to display success state
    const setSuccess = () => {
        errorDiv.innerText = "";
        emailInput.style.border = "2px solid green";
    };

    // Function to validate email format
    const isValidEmail = (email) => {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email.toLowerCase());
    };

    // Main validation function
    const validateEmail = () => {
        const emailValue = emailInput.value.trim();

        if (emailValue === "") {
            setError("Email is required.");
            return false;
        } else if (!isValidEmail(emailValue)) {
            setError("Provide a valid email address.");
            return false;
        } else {
            setSuccess();
            return true;
        }
    };

    // Attach event listener for real-time validation
    emailInput.addEventListener("input", validateEmail);

    // Form submission validation
    form.addEventListener("submit", function (e) {
        if (!validateEmail()) {
            e.preventDefault(); // Prevent form submission if validation fails
        }
    });
});


        </script>

        <script type="text/javascript">

        function closeSuccessMessage()
        {
            document.querySelectorAll('.success-message').forEach(msg => msg.remove());
        }       


        </script>

</head>
<body>

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

        <p>Sign up and GET 20% OFF for your first order. Sign Up now</p>
       
        <div class="nav-btns">

            <a class="profile-btn" href="../ClientHome/client.php" style="width:150px; height:45px;">Back</a>
               
        </div>
       
    </div>


    <div class="search-bar">

        <p>GET 20% OFF FOR YOUR ORDER</p>

        <div class="search-cont">  
        </div>

        <div class="carsec">
        
        <?php
           $id  =  $_SESSION['LoginID'];
       
       $select_rows = mysqli_query($conn, "SELECT * FROM `cart` WHERE login_id='$id'") or die('query failed');
       $row_count = mysqli_num_rows($select_rows);
 
       ?>
 
       <a href="../../shopping cart/cart.php" class="cart"><img src="../Best Seller/cart.png" alt=""><span><?php echo $row_count; ?></span> </a>
       
         </div>
      
    </div>


    <div class="slideshow-container">

        <div class="slideshow">

            <img src="../ClientHome/slide4.png" class="slide">
            <img src="../ClientHome/slide3.png" class="slide">
            <img src="../ClientHome/slide2.png" class="slide">
            <img src="../ClientHome/slide7.png" class="slide">
            <img src="../ClientHome/slide5.png" class="slide">
            <img src="../ClientHome/slide8.png" class="slide">
            <img src="../ClientHome/slide4.png" class="slide">
        
        </div>

        <div class="slideshow-content">
            <label for="" class="shop-btn">Men Fashion</label>
        </div>
    
    </div>
    
    <div class="container">

    <section class="products">

 

   <div class="box-container">

      <?php
      
      $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE type='Males Fashion'");
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



    <div class="down" style="margin-left: 0px; padding:130px; width:100%;">

        <div class="ppp" >

            <div class="para">

                <p class="p1">NEWSLETTER SIGN UP</p>
    
                <p>Sign up for exclusive updates, new arrivals & <br> insider only discounts</p>
    
            </div>

            <form method="post" id="form2">
                
            <div class="newsletter">    

            <div class="flex-error" style="display-flex; flex-direction: column;">
                <input type="email" id="txtnews" name="txtnews" placeholder="Enter your email address">
                <div class="error" style="font-size:24px; margin-top:20px;"></div>
            </div>
                <input type="submit" name="txtsub" value="SUBMIT" style="background-color: rgb(255, 255, 255); color:rgb(0, 0, 0); text-align:center; width:180px; margin-left:30px; cursor: pointer;">
            </div>
            </form>

            <div class="msg" style="align-items: center;">
            <?php 
              if ($deleted=== true) {
                     echo '<div style="color: green; font-size:24px; margin-top:20px;">Email registered .</div>';
              } 
             ?>
             </div>


        </div>

        <div class="payments" style="display:flex; flex-direction: column; margin-left: 250px">
            <img src="../Best Seller/visa.png" alt="">
            <img src="../Best Seller/master card.png" alt="">
            <img src="../Best Seller/paypal.png" alt="">
        </div>

    </div>
    


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
              
<!-- custom js file link  -->
<script src="script.js"></script>

</body>    