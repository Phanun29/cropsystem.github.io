<?php
// retrieveData.php
session_start();
include "database/db.php";

echo "<tr class='text-center'>";
// echo "<th style='width: 5%;'>#</th>";
// echo "<th style='width: 10%;'>breed1</th>";
// echo "<th style='width: 10%;'>breed2</th>";
// echo "<th style='width: 10%;'>ជំនាន់</th>";
// echo "<th style='width: 10%;'>ចំនួនទងផ្កា</th>";
// echo "<th style='width: 10%;'>កម្ពស់ផ្លែ</th>";
// echo "<th style='width: 10%;'>កម្ពស់ដើម</th>";
// echo "<th style='width: 13%;'>Activities</th>";
echo "</tr>";

// $numberOfRows = isset($_POST['numberOfRows']) ? intval($_POST['numberOfRows']) : 10;
// echo "Number of Rows Selected: " . $numberOfRows . "<br>";
// Retrieve filter values
$filterBreed1 = trim($_POST['filterBreed1']);
$filterBreed2 = trim($_POST['filterBreed2']);
$filterVersion = trim($_POST['version']); // Assuming the input field for version is named 'version'

// Build filter conditions
$filterConditions = [];

if (!empty($filterBreed1)) {
    $filterConditions[] = "breed1 = '$filterBreed1'";
}

if (!empty($filterBreed2)) {
    $filterConditions[] = "breed2 = '$filterBreed2'";
}

if (!empty($filterVersion)) {
    $filterConditions[] = "version = '$filterVersion'";
}

// Combine filter conditions using AND
$filterCondition = !empty($filterConditions) ? ' AND ' . implode(' AND ', $filterConditions) : '';

// Construct SQL query
$sql = "SELECT * FROM data WHERE 1 $filterCondition";



echo "SQL Query: " . $sql . "<br>";

$result = $conn->query($sql);

if (!$result) {
    die("Error in query: " . $conn->error);
}
$i = 1;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // ... (your existing code to display table rows)
        // Output or log relevant data here
        echo '<tr class="text-center">';
        echo '<td>' . $i++ . '</td>';
        echo '<td>' . $row['breed1'] . '</td>';
        echo '<td>' . $row['breed2'] . '</td>';
        echo '<td>' . $row['version'] . '</td>';
        echo '<td>' . $row['Number_of_stalks'] . '</td>';
        echo '<td>' . $row['Fruit_height'] . '</td>';
        echo '<td>' . $row['Stem_height'] . '</td>';
        echo "<td><a class='btn btn-primary float-start' href='details.php?id={$row['id']}'><i class='fa-solid fa-eye me-1'></i>Details</a>
            <form style='width: 100%;' action='delete_data.php' method='post'>
                <input type='hidden' name='data_id' value='{$row['id']}'>
                <button class='btn btn-danger float-end' type='submit' name='delete' onclick='return confirm(\"Are you sure you want to delete this data?\")'><i class='fa-solid fa-trash me-1'></i>Delete</button>
            </form>
            </td>";
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="8" class="text-center">No matching records found.</td></tr>';
}


error_log("SQL Query: " . $sql);

$conn->close();
