<?php
if(isset($_POST['delete'])){
    $breedId = $_POST['breed_id'];

    include_once "database/db.php";

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Delete user and associated images (adjust your table structure accordingly)
    $deleteSql = "DELETE FROM breed_name_tb WHERE id = $breedId";
    $conn->query($deleteSql);

    $conn->close();

    header("Location: list_breed.php");
    exit();
}
?>
