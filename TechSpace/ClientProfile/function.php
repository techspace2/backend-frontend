<?php

function make_avatar($character)
{
    $folder = 'avatar/';
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    $path = $folder . time() . '.png';
    $image = imagecreate(200, 200);
    
    $red = rand(0, 255);
    $green = rand(0, 255);
    $blue = rand(0, 255);
    imagecolorallocate($image, $red, $green, $blue);

    $textcolor = imagecolorallocate($image, 255, 255, 255);

    // Set font file path
    $font = 'font/ARIAL.TTF';
    if (!file_exists($font)) {
        die("Font file missing!");
    }

    imagettftext($image, 100, 0, 55, 150, $textcolor, $font, $character);

    if (!imagepng($image, $path)) {
        die("Failed to save avatar image.");
    }

    imagedestroy($image);
    return $path;
}


function Get_user_avatar($LoginID, $conn) {
    $query = "SELECT user_avatar FROM ClientProfile WHERE login_id = ?";
    $statement = $conn->prepare($query);

    // Bind the parameter
    $statement->bind_param("i", $LoginID);

    // Execute the query
    $statement->execute();

    // Get the result
    $result = $statement->get_result();

    // Check if a result was returned
    if ($row = $result->fetch_assoc()) {
        // Display the avatar
        if (!empty($row["user_avatar"])) {
            echo '<img src="' . $row["user_avatar"] . '" width="75" />';
        } else {
            echo '<img src="default-avatar.png" width="75" />';  // Placeholder if no avatar
        }
    } else {
        echo '<img src="default-avatar.png" width="75" />';  // Placeholder if no result
    }

    // Close the statement
    $statement->close();
}

?>