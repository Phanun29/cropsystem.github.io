<?php
session_start();
// print_r($_SESSION);
if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit(0);
}
?>
<?php

include_once "database/db.php";
include "include/forProfile.php";

$dataId = $_GET['id']; // Assuming you pass the user ID through the URL parameter



$sql = "SELECT * FROM data WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $dataId);
$stmt->execute();
$result = $stmt->get_result();
include "include/foradmin.php";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {





?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            <script src="bt/js/bootstrap.bundle.min.js"></script>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>details</title>
            <link rel="stylesheet" href="style/style.css">
            <link rel="icon" href="image/ksitlogo.PNG">
            <link rel="stylesheet" href="bt/css/bootstrap.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Kdam+Thmor+Pro&family=Koulen&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Koulen&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="style/styledd.css">
            <link rel="stylesheet" href="style/image_full.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        </head>
        <style>
            .slideshow-container {
                max-width: 800px;
                position: relative;
                margin: auto;
                width: 500px;
                height: 600px;
            }

            .mySlides {
                display: none;
            }

            img {
                width: 100%;
            }

            .button-container {
                text-align: center;
                margin-top: 10px;

            }

            .prev,
            .next {
                padding: 10px;
                background-color: #4CAF50;
                color: white;
                border: none;
                cursor: pointer;
            }
        </style>

        <body>
            <!-- header  -->
            <?php include_once "include/header.php" ?>
            <!-- navigation -->
            <?php include "include/navigation.php"; ?>
            <br>
            <div class="wrappage ">
                <a id="btn_back" class="btn btn-primary mx-5 my-3 me-0 mb-0" href="breed.php">ថយក្រោយ</a>
                <a class='btn btn-primary mx-5 my-3 ms-0 mb-0' href='update_data.php?id=<?php echo $row['id']; ?>'><i class="fa-solid fa-pen-to-square me-1"></i>កែ</a>

                <div id="table_data" class="container">
                    <table class="container">
                        <tr>
                            <td>ពូជទី១</td>
                            <input type="hidden" name="user_id" value="<?php echo $dataId; ?>">
                            <td><?php echo $row['breed1']; ?></td>
                            <td>អាយុចេញផ្កាឈ្មោល</td>
                            <td><?php echo $row['Male_flowering_age']; ?></td>
                        </tr>
                        <tr>
                            <td>ពូជទី២</td>
                            <td><?php echo $row['breed2']; ?></td>
                            <td>អាយុចេញផ្កាញី</td>
                            <td><?php echo $row['Flowering_age']; ?></td>
                        </tr>
                        <tr>
                            <td>ជំនាន់</td>
                            <td><?php echo $row['version']; ?></td>
                            <td>គម្លាតអាយុចេញផ្កា</td>
                            <td><?php echo $row['Flowering_age_gap']; ?></td>
                        </tr>
                        <tr>
                            <td>ចំនួនទងផ្កា</td>
                            <td><?php echo $row['Number_of_stalks']; ?></td>
                            <td>ចំនួនផ្កាឈ្លោល</td>
                            <td><?php echo $row['Number_of_chrysanthemums']; ?></td>
                        </tr>
                        <tr>
                            <td>កម្ពស់ផ្លែ</td>
                            <td><?php echo $row['Fruit_height']; ?></td>
                            <td>ប្រវែងទងផ្កាឈ្មោល</td>
                            <td><?php echo $row['Male_stalk_length']; ?></td>
                        </tr>
                        <tr>
                            <td>កម្ពស់ដើម</td>
                            <td><?php echo $row['Stem_height']; ?></td>
                            <td>ប្រវែងផ្លែទាំងសំបក</td>
                            <td><?php echo $row['Fruit_length_and_skin']; ?></td>
                        </tr>
                        <tr>
                            <td>មុំស្លឹក</td>
                            <td><?php echo $row['Leaf_angle']; ?></td>
                            <td>ភាពមានកន្ទុយលើចុងផ្លែ</td>
                            <td><?php echo $row['The_tail_on_the_end_of_the_fruit']; ?></td>
                        </tr>
                        <tr>
                            <td>ប្រវែងផ្លែ</td>
                            <td><?php echo $row['Fruit_length']; ?></td>
                            <td>ភាពជាប់ផ្លែ</td>
                            <td><?php echo $row['Fertility']; ?></td>
                        </tr>
                        <tr>
                            <td>រូបរាងផ្លែ</td>
                            <td><?php echo $row['Fruit_appearance']; ?></td>
                            <td>ទំហំដើម</td>
                            <td><?php echo $row['Original_size']; ?></td>
                        </tr>
                        <tr>
                            <td>ប្រវែងគល់ផ្លែ</td>
                            <td><?php echo $row['Stem_length']; ?></td>
                            <td>ប្រព័ន្ធឫស</td>
                            <td><?php echo $row['Root_system']; ?></td>
                        </tr>
                    </table>
                    <?php
                    $images = explode(',', $row['images']);
                    $imageCount = count($images);
                    if ($imageCount > 0) {
                        echo "<div id='image'>";
                        echo "<div id='image_slider' class='slideshow-container overflow-hidden d-flex'>";
                        foreach ($images as $index => $image) {
                            if (!empty($image)) { // Check for empty image paths
                                echo "<div class='mySlides'>
                                        <img src='$image' alt=''>
                                    </div>";
                            }
                        }
                        echo "</div>";
                        echo "<div id='numbering' class='d-flex justify-content-center'>
                                <p id='imageCount'>Image $imageCount of $imageCount</p>
                            </div>";
                        echo "<div style='overflow: hidden;' class='button-container m-3'>
                                <button class='prev' onclick='prevSlide()'>Previous</button>
                                <button class='next' onclick='nextSlide()'>Next</button>
                            </div>";
                        echo "</div>"; // close #image div
                    }
                    ?>

                </div>
            </div>
            <br>
    <?php
    }
} else {
    die("data not found");
}
$conn->close();
include "include/footer.php";
    ?>
    <div id="imageModal" class="modal">
        <span class="close">&times;</span>
        <div class="modal-content">
            <img id="expandedImg" />
        </div>
    </div>
    <script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let i;
            let slides = document.getElementsByClassName('mySlides');
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = 'none';
            }
            if (slideIndex >= slides.length) {
                slideIndex = 0;
            }
            if (slideIndex < 0) {
                slideIndex = slides.length - 1;
            }
            slides[slideIndex].style.display = 'block';
        }

        function nextSlide() {
            slideIndex++;
            showSlides();
        }

        function prevSlide() {
            slideIndex--;
            showSlides();
        }
    </script>

    <script>
        // JavaScript for image modal

        var modal = document.getElementById('imageModal');

        // Get the image and insert it inside the modal
        var img = document.getElementById('expandedImg');

        // Function to handle click on image and open modal
        $('img').on('click', function() {
            modal.style.display = "block";
            img.src = this.src;
        });

        // Function to close modal when clicking outside of the image
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        };
    </script>
    <script src="script/numbering_image.js"></script>
        </body>

        </html>