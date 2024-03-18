<?php
if (isset($_POST['delete'])) {
    $dataId = $_POST['data_id'];

    include_once "database/db.php";

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete user and associated images (adjust your table structure accordingly)
    $deleteSql = "DELETE FROM data WHERE id = $dataId";
    $conn->query($deleteSql);

    $conn->close();

    header("Location: breed.php");
    exit();
}
