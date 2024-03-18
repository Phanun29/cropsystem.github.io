<?php
session_start();
// print_r($_SESSION);
if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit(0);
}
include "database/db.php";
include "include/foradmin.php";
// include "include/forProfile.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>breed</title>
    <?php include "include/head.php"; ?>
</head>

<body>
    <!-- header  -->
    <?php include_once "include/header.php" ?>
    <!-- navigation -->
    <?php include "include/navigation.php"; ?>
    <br>
    <div class="wrappage ">

        <h2 class="container fload-start "><a class="text-decoration-none " href="breed.php?id=<?php echo $_SESSION['user_id']; ?>">LIST DATA</a> <a class="text-decoration-none bg-success p-1 text-white" href="list_breed.php?id=<?php echo $_SESSION['user_id']; ?>">LIST BREED</a> <button type="button" class="btn btn-primary float-end mx-5" data-toggle="modal" data-target="#myModal">
                <i class="fa-solid fa-plus me-1"></i>បន្ថែមពូជ
            </button></h2>


        <div id="list_user" class="container">
            <table id='table_user' class="mt-5" style="width: 50%;">
                <thead>
                    <tr class="text-center">
                        <th style="width: 15%;">#</th>
                        <th style="width: 45%;">ឈ្មោះពូជ</th>
                        <th style="width: 40%;">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    <?php



                    $sql = "SELECT * FROM breed_name_tb ORDER BY id DESC";
                    $result = $conn->query($sql);
                    $i = 1;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr class="text-center">';
                            echo '<td>' . $i++ . '</td>';
                            echo '<td>' . $row['breed_name'] . '</td>'; // 
                            echo "<th class='p-1' >         
                                <button type='button' class='btn btn-primary float-start px-4' onclick='openUpdateModal({$row['id']}, \"{$row['breed_name']}\")' data-id='{$row['id']}'><i class='fa-solid fa-pen-to-square me-1'></i>កែ</button>
                                <form  style='width: 100%;'   action='delete_breed.php' method='post'>
                                    <input type='hidden' name='breed_id' value='{$row['id']}'>
                                    <button class='btn btn-danger float-end px-4' type='submit' name='delete' // onclick='return confirm(\"Are you sure you want to delete this breed?\")'><i class='fa-solid fa-trash me-1'></i>លុប</button>
                                </form></div> </th>";
                            echo '</tr>';
                        }
                    } else {
                        // echo "No data in the database.";
                    }

                    $conn->close();

                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- add breed -->
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


    <!-- Updated Modal for Update -->
    <div class="modal" id="updateModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Breed Name</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="updateForm">
                        <div class="form-group">
                            <label for="updatedName">Update breed name:</label>
                            <input type="text" class="form-control" id="updatedName" name="updated_breed_name" required>

                        </div>
                        <input type="hidden" id="update_id" name="update_id" value="">
                        <button type="button" class="btn btn-success" onclick="updateData()">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <?php
    include "include/footer.php";
    ?>
    <script src="script/add_breed.js"></script>
    <script src="script/update_breed.js"></script>

</body>

</html>