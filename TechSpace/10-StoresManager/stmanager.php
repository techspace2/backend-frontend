<?php
    include 'connect.php';
    session_start();
    $del="";

    if(isset($_POST['btnsubmit']))
    
    {
         $id = $_SESSION['LoginID'];
        $name = $_POST['txtname'];
        $email = $_POST['txtemail'];
        $reveiw = $_POST['txtarea'];
        $type = $_SESSION['LType'];
       

        $sql = "INSERT INTO StaffFeedback (SName,SRole,SEmail, SReview ,login_id , ChairmanId ) VALUES ('$name','$type','$email','$reveiw','$id' ,'1')";
        $result = mysqli_query($conn,$sql);

        if($result)
        {
            $del=true;
        }
        else
        {
            $el=false;
        }
    
    
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stmanager.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


    <script type="text/javascript">

document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".feedback-form"); // Select the actual form
    const email = document.getElementById("txtemail");
    const name = document.getElementById("txtname");
    const area = document.getElementById("txtarea");
    const submitBtn = document.querySelector(".btnsubmit");

    // Prevent form submission on button click if validation fails
    form.addEventListener("submit", function (e) {
        if (!validateInputs()) {
            e.preventDefault(); // Prevent form submission if validation fails
        }
    });

    // Set error message
    function setError(element, message) {
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
    }

    // Set success message
    function setSuccess(element) {
        const inputControl = element.parentElement;
        let errorDisplay = inputControl.querySelector(".error");

        if (errorDisplay) {
            errorDisplay.innerText = "";
        }

        element.style.border = "2px solid green";
    }

    // Validate email format
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email.toLowerCase());
    }

    // Validate email field
    function validateEmail() {
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
    }

    // Validate name field
    function validateName() {
        const nameValue = name.value.trim();
        if (nameValue === "") {
            setError(name, "Name is required");
            return false;
        } else {
            setSuccess(name);
            return true;
        }
    }

    // Validate review text area
    function validateArea() {
        const areaValue = area.value.trim();
        if (areaValue === "") {
            setError(area, "Review is required");
            return false;
        } else {
            setSuccess(area);
            return true;
        }
    }

    // Validate all inputs
    function validateInputs() {
        let isEmailValid = validateEmail();
        let isNameValid = validateName();
        let isAreaValid = validateArea();

        return isEmailValid && isNameValid && isAreaValid;
    }

    // Attach validation to input events
    email.addEventListener("input", validateEmail);
    name.addEventListener("input", validateName);
    area.addEventListener("input", validateArea);
});




</script>
</head>
<body>

    <div class="nav-bar">

        <img class="logo-img" src="01.jpg.png" alt="">

        <ul class="nav-options">
           
 	    <li><a href="../Home/Thiz/index.html">Home</a></li>
            <li><a href="../Non Functional/Non Functional 1/About.html">Who We Are</a></li>
            <li><a href="../Non Functional/Non Functional 1/Capability.html">Our Capabilities</a></li>
            <li><a href="../Non Functional/Sustainability/Sutain.html">Sustainability</a></li>
            <li><a href="../Non Functional/Careers/Careers.html">Careers</a></li>
            <li><a href="../Non Functional/Contact Us/contact.html">Contact Us</a></li>
        </ul>

        <div class="nav-btns">

            <a class="profile-btn" href="../Profile/profile.php">PROFILE</a>
            <a class="logout-btn" href="../Home/Thiz/index.html">LOGOUT</a> 
               
        </div>
       
    </div>


    <div class="flex-details">

        <img src="sm 1.png" alt="">


        <div class="chairman-details">

            <h1>Welcome, Stores Manager !</h1>

            <p>We are excited to welcome you to our platform! As a valued Stores Manager, 
                you now have access to a comprehensive set of tools and resources to help you 
                efficiently manage inventory, ensure smooth store operations, collaborate with your team, 
                and track key performance metrics to drive operational success and growth.        </p>

            <div class="contact-links">

                <div class="team-email">
                    <img src="../1-Chairman/email_10270695 1.png" alt="">
                    <p>Team's Email:</p>
                    <a href="">info@teamtechspace.lk</a>
                    </div>
                    
                <div class="tech-support">
                    <img src="../1-Chairman/call-back_7044779 1.png" alt="">
                    <p>Tech Support:</p>
                    <a href="">techsupport@techspace.lk</a>
                </div>
                    
                
                <div class="direct-email">
                    <img src="../1-Chairman/email_10270695 1.png" alt="">
                    <p>Directors Email:</p>
                    <a href="">director@techspace.lk</a>
                </div>
                
            </div>
    
        </div>

    </div>

            
    <div class="roles-response-slideshow">

        <div class="left-side">

            <h1>Roles & Responsibilities</h1>

            <ul class="roles-list">

                <li>Overseeing the store’s operations strategically and ensuring the effective execution of long-term inventory and workforce development plans.</li>
                <li>Leading important store meetings and assisting in key decision-making processes.</li>
                <li>Managing store activities, ensuring compliance with regulations, and addressing risks related to inventory and staffing.</li>
                <li>Working closely with senior leadership to set store goals and ensure alignment with overall company priorities.</li>
                <li>Representing the store in external partnerships, industry events, and product procurement efforts.</li>
  
        
            </ul>
        
        </div>

        
        <div class="slideshow-container">

            <div class="slideshow">

                <img src="../1-Chairman/01.png" class="slide">
                <img src="../1-Chairman/02.png" class="slide">
                <img src="../1-Chairman/03.png" class="slide">
                <img src="../1-Chairman/04.png" class="slide">
                <img src="../1-Chairman/05.png" class="slide">
                <img src="../1-Chairman/06.png" class="slide">
                <img src="../1-Chairman/01.png" class="slide">
            
            </div>
        
        </div>
      
    </div>



    <h1 class="tools-title">Management Tools</h1>

    <div class="tools">
        

        <div class="image-container">
            <img src="../1-Chairman/tool1.png">
            <div class="text-overlay">Material Requirements</div>
            <p class="p-overlay">The specific quantities and types of materials needed for production or operations within an organization.</p>
            <a class="btn-overlay" href="../Stores Functions/Material Requirment/matrequirment.php">Finalizing Material <br> Requirements</a>
        </div>

        <div class="image-container">
            <img src="../1-Chairman/tool1.png">
            <div class="task-overlay">Material Inventory</div>
            <p class="p-overlay">Refers to the stock of raw materials, components, or supplies that a business holds for use in its production processes or operations.</p>
            <a class="btn-overlay" href="../Stores Functions/Material Inventory/materialinven.php">Manage Material Inventory</a>
        </div>

        
        <div class="image-container">
            <img src="../1-Chairman/tool1.png">
            <div class="text-overlay-issue">Material Inventory Reports</div>
            <p class="p-overlay">Documents that provide detailed information about the stock levels, usage, and movement of materials within a company.</p>
            <a class="btn-overlay" href="../Reports/Material Inventory/pdf.php" target="_blank">Add Material <br> Inventory Reports</a>
        </div>

        <div class="image-container">
            <img src="../1-Chairman/tool1.png">
            <div class="feedback-overlay">Material Distribution</div>
            <p class="p-overlay">Refers to the process of moving materials or products from suppliers.</p>
            <a class="btn-overlay-client" style="top: 70%;" href="../Stores Functions/Material Distribution/materialdistribution.php">Manage Material Distribution</a>
        </div>


    </div>



    <h1 class="submit-rev">Submit Your Review</h1>
    <style>
        .submit-rev{
            font-family: "inter", serif;
        }
    </style>

<div class="flex-details1">
<form method="post" class="feedback-form">
    <style>
        .flex-details1{
            font-family: "inter", serif;
        }
    </style>
    <div class="up1">

        <div class="left1">
            <label for="">Name</label>
            <input type="text" placeholder="Your Name" id="txtname" name="txtname">
            <div class="error"></div>
        </div>
      
        <div class="right1">
            <label for="">Email</label>
            <input type="email" style="padding-left: 10px;" placeholder="example@gmail.com" id="txtemail" name="txtemail">
            <div class="error"></div>
        </div>

    </div>

    <div class="comment1"  style="margin-left:40px; width:99.3%;">
        <label for="">Write Your Review</label>
        <textarea name="txtarea" id="txtarea" style="padding-left: 10px; padding-top:5px;" placeholder=""></textarea>
        <div class="error"></div>

        <div class="msg" style="align-items: end;">
        <?php 
          if ($del=== true) {
                 echo '<div style="color: green; font-weight: bold;">Review Submitted Successfully</div>';
          } elseif ($del ===false) {
                 echo '<div style="color: red; font-weight: bold;">Error: Review is not Submitted</div>';
         }

         ?>
         </div>

    

        <input type="submit" name="btnsubmit"  value="Submit Review" class="btnsubmit" style="margin-top:40px; margin-left:0px;">
    </div>
    </form>
    

</div>



    <h1 class="calender">Calender</h1>

    <div class="hero">

        <div id="calendar"></div>

    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
    
    <script src="evo-calendar.min.js">     
    </script>

    <script>
        $(document).ready(function() {
            $('#calendar').evoCalendar({

                theme: "Midnight Blue",
                calendarEvents: [
      {
        id: 'event1', // Event's ID (required)
        name: "New Year", // Event name (required)
        date: "January/1/2020", // Event date (required)
        description: "oqq",
        type: "holiday", // Event type (required)
        everyYear: true // Same event every year (optional)
      },
      {
        name: "Vacation Leave",
        badge: "02/13 - 02/15", // Event badge (optional)
        date: ["February/13/2020", "February/15/2020"], // Date range
        description: "Vacation leave for 3 days.", // Event description (optional)
        type: "event",
        color: "#63d867" // Event custom color (optional)
      }
    ]
            

         })
    })


    </script>


    <h1 class="news">Latest News / Updates</h1>

    <div class="nn">
        <table class="content-table">
            <thead>
            <tr style="background-color: black; font-size:27px; text-align: center;">
                <th style="padding: 20px 160px;">Event Name </th>
                <th style="padding: 20px 160px;">Event Description </th>
                <th style="padding: 20px 160px;">Event Date </th>
            </tr>
            </thead>
            
            <tbody>
                <?php
                $sql = "SELECT * FROM News";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($rows = mysqli_fetch_assoc($result)) {
                        echo '<tr style="border-bottom: none; text-align: center; font-size:23px; background-color:rgba(255, 255, 255, 0);">
                                <td style="background-color:rgba(255, 255, 255, 0);">' . $rows["NName"] . '</td>
                                <td style="background-color:rgba(255, 255, 255, 0);">' . $rows["NDesc"] . '</td>
                                <td style="background-color:rgba(255, 255, 255, 0);">' . $rows["NDate"] . '</td>
                            </tr>';
                    }
                }
                ?>

            </tbody>
        </table>


    </div>


    <div class="footer" style="margin-top: 100px;">
        
        <div class="foot1">
    
            <label for="">SITE NAVIGATION</label>
           
 	    <li><a href="../Home/Thiz/index.html">Home</a></li>
            <li><a href="../Non Functional/Non Functional 1/About.html">Who We Are</a></li>
            <li><a href="../Non Functional/Non Functional 1/Capability.html">Our Capabilities</a></li>
            <li><a href="../Non Functional/Sustainability/Sutain.html">Sustainability</a></li>
            <li><a href="../Non Functional/Careers/Careers.html">Careers</a></li>
            <li><a href="../Non Functional/Contact Us/contact.html">Contact Us</a></li>
            <p>© Techspace (Pvt) Ltd. All rights reserved.</p>
            
        </div>
        
        <div class="foot2">
        
            <label for="">FIND US ON</label>
            <a href=""><img src="../1-Chairman/facebook.png"><p class="fb">Facebook</p></a>
            <a href=""><img src="../1-Chairman/twitter.png"><p class="twit">Twitter</p></a>
            <a href=""><img src="../1-Chairman/instagram.png"><p class="insta">Instagram</p></a>
            <a href=""><img src="../1-Chairman/linkedin.png"><p class="linkdin">Linkedin</p></a>
            <a href=""><img src="../1-Chairman/youtube.png"><p class="yt">Youtube</p></a>
            <a href=""><img src="../1-Chairman/tik-tok.png"><p class="tiktok">TikTok</p></a>
            
        </div>
        
        <div class="foot3">
        
            <label for="">CONTACT US</label>
            <a href=""><img src="../1-Chairman/call.png">: <p>+(94)11 4727222</p> </a>
            <a href=""><img src="../1-Chairman/telephone.png">: <p>+(94)11 2547252</p> </a>
            <a href=""><img src="../1-Chairman/email.png">: <p>info@techspace.com</p> </a>
        
        </div>
        
        <div class="foot4">
        
            <label for="">VISIT US</label>
            <p>No, 25, Rheinland Place, Wadduwa <br>Kaluthara, Sri Lanka.</p>
            <img src="01.jpg.png" alt="">
                
        </div>
    
    </div>

</body>

</html>









