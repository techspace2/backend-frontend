<?php
    include 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="chairmanhome.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    

    
</head>
<body style="background-image: url(who-we-are-banner-pattern.webp);">

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

        <img src="chairman img.png" alt="">


        <div class="chairman-details">

            <h1>Welcome, Chairman !</h1>

            <p>We are truly delighted to have you join our platform. As a valued member,
                you now have access to a wide range of essential management tools and resources, designed to help you effectively oversee and guide the organization's strategic direction, collaborate with your team, and monitor 
                key performance indicators to ensure continued growth and success.
            </p>

            <div class="contact-links">

                <div class="team-email">
                    <img src="email_10270695 1.png" alt="">
                    <p>Team's Email:</p>
                    <a href="">info@teamtechspace.lk</a>
                    </div>
                    
                <div class="tech-support">
                    <img src="call-back_7044779 1.png" alt="">
                    <p>Tech Support:</p>
                    <a href="">techsupport@techspace.lk</a>
                </div>
                    
                
                <div class="direct-email">
                    <img src="email_10270695 1.png" alt="">
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

                <li>Overseeing the organization’s long-term strategy and vision.</li>
                <li>Leading board meetings and facilitating critical decision-making processes.</li>
                <li>Ensuring the company’s financial health and regulatory compliance.</li>
                <li>Collaborating with senior executives to set company goals and priorities.</li>
                <li>Representing the organization at external events and stakeholder meetings.</li>
                <li>Supporting and mentoring the executive team to enhance leadership.</li>
                <li>Managing key relationships with investors, partners, and stakeholders.</li>
        
            </ul>
        
        </div>

        
        <div class="slideshow-container">

            <div class="slideshow">

                <img src="01.png" class="slide">
                <img src="02.png" class="slide">
                <img src="03.png" class="slide">
                <img src="04.png" class="slide">
                <img src="05.png" class="slide">
                <img src="06.png" class="slide">
                <img src="01.png" class="slide">
            
            </div>
        
        </div>
      
    </div>



    <h1 class="tools-title">Management Tools</h1>

    <div class="tools">
        

        <div class="image-container">
            <img src="tool1.png">
            <div class="text-overlay">Financial Reports</div>
            <p class="p-overlay">A formal record of the financial activities and performance of an organization over a specific period.</p>
            <a class="btn-overlay" href="../Reports/Financial reports/pdf.php" target="_blank">View Financial Reports</a>
        </div>

        <div class="image-container">
            <img src="tool1.png">
            <div class="text-overlay">Staff Performance</div>
            <p class="p-overlay">The evaluation and assessment of employees' work and contribution to an organization.</p>
            <a class="btn-overlay" href="../Chairman Fucnctions/Staff Performance/Staffper.php">Analyze Staff Performance</a>
        </div>

        
        <div class="image-container">
            <img src="tool1.png">
            <div class="task-overlay">Tasks</div>
            <p class="p-overlay">Outlines the specific duties, responsibilities, and expectations associated with a particular job or assignment.</p>
            <a class="btn-overlay" href="../Chairman Fucnctions/Assign  Tasks/task.php">Assign Task For Managers</a>
        </div>

        <div class="image-container">
            <img src="tool1.png">
            <div class="text-overlay">Delivery Schedule</div>
            <p class="p-overlay">A detailed plan that outlines the dates, times, and locations when goods, services, or products are expected to be delivered.</p>
            <a class="btn-overlay" href="../Chairman Fucnctions/Delivery/Delivery Schedule.php">View Delivery Schedule</a>
        </div>

        <div class="image-container">
            <img src="tool1.png">
            <div class="feedback-overlay">Client Feedback</div>
            <p class="p-overlay">The process of providing information about a person’s  performance, or behavior . </p>
            <a class="btn-overlay-client" href="../Chairman Fucnctions/Client Feedbacks/clientfeedback.php">View Client Feedback</a>
        </div>

        <div class="image-container">
            <img src="tool1.png">
            <div class="feedback-overlay">Staff Feedback</div>
            <p class="p-overlay">The process of providing information about a person’s  performance, or behavior . </p>
            <a class="btn-overlay-client" href="../Chairman Fucnctions/Staff Feedback/Stafffeedback.php">View Staff Feedback</a>
        </div>

    </div>

    <!------------------------------------------------------------------------------------------------------------------------------------------->

    


    <!------------------------------------------------------------------------------------------------------------------------------------------->







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
            <tr style="background-color: black; text-align: center;">
                <th>Event Name </th>
                <th>Event Description </th>
                <th style="width:420px;">Event Date </th>
            </tr>
            </thead>
            
            <tbody>
                <?php
                $sql = "SELECT * FROM News";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($rows = mysqli_fetch_assoc($result)) {
                        echo '<tr style="text-align: center; background-color: white; border-bottom: none;">
                                <td>' . $rows["NName"] . '</td>
                                <td>' . $rows["NDesc"] . '</td>
                                <td>' . $rows["NDate"] . '</td>
                            </tr>';
                    }
                }
                ?>

            </tbody>
        </table>


    </div>


    <div class="footer" style="margin-top: 80px;">
        
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
            <a href=""><img src="facebook.png"><p class="fb">Facebook</p></a>
            <a href=""><img src="twitter.png"><p class="twit">Twitter</p></a>
            <a href=""><img src="instagram.png"><p class="insta">Instagram</p></a>
            <a href=""><img src="linkedin.png"><p class="linkdin">Linkedin</p></a>
            <a href=""><img src="youtube.png"><p class="yt">Youtube</p></a>
            <a href=""><img src="tik-tok.png"><p class="tiktok">TikTok</p></a>
            
        </div>
        
        <div class="foot3">
        
            <label for="">CONTACT US</label>
            <a href=""><img src="call.png">: <p>+(94)11 4727222</p> </a>
            <a href=""><img src="telephone.png">: <p>+(94)11 2547252</p> </a>
            <a href=""><img src="email.png">: <p>info@techspace.com</p> </a>
        
        </div>
        
        <div class="foot4">
        
            <label for="">VISIT US</label>
            <p>No, 25, Rheinland Place, Wadduwa <br>Kaluthara, Sri Lanka.</p>
            <img src="01.jpg.png" alt="">
                
        </div>
    
    </div>

</body>

</html>




