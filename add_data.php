<?php
session_start();
// print_r($_SESSION);
if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit(0);
}
$userId = isset($_GET['id']) ? $_GET['id'] : null;

if ($userId === null) {
    // Handle the case where 'id' is not provided in the URL
    echo "User ID is missing!";
    exit(0);
}

include_once "database/db.php";
include "include/forProfile.php";

$sql = "SELECT * FROM users WHERE id = $userId";
$result = $conn->query($sql);

if ($result === false) {
    die("Error in SQL query: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("User not found");
}
// Assuming you have stored user information in the session during login,
// you can fetch additional information such as the user's type from the database.
$user_id = $_SESSION['user_id'];

// Query to fetch user details including the type
$userQuery = "SELECT type FROM users WHERE id = $user_id";
$userResult = $conn->query($userQuery);

if ($userResult->num_rows > 0) {
    $userRow = $userResult->fetch_assoc();
    $userType = $userRow['type'];
} else {
    // Handle case where user details are not found
    // For example, redirect the user to the login page or display an error message
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.5.2/js/bootstrap.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add data</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="bt/css/bootstrap.css">
    <link rel="stylesheet" href="style/style_user.css">
    <link rel="icon" href="image/ksitlogo.PNG">
    <link rel="stylesheet" href="style/styledd.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php include "include/head.php";
    ?>
</head>

<body>
    <!-- database -->
    <?php  ?>
    <!-- header  -->
    <?php include_once "include/header.php"; ?>
    <!-- navigation -->
    <?php include "include/navigation.php"; ?>

    <br>
    <div class="wrappage">
        <div id="add_data">
            <h1 class="float-start">បន្ថែមទិន្នន័យ</h1>
            <button type="button" class="btn btn-primary float-end mx-5" data-toggle="modal" data-target="#myModal">
                <i class="fa-solid fa-plus me-1"></i>បន្ថែមពូជ
            </button>

            <input type="hidden" id="update_id" name="update_id" value="">
            <form action="add_data2.php" method="POST" enctype="multipart/form-data">
                <table>

                    <tr>
                        <td style="width: 15%;">ពូជទី១<span class="text-danger">*</span></td>
                        <td style="width: 30%;">

                            <select style="width: 80%;" class="form-control" name="breed1" id="" required>
                                <option value="">Please Select</option>
                                <?php
                                // Perform SELECT query
                                $sql = "SELECT breed_name FROM breed_name_tb";
                                $result = $conn->query($sql);

                                // Check if the query was successful
                                if ($result) {
                                    // Fetch data and display options for the first dropdown
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['breed_name'] . '">' . $row['breed_name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </td>
                        <td style="width: 20%;">អាយុចេញផ្កាឈ្មោល</td>
                        <td style="width: 30%;"><input style="width: 80%;" class="form-control" type="text" name="Male_flowering_age"></td>
                    </tr>
                    <tr>
                        <td>ពូជទី២<span class="text-danger">*</span></td>
                        <td style="width: 30%;">

                            <select style="width: 80%;" class="form-control" name="breed2" id="" required>
                                <option value="">Please Select</option>

                                <?php
                                // Reset the result set pointer to the beginning
                                $result->data_seek(0);

                                // Fetch data and display options for the second dropdown
                                while ($row = $result->fetch_assoc()) {

                                    echo '<option value="' . $row['breed_name'] . '">' . $row['breed_name'] . '</option>';
                                }

                                ?>

                            </select>
                        </td>
                        <td>អាយុចេញផ្កាញី</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Flowering_age"></td>
                    </tr>

                    <tr>
                        <td>ជំនាន់<span class="text-danger">*</span></td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="version" required></td>
                        <td>គម្លាតអាយុចេញផ្កា</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Flowering_age_gap"></td>
                    </tr>
                    <tr>
                        <td>ចំនួនទងផ្កា</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="number_of_stalks"></td>
                        <td>ចំនួនផ្កាឈ្លោល</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Number_of_chrysanthemums"></td>
                    </tr>
                    <tr>
                        <td>កម្ពស់ផ្លែ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="fruit_height"></td>
                        <td>ប្រវែងទងផ្កាឈ្មោល</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Male_stalk_length"></td>
                    </tr>
                    <tr>
                        <td>កម្ពស់ដើម</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Stem_height"></td>
                        <td>ប្រវែងផ្លែទាំងសំបក</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Fruit_length_and_skin"></td>
                    </tr>
                    <tr>
                        <td>មុំស្លឹក</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Leaf_angle"></td>
                        <td>ភាពមានកន្ទុយលើចុងផ្លែ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="The_tail_on_the_end_of_the_fruit"></td>
                    </tr>
                    <tr>
                        <td>ប្រវែងផ្លែ</td>
                        <td><input style="width: 80%;" style="width: 80%;" class="form-control" type="text" name="Fruit_length"></td>
                        <td>ភាពជាប់ផ្លែ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Fertility"></td>
                    </tr>
                    <tr>
                        <td>រូបរាងផ្លែ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Fruit_appearance"></td>
                        <td>ទំហំដើម</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Original_size"></td>
                    </tr>
                    <tr>
                        <td>ប្រវែងគល់ផ្លែ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Stem_length"></td>
                        <td>ប្រព័ន្ធឫស</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Root_system"></td>
                    </tr>
                    <tr>
                        <td>រូបភាព<span class="text-danger"></span></td>
                        <td> <input style="width: 80%;" class="form-control" type="file" name="images[]" id="images" multiple accept="image/*" onchange="previewImages(event)">

                        </td>


                    </tr>

                </table>
                <div id="imagePreview"></div>
                <!-- <div id="image_edit">
                </div> -->


                <button class="btn btn-success" type="submit" name="submit"><i class="fa-solid fa-check me-1"></i>SAVE</button>
            </form>


        </div>
    </div>


    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Insert Breed Name</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="insertForm" action="insert_data.php" method="POST">
                        <div class="form-group">
                            <label for="name">breed name:</label>
                            <input type="text" class="form-control" id="name" name="breed_name" required>

                        </div>
                        <!-- Your additional form fields for inserting data -->
                        <button type="button" class="btn btn-success" onclick="insertData()"><i class="fa-solid fa-check me-1"></i>SAVE</button>
                        <!-- <input type="button" class="btn btn-success" onclick="insertData()" value="Insert" required>  -->
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php
    include "include/footer.php";
    ?>

    <script src="script/add_breed.js"></script>
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
                    image.className = 'preview-image';
                    image.src = e.target.result;
                    imageContainer.appendChild(image);

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
                    imageContainer.appendChild(removeButton);

                    previewContainer.appendChild(imageContainer);
                };

                reader.readAsDataURL(file);
            }
        }
    </script>



</body>

</html>