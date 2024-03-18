<?php
session_start();
// print_r($_SESSION);
if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit(0);
}
?>

<?php
if (isset($_POST['register'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $type = $_POST['type'];

    // Create a directory to store uploaded images
    $uploadDir = 'profile_images/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadedFiles = [];
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['images']['name'][$key];
        $file_tmp = $_FILES['images']['tmp_name'][$key];
        $uploadPath = $uploadDir . $file_name;

        if (move_uploaded_file($file_tmp, $uploadPath)) {
            $uploadedFiles[] = $uploadPath;
        }
    }
    // Insert user information and image paths into the database
    include_once "database/db.php";

    $imagePaths = implode(',', $uploadedFiles);
    $sql = "INSERT INTO users (first_name, last_name, username, password, email, phone_number, images,type) 
            VALUES ('$first_name', '$last_name', '$username', '$password', '$email', '$phone_number', '$imagePaths','$type')";
    // $conn->query($sql);
    if ($conn->query($sql) == true) {
        // header("location :user.php");
        echo "<script> 
        // alert('Insert Successfull');
        document.location.href= 'user.php'
        </script>";
    }

    $conn->close();

    echo "Registration successful!";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>user</title>
    <?php
    include "database/db.php";
    include "include/head.php";
    include "include/foradmin.php";
    ?>


</head>

<body>
    <!-- header  -->
    <?php include_once "include/header.php" ?>
    <!-- navigation -->

    <?php include "include/navigation.php"; ?>
    <br>
    <div class="wrappage ">
        <a class=" btn btn-primary p-6 " href="user.php">BACK</a>
        <h2 class="container">USER</h2>
        <div id="add_user" class="container">
            <form id="form_add_user" class="container" action="" method="post" enctype="multipart/form-data">
                <table id="table_add_user">
                    <tr>
                        <td>
                            <label class="form-label" for="first_name">First Name </label>
                            <input class="form-control" type="text" name="first_name" id="first_name">
                        </td>
                        <td>
                            <label class="form-label" for="last_name">Last Name:</label>
                            <input class="form-control" type="text" name="last_name">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="form-label" for="username">Username<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="username" required>
                        </td>
                        <td>
                            <label class="form-label" for="password">Password<span class="text-danger">*</span></label>
                            <input class="form-control" type="password" name="password" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="form-label" for="email">Email<span class="text-danger"></span></label>
                            <input class="form-control" type="email" name="email" required>
                        </td>
                        <td>
                            <label class="form-label" for="phone_number">Phone Number:</label>
                            <input class="form-control" type="text" name="phone_number">
                        </td>
                    </tr>
                    <tr class="">
                        <td>
                            <label class="form-label" for="type">Type<span class="text-danger">*</span></label>
                            <select name="type" id="" class="form-control" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select><br>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <button class="btn btn-success" type="submit" name="register"><i class="fa-solid fa-check me-1"></i>SAVE</button>
                        </td>
                    </tr>
                </table>
            </form>

        </div>
    </div>
    <br>
    <?php
    include "include/footer.php";
    ?>
    <script src="script/dropdpwn.js"></script>
</body>

</html>