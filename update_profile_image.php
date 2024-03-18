<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit(0);
}

// Include necessary database connection code
include_once "database/db.php";

$user_id = $_SESSION['user_id'];

if (isset($_POST['change_image'])) {
    $newProfileImage = $_FILES['new_profile_image'];

    // Check if a file was uploaded
    if ($newProfileImage['error'] == 0) {
        // Specify the directory to store uploaded profile images
        $uploadDir = 'profile_images/';
        if(!file_exists($uploadDir)){
            mkdir($uploadDir, 0777, true);
        }
    
       

        // Generate a unique filename for the uploaded image
        $newFilename = $user_id . '_' . time() . '_' . $newProfileImage['name'];
        $uploadPath = $uploadDir . $newFilename;
       

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($newProfileImage['tmp_name'], $uploadPath)) {
            // Update the user's profile image in the database
            $updateSql = "UPDATE users SET images = '$newFilename' WHERE id = $user_id";
            $conn->query($updateSql);

            // Redirect back to the profile page with a success message
            header('location: profile.php?success=1');
            exit(0);
        } else {
            // Handle the case when the file could not be moved
            header('location: profile.php?error=1');
            exit(0);
        }
    } else {
        // Handle the case when no file was uploaded
        header('location: profile.php?error=2');
        exit(0);
    }
} else {
    // Redirect back to the profile page if the form was not submitted
    header('location: profile.php');
    exit(0);
}
?>
