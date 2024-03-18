<?php
session_start();
// print_r($_SESSION);
if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit(0);
}
?>

<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $dataId = $_GET['id'];
    // Rest of your code here
} else {
    die("Invalid data ID");
}

// Assuming you pass the user ID through the URL parameter
include_once "database/db.php";



$stmt = $conn->prepare("SELECT * FROM data WHERE id = ?");
$stmt->bind_param("i", $dataId);
$stmt->execute();
$result = $stmt->get_result();
include "include/foradmin.php";
if ($result->num_rows > 0) {
    $row3 = $result->fetch_assoc();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofQ8dQIjNXa+poEAg1M52n5Q5X1Y8NkN" crossorigin="anonymous"></script>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Data</title>
        <link rel="stylesheet" href="style/style.css">
        <link rel="stylesheet" href="bt/css/bootstrap.css">
        <link rel="stylesheet" href="style/style_user.css">
        <link rel="icon" href="image/ksitlogo.PNG">
        <link rel="stylesheet" href="style/styledd.css">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofQ8dQIjNXa+poEAg1M52n5Q5X1Y8NkN" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <?php include "include/head.php"; ?>
    </head>


    <body>
        <!-- database -->
        <?php include_once "database/db.php" ?>
        <!-- header  -->
        <?php include_once "include/header.php" ?>
        <!-- navigation -->
        <?php include "include/navigation.php"; ?>
        <br>
        <div class="wrappage">
            <div id="add_data">
                <h1 class="float-start">កែទិន្នន័យ</h1>
                <form action="update_data_form.php" method="POST" enctype="multipart/form-data">

                    <table>
                        <tr>
                            <input type="hidden" name="data_id" value="<?php echo $dataId; ?>">
                            <td style="width: 15%;">ពូជទី១</td>
                            <!-- breed1 dropdown -->
                            <td style="width: 30%;">
                                <select style="width: 80%;" class="form-control" name="breed1" id="" required>
                                    <?php
                                    // Perform SELECT query
                                    $sql = "SELECT breed_name FROM breed_name_tb";
                                    $result = $conn->query($sql);

                                    // Check if the query was successful
                                    if ($result) {
                                        // Fetch data and display options for the first dropdown
                                        while ($row = $result->fetch_assoc()) {
                                            // Set the selected option based on the value stored in the database
                                            $selected = ($row['breed_name'] == $row3['breed1']) ? 'selected' : '';
                                            echo '<option value="' . $row['breed_name'] . '" ' . $selected . '>' . $row['breed_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                            <td style="width: 20%;">អាយុចេញផ្កាឈ្មោល</td>
                            <td style="width: 30%;"><input style="width: 80%;" class="form-control" type="text" name="Male_flowering_age" value="<?php echo $row3['Male_flowering_age']; ?>"></td>
                        </tr>
                        <tr>
                        <tr>
                            <td>ពូជទី២</td>
                            <td style="width: 30%;">
                                <select style="width: 80%;" class="form-control" name="breed2" id="" required>
                                    <?php
                                    // Reset the result set pointer to the beginning
                                    $result->data_seek(0);

                                    // Fetch data and display options for the second dropdown
                                    while ($row = $result->fetch_assoc()) {
                                        // Set the selected option based on the value stored in the database
                                        $selected = ($row['breed_name'] == $row3['breed2']) ? 'selected' : '';
                                        echo '<option value="' . $row['breed_name'] . '" ' . $selected . '>' . $row['breed_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>អាយុចេញផ្កាញី</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Flowering_age" value="<?php echo $row3['Flowering_age']; ?>"></td>
                        </tr>
                        <tr>
                            <td>ជំនាន់</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="version" value="<?php echo $row3['version']; ?>"></td>
                            <td>គម្លាតអាយុចេញផ្កា</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Flowering_age_gap" value="<?php echo $row3['Flowering_age_gap']; ?>"></td>
                        </tr>
                        <tr>
                            <td>ចំនួនទងផ្កា</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="number_of_stalks" value="<?php echo $row3['Number_of_stalks']; ?>"></td>
                            <td>ចំនួនផ្កាឈ្លោល</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Number_of_chrysanthemums" value="<?php echo $row3['Number_of_chrysanthemums']; ?>"></td>
                        </tr>
                        <tr>
                            <td>កម្ពស់ផ្លែ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="fruit_height" value="<?php echo $row3['Fruit_height']; ?>"></td>
                            <td>ប្រវែងទងផ្កាឈ្មោល</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Male_stalk_length" value="<?php echo $row3['Male_stalk_length']; ?>"></td>
                        </tr>
                        <tr>
                            <td>កម្ពស់ដើម</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Stem_height" value="<?php echo $row3['Stem_height']; ?>"></td>
                            <td>ប្រវែងផ្លែទាំងសំបក</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Fruit_length_and_skin" value="<?php echo $row3['Fruit_length_and_skin']; ?>"></td>
                        </tr>
                        <tr>
                            <td>មុំស្លឹក</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Leaf_angle" value="<?php echo $row3['Leaf_angle']; ?>"></td>
                            <td>ភាពមានកន្ទុយលើចុងផ្លែ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="The_tail_on_the_end_of_the_fruit" value="<?php echo $row3['The_tail_on_the_end_of_the_fruit']; ?>"></td>
                        </tr>
                        <tr>
                            <td>ប្រវែងផ្លែ</td>
                            <td><input style="width: 80%;" style="width: 80%;" class="form-control" type="text" name="Fruit_length" value="<?php echo $row3['Fruit_length']; ?>"></td>
                            <td>ភាពជាប់ផ្លែ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Fertility" value="<?php echo $row3['Fertility']; ?>"></td>
                        </tr>
                        <tr>
                            <td>រូបរាងផ្លែ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Fruit_appearance" value="<?php echo $row3['Fruit_appearance']; ?>"></td>
                            <td>ទំហំដើម</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Original_size" value="<?php echo $row3['Original_size']; ?>"></td>
                        </tr>
                        <tr>
                            <td>ប្រវែងគល់ផ្លែ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Stem_length" value="<?php echo $row3['Stem_length']; ?>"></td>
                            <td>ប្រព័ន្ធឫស</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Root_system" value="<?php echo $row3['Root_system']; ?>"></td>
                        </tr>
                        <tr>
                            <td>រូបភាព</td>
                            <td colspan="">
                                <input style="width: 80%;" class="form-control" type="file" name="images[]" id="images" multiple accept="image/*" onchange="previewImages(event)">

                            </td>
                            <td></td>
                        </tr>
                    </table>
                    <div id="imagePreview" class="mt-2"></div>
                    <div id="image_edit">
                        <?php
                        $images = $row3['images'];
                        $images = trim($images, ','); // Remove leading and trailing commas
                        $images = explode(',', $images);

                        if (!empty($images)) {
                            foreach ($images as $index => $image) {
                                if (!empty($image)) { // Check if image path is not empty
                                    echo "<div class='mySlides'>
                                        <div id='slide_image'>
                                            <img src='$image' alt=''>
                                        </div>
                                        <div class='d-flex justify-content-center py-2'>
                                            <button class='btn btn-danger remove-image' data-image-id='$index' data-data-id='$dataId'>Remove</button>
                                        </div>
                                    </div>";
                                }
                            }
                        } else {
                            // Handle case where no images are available
                        }

                        ?>
                    </div>


                    <!-- Add new images -->
                    <input type="hidden" name="data_id" value="<?php echo $dataId; ?>">
                    <button style="margin-bottom: 20px;" class="btn btn-success" type="submit" name="update"><i class="fa-solid fa-check me-1"></i>រក្សាទុក</button>
                <?php
            } else {
                die("No data found for ID: $dataId");
            }
            $conn->close();
                ?>
            </div>
        </div>
        <?php
        include "include/footer.php";
        ?>
        <script src="script/dropdpwn.js"></script>
        <script>
            $(document).ready(function() {
                // Function to handle image removal
                $('.remove-image').click(function(event) {
                    event.preventDefault(); // Prevent default behavior of the link/button
                    var imageId = $(this).data('image-id');
                    var dataId = $(this).data('data-id');
                    var confirmation = confirm("Are you sure you want to delete this image?");
                    if (confirmation) {
                        $.ajax({
                            url: 'delete_image.php',
                            method: 'POST',
                            data: {
                                image_id: imageId,
                                data_id: dataId
                            },
                            success: function(response) {
                                try {
                                    var jsonResponse = JSON.parse(response);
                                    if (jsonResponse.success) {
                                        // Remove the image element from the DOM if deletion is successful
                                        $('#image_edit').find('.mySlides').eq(imageId).remove();
                                    } else {
                                        alert("Failed to delete image: " + jsonResponse.message);
                                    }
                                } catch (error) {
                                    console.error("Error parsing JSON response:", error);
                                    alert("An error occurred while processing the response.");
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX request error:", status, error);
                                alert("Error occurred while deleting image.");
                            }
                        });
                    }
                });
            });
        </script>
        <script>
            function previewImages(event) {
                var previewContainer = document.getElementById('imagePreview');
                previewContainer.innerHTML = ''; // Clear previous previews

                var files = event.target.files;
                var selectedFiles = Array.from(files); // Convert FileList to array

                for (var i = 0; i < files.length; i++) {
                    var file = files[i];

                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var imageContainer = document.createElement('div');
                        imageContainer.className = 'preview-image-container ';

                        var image = document.createElement('img');
                        image.className = 'preview-image ';
                        image.src = e.target.result;
                        imageContainer.appendChild(image);

                        // Create a div for the button
                        var buttonDiv = document.createElement('div');
                        buttonDiv.className = 'button-container d-flex justify-content-center mt-5'; // You can style this container as needed
                        imageContainer.appendChild(buttonDiv);

                        var removeButton = document.createElement('button');
                        removeButton.className = 'btn btn-danger remove-image-button';
                        removeButton.textContent = 'Remove';
                        removeButton.addEventListener('click', function() {
                            // Remove the image container when the button is clicked
                            imageContainer.remove();
                            // Remove the corresponding file from the selectedFiles array
                            var index = selectedFiles.indexOf(file);
                            selectedFiles.splice(index, 1);
                            // Update the file input element with the updated selected files
                            var newFileList = new DataTransfer();
                            selectedFiles.forEach(function(file) {
                                newFileList.items.add(file);
                            });
                            document.getElementById('images').files = newFileList.files;
                        });
                        buttonDiv.appendChild(removeButton);

                        previewContainer.appendChild(imageContainer);
                    };
                    reader.readAsDataURL(file);
                }
            }
        </script>

    </body>

    </html>