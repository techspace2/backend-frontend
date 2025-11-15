<?php 
    include 'connect.php';

    $query = "SELECT * FROM stafperformance WHERE SPerformanceDep='Financial'";
    $result = mysqli_query($conn, $query);
    $chart_data = '';

    while($row = mysqli_fetch_array($result)) {
        $chart_data .= "{ department:'".$row["SPerformanceDep"]."', rating:".$row["SRating"].", year:".$row["SYear"]." }, ";
    }

    // Remove the last comma to prevent JSON errors
    $chart_data = rtrim($chart_data, ", ");



    $query2 = "SELECT * FROM stafperformance WHERE SPerformanceDep='HR'";
    $result2 = mysqli_query($conn, $query2);
    $chart_data2 = '';

    while($row2 = mysqli_fetch_array($result2)) {
        $chart_data2 .= "{ department:'".$row2["SPerformanceDep"]."', rating:".$row2["SRating"].", year:".$row2["SYear"]." }, ";
    }

    // Remove the last comma to prevent JSON errors
    $chart_data2 = rtrim($chart_data2, ", ");


    $query3 = "SELECT * FROM stafperformance WHERE SPerformanceDep='Business Development'";
    $result3 = mysqli_query($conn, $query3);
    $chart_data3 = '';

    while($row3 = mysqli_fetch_array($result3)) {
        $chart_data3 .= "{ department:'".$row3["SPerformanceDep"]."', rating:".$row3["SRating"].", year:".$row3["SYear"]." }, ";
    }

    // Remove the last comma to prevent JSON errors
    $chart_data3 = rtrim($chart_data3, ", ");

    
    $query4 = "SELECT * FROM stafperformance WHERE SPerformanceDep='Workers Department'";
    $result4 = mysqli_query($conn, $query4);
    $chart_data4 = '';

    while($row4 = mysqli_fetch_array($result4)) {
        $chart_data4 .= "{ department:'".$row4["SPerformanceDep"]."', rating:".$row4["SRating"].", year:".$row4["SYear"]." }, ";
    }

   
    $chart_data4 = rtrim($chart_data4, ", ");


   
    $query5 = "SELECT SYear, AVG(SRating) as AvgRating FROM stafperformance GROUP BY SYear ORDER BY SYear";
    $result5 = mysqli_query($conn, $query5);
    $chart_data5 = '';

    while ($row5 = mysqli_fetch_array($result5)) {
        $chart_data5 .= "{ year: ".$row5["SYear"].", rating: ".$row5["AvgRating"]." }, ";
    }

    
    $chart_data5 = rtrim($chart_data5, ", ")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Performance Chart</title>
    <link rel="stylesheet" href="Staffper.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
</head>
<body>

    <div class="container">
        <div class="body-container">
            <div class="nav-bar">
                <img class="logo-img" src="01.jpg.png" alt="Company Logo">
                <div class="nav-btns">
                    <a class="profile-btn" href="../../1-Chairman/chairmanhome.php">Back</a>
                </div>
            </div>
            <div class="back1" style="margin-top: 408px; background-color: rgba(0, 0, 0, 0.527); color: white;font-size: 30px;padding: 100px;filter: blur(3);">
                <div class="info">
                    <label>STAFF PERFORMANCE AT TECHSPACE</label>
                    <h1>Staff Performance</h1>
                    <p>"The staff performance at Techspace, an apparel company, is driven by dedication, efficiency, and innovation. Our team consistently strives for excellence in design, production, and customer service, ensuring high-quality apparel that meets industry standards."</p>
                </div>
            </div>
        </div>
    </div>

    
    <div class="main-bar" style="display: flex; flex-direction: column; align-items: center;justify-content: center;gap:150px;margin-top:100px;font-size:25px;font-family: 'Inter', serif;">

        <style>
            
            .cs1,.cs2,.cs3,.cs4,.cs5 {
                 transition: transform 0.3s ease-in-out;
            }

            .cs1:hover {
            transform: scale(1.1);
            }

            .cs2:hover {
            transform: scale(1.1);
            }
            
            .cs3:hover {
            transform: scale(1.1);
            }
            
            .cs4:hover {
            transform: scale(1.1);
            }
        
            .cs5:hover {
            transform: scale(1.1);
            }
        
        
        </style>
    
        <div class="bar1" style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap:350px">

            <div class="cs1" style="width:500px; display: flex; flex-direction: column; text-align: center;">
                <h2>Financial Department</h2>
                <div id="chart" style="margin-top:50px;"></div>
            </div>

            <div class="cs2" style="width:500px; display: flex; flex-direction: column; text-align: center;">
                <h2>HR Department</h2>
                <div id="chart2" style="margin-top:50px;"></div>
            </div>

        </div>
   
        <div class="bar2" style="display: flex; flex-wrap: wrap; justify-content: center;align-items: center; gap:350px">

            <div class="cs3" style="width:500px; display: flex; flex-direction: column; text-align: center;">
                <h2>Business Development Department</h2>
                <div id="chart3" style="margin-top:50px;"></div>
            </div>

            <div class="cs4" style="width:500px; display: flex; flex-direction: column; text-align: center;">
                <h2>Workers Department</h2>
                <div id="chart4" style="margin-top:50px;"></div>
            </div>

        </div>
   

        <div class="cs5" style="width:900px; display: flex; flex-direction: column; text-align: center;">
            <h2>Total Factory Performance</h2>
            <div id="chart5" style="margin-top:50px;"></div>
        </div>
    
    </div>   


    <script>
        Morris.Bar({
            element: 'chart',
            data: [<?php echo $chart_data; ?>],
            xkey: 'year',
            ykeys: ['rating'],
            labels: ['Rating'],
            hideHover: 'auto',
            stacked: true
        });
    </script>

    <script>
        Morris.Bar({
            element: 'chart2',
            data: [<?php echo $chart_data2; ?>],
            xkey: 'year',
            ykeys: ['rating'],
            labels: ['Rating'],
            hideHover: 'auto',
            stacked: true
        });
    </script>

    
    <script>
        Morris.Bar({
            element: 'chart3',
            data: [<?php echo $chart_data3; ?>],
            xkey: 'year',
            ykeys: ['rating'],
            labels: ['Rating'],
            hideHover: 'auto',
            stacked: true
        });
    </script>

    <script>
        Morris.Bar({
            element: 'chart4',
            data: [<?php echo $chart_data4; ?>],
            xkey: 'year',
            ykeys: ['rating'],
            labels: ['Rating'],
            hideHover: 'auto',
            stacked: true
        });
    </script>


   
    <script>
        Morris.Bar({
            element: 'chart5',
            data: [<?php echo $chart_data5; ?>],
            xkey: 'year',
            ykeys: ['rating'],
            labels: ['Average Rating'],
            parseTime: false, 
            hideHover: 'auto',
            lineColors: ['#007bff'],  // Customize line color
            pointFillColors: ['#ff0000'],  // Customize data point color
            lineWidth: 2
        });
    </script>

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
</html>
