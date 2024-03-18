    <?php
    session_start();
    // print_r($_SESSION);
    if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
        header('location: ../index.php');
        exit(0);
    }

    include "database/db.php";
    include "include/forProfile.php";
    // Constants for pagination
    $rowsPerPage = 10; // Adjust as needed
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

    // Calculate the offset for the current page
    $offset = ($currentPage - 1) * $rowsPerPage;

    // Query to get the total number of records
    $totalRecordsQuery = "SELECT COUNT(*) as total FROM data";
    $totalRecordsResult = $conn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['total'];

    // Calculate total pages
    $totalPages = ceil($totalRecords / $rowsPerPage);

    // Query to retrieve data for the current page
    $sql = "SELECT * FROM data ORDER BY id DESC LIMIT $offset, $rowsPerPage";
    $result = $conn->query($sql);

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
    include_once "include/foradmin.php";
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>DATA</title>
        <?php include "include/head.php"; ?>
        <script src="https://unpkg.com/tableexport.min.js"></script>

    </head>

    <body>
        <!-- header  -->
        <?php include_once "include/header.php" ?>
        <!-- navigation -->
        <?php include "include/navigation.php"; ?>
        <br>
        <div class="wrappage ">
            <h2 class="container fload-start ">
                <a class="text-decoration-none bg-success p-1 text-white" href="breed.php?id=<?php echo $_SESSION['user_id']; ?>">LIST DATA</a>
                <a class="text-decoration-none" href="list_breed.php?id=<?php echo $_SESSION['user_id']; ?>">LIST BREED</a>
            </h2>
            <div class="container pt-3">
                <form id="" class=" ">
                    <div class="float-start">
                        <button type="button" id="exportButton" class="btn btn-primary" onclick="exportToExcel()">Export to Excel</button>
                        <!-- <label class="" for="rowsPerPage">Show</label>
                        <select id="rowsPerPage" onchange="updateRows()">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option> -->
                        <!-- Add more options as needed -->
                        <!-- </select> Data -->
                    </div>
                    <div class="float-end">
                        <div>
                            <div class="float-start mx-2 d-flex justify-content-between" style="font-family: 'Quicksand', 'Khmer OS siemreap', sans-serif; font-weight: 500;">
                                <!-- Inside your form in the HTML -->
                                <div class="float-start mx-2">
                                    <select class="form-control" name="filterBreed1" id="filterBreed1" required>
                                        <?php
                                        // Perform SELECT query
                                        $sql = "SELECT breed_name FROM breed_name_tb";
                                        $result1 = $conn->query($sql);

                                        // Check if the query was successful
                                        if ($result1 && $result1->num_rows > 0) {
                                            // Fetch data and display options for the first dropdown
                                            echo '<option value="">Please Select</option>'; // Default option
                                            while ($row1 = $result1->fetch_assoc()) {
                                                echo '<option value="' . $row1['breed_name'] . '">' . $row1['breed_name'] . '</option>';
                                            }
                                        } else {
                                            // If no data is retrieved or an error occurs, display a default option
                                            echo '<option value="">No options available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="float-end">
                                    <select class="form-control " name="filterBreed2" id="filterBreed2" required>
                                        <option value="">Please Select</option>
                                        <?php
                                        // Reset the result set pointer to the beginning
                                        $result1->data_seek(0);

                                        // Fetch data and display options for the second dropdown
                                        while ($row1 = $result1->fetch_assoc()) {

                                            echo '<option value="' . $row1['breed_name'] . '">' . $row1['breed_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mx-2">
                                    <input style="width: 100px;" type="number" min="1" name="version" id="version" class="form-control" placeholder="ជំនាន់">
                                </div>
                            </div>
                            <div class="float-end">
                                <button type="button" id="applyFiltersBtn" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>ស្វែងរក</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="list_user" class="container">

                <table id='myTable' class="container">

                    <thead>
                        <tr class="text-center">
                            <th style="width: 5%;">#</th>
                            <th style="width: 10%;">ពូជទី១</th>
                            <th style="width: 10%;">ពូជទី២</th>
                            <th style="width: 10%;">ជំនាន់</th>
                            <th style="width: 10%;">ចំនួនទងផ្កា</th>
                            <th style="width: 10%;">កម្ពស់ផ្លែ</th>
                            <th style="width: 10%;">កម្ពស់ដើម</th>
                            <th style="width: 17%;">សកម្មភាព</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "database/db.php";

                        // $sql = "SELECT * FROM data ORDER BY id DESC";
                        // $result = $conn->query($sql);
                        $i = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr class="text-center">';
                                echo '<td>' . $i++ . '</td>';
                                echo '<td>' . $row['breed1'] . '</td>';
                                echo '<td>' . $row['breed2'] . '</td>';
                                echo '<td>' . $row['version'] . '</td>';
                                echo '<td>' . $row['Number_of_stalks'] . '</td>';
                                echo '<td>' . $row['Fruit_height'] . '</td>';
                                echo '<td>' . $row['Stem_height'] . '</td>';
                                echo "<td><a class='btn btn-primary text-white float-start px-3' href='details.php?id={$row['id']}'><i class='fa-solid fa-eye me-1'></i>លម្អិត</a>
                                    <form style='width: 100%;' action='delete_data.php' method='post'>
                                        <input type='hidden' name='data_id' value='{$row['id']}'>
                                        <button class='btn btn-danger float-end px-4' type='submit' name='delete' onclick='return confirm(\"Are you sure you want to delete this data?\")'><i class='fa-solid fa-trash me-1'></i>លុប</button>
                                    </form>
                                    </td>";
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="8" class="text-center">No matching records found.</td></tr>';
                        }
                        $conn->close()
                        ?>
                    </tbody>
                </table>
                <div id="paginationSection">
                    <div class="d-flex justify-content-center mt-3">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only"></span>
                                    </a>
                                </li>

                                <?php
                                for ($i = 1; $i <= $totalPages; $i++) {
                                    echo '<li class="page-item ' . ($i == $currentPage ? 'active' : '') . '">';
                                    echo '<a class="page-link" href="?page=' . $i . '">' . $i . '</a>';
                                    echo '</li>';
                                }
                                ?>

                                <li class="page-item <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only"></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <?php
        include "include/footer.php";
        ?>
        <script>
            function download(content, fileName, contentType) {
                var a = document.createElement("a");
                var file = new Blob([content], {
                    type: contentType
                });
                a.href = URL.createObjectURL(file);
                a.download = fileName;
                a.click();
            }

            function exportToExcel() {
                var table = document.getElementById("myTable");
                var html = table.outerHTML;

                var blob = new Blob(['\ufeff', html], {
                    type: 'application/vnd.ms-excel'
                });

                var url = URL.createObjectURL(blob);
                var a = document.createElement("a");
                a.href = url;
                a.download = "table.xls";
                document.body.appendChild(a);
                a.click();
                setTimeout(function() {
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);
                }, 0);
            }
        </script>

        <script src="script/get_breed.js"></script>
        <script src="script/update_row.js"></script>
        <script src="script/filter.js"></script>
        <script>
            // Add this inside your script tag or in a separate script file

            function applyFilters() {
                // Your filter logic here

                // Hide pagination
                $("#paginationSection").hide();
            }

            function clearFilters() {
                // Your logic to clear filters

                // Show pagination
                $("#paginationSection").show();
            }
            // ... (rest of your script)

            // Adjust your filter button click event to call the applyFilters function
            $("#applyFiltersBtn").on("click", function() {
                applyFilters();
            });

            // Optionally, add a button or logic to clear filters and show pagination
            $("#clearFiltersBtn").on("click", function() {
                clearFilters();
            });
        </script>
        <script>
            function updateNumberedButtons(totalPages, currentPage) {
                var buttonsContainer = $(".pagination");

                buttonsContainer.empty(); // Clear existing buttons

                buttonsContainer.append(
                    `<li class="page-item ${currentPage === 1 ? "disabled" : ""}">
                <a class="page-link" href="#" aria-label="Previous" onclick="goToPage(${currentPage - 1})">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>`
                );

                for (var i = 1; i <= totalPages; i++) {
                    buttonsContainer.append(
                        `<li class="page-item ${i === currentPage ? "active" : ""}">
                    <a class="page-link" href="#" onclick="goToPage(${i})">${i}</a>
                </li>`
                    );
                }

                buttonsContainer.append(
                    `<li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
                <a class="page-link" href="#" aria-label="Next" onclick="goToPage(${currentPage + 1})">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>`
                );
            }

            function goToPage(page) {
                // Add logic to update the content based on the selected page
                console.log("Go to page", page);
                // For now, you can use window.location.href to navigate to the URL with the selected page parameter
                // window.location.href = `your_page.php?page=${page}`;
            }
        </script>

    </body>

    </html>