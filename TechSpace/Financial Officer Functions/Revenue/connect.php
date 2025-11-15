<?php 

    $servername="localhost";
    $username="root";
    $password="";
    $dbname="TechSpace";

    $conn=mysqli_connect($servername,$username,$password,$dbname);

    if(!$conn)
    {
        die("Connection Unsucessfull".mysqli_connect_error());
    }
    
   


?>