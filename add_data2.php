<?php
include_once "database/db.php";


if (isset($_POST['submit'])) {
    $breed1 = $_POST['breed1'];
    $breed2 = $_POST['breed2'];
    $Male_flowering_age = $_POST['Male_flowering_age'];
    $breed2e = $_POST['breed2'];
    $Flowering_age = $_POST['Flowering_age'];
    $version = $_POST['version'];
    $Flowering_age_gap = $_POST['Flowering_age_gap'];
    $number_of_stalks = $_POST['number_of_stalks'];
    $Number_of_chrysanthemums = $_POST['Number_of_chrysanthemums'];
    $fruit_height = $_POST['fruit_height'];
    $Male_stalk_length = $_POST['Male_stalk_length'];
    $Stem_height = $_POST['Stem_height'];
    $Fruit_length_and_skin = $_POST['Fruit_length_and_skin'];
    $Leaf_angle = $_POST['Leaf_angle'];
    $The_tail_on_the_end_of_the_fruit = $_POST['The_tail_on_the_end_of_the_fruit'];
    $Fruit_length = $_POST['Fruit_length'];
    $Fertility = $_POST['Fertility'];
    $Fruit_appearance = $_POST['Fruit_appearance'];
    $Original_size = $_POST['Original_size'];
    $Stem_length = $_POST['Stem_length'];
    $Root_system = $_POST['Root_system'];


    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadedFiles = [];
    $allowedTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF]; // Define allowed image types
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['images']['error'][$key] !== UPLOAD_ERR_OK) {
            echo "Error uploading file: " . $_FILES['images']['error'][$key];
            continue; // Skip to the next iteration if there's an error
        }

        // Process the file normally
        $file_name = $_FILES['images']['name'][$key];
        $file_tmp = $_FILES['images']['tmp_name'][$key];
        $uploadPath = $uploadDir . $file_name;

        // Move the uploaded file to the destination directory
        if (move_uploaded_file($file_tmp, $uploadPath)) {
            $uploadedFiles[] = $uploadPath;

            // Check the image type after successful upload
            $imageType = exif_imagetype($uploadPath);
            if (!in_array($imageType, $allowedTypes)) {
                // Remove the invalid file if it doesn't match the allowed image types
                unlink($uploadPath);
                echo "Invalid image type for file: " . $_FILES['images']['name'][$key];
                continue; // Skip to the next iteration
            }
        } else {
            echo "Error uploading file: " . $_FILES['images']['error'][$key];
        }
    }



    $imagePaths = implode(',', $uploadedFiles);

    // Prepare and execute SQL query to insert data into the database
    $sql = "INSERT INTO data (breed1, breed2, version, Number_of_stalks, Fruit_height,	Stem_height,Leaf_angle,Fruit_length,Fruit_appearance,Stem_length,Male_flowering_age
    ,Flowering_age,Flowering_age_gap,Number_of_chrysanthemums,Male_stalk_length,Fruit_length_and_skin,The_tail_on_the_end_of_the_fruit,Fertility,Original_size,Root_system,images) 
    VALUES ('$breed1', '$breed2', '$version', '$number_of_stalks', '$fruit_height','$Stem_height ','$Leaf_angle', '$Fruit_length' , '$Fruit_appearance','$Stem_length'
    ,'$Male_flowering_age','$Flowering_age','$Flowering_age_gap','$Number_of_chrysanthemums', '$Male_stalk_length','$Fruit_length_and_skin',  '$The_tail_on_the_end_of_the_fruit'
    ,'$Fertility','$Original_size','$Root_system','$imagePaths')";


    if ($conn->query($sql) === TRUE) {
        // Successful insertion
        header("Location: breed.php");
    } else {
        // Display the SQL error
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
