<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = $_POST['categoryName'];

    if (!empty($categoryName)) {
        $sql = "INSERT INTO category (name) VALUES ('$categoryName')";
        if ($conn->query($sql) === TRUE) {
            echo "<p style='color:green;'>Category added successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Category name cannot be empty!</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Categories</title>
    <link rel="stylesheet" href="../CSS/addCategory.css">
    <link rel="stylesheet" href="../CSS/sideBar.css">
</head>
<body>
    <div class="logout">
        <a href="login.php" class="btn-logout"><button>Log Out</button></a>
    </div>

    <div class="sidebar">
        <a href="adminHome.php">Dashboard</a>
        <div class="dropdown">
            <a href="#" class="dropdown-btn">Books</a>
            <div class="dropdown-content">
                <a href="addBook.php">Add Book</a>
                <a href="manageBook.php">Manage Book</a>
            </div>
        </div>
        <div class="dropdown">
            <a href="#" class="dropdown-btn">Categories</a>
            <div class="dropdown-content">
                <a href="addCategory.php">Add Category</a>
                <a href="manageCategory.php">Manage Category</a>
            </div>
        </div>
        <a href="adminIssueBook.php">Issue Books</a>
        <a href="viewStudentDetails.php">View Student Details</a>
        <a href="changePassAdmin.php">Change Password</a>
    </div>

    <div class="content">
        <h2>Add a new Category</h2>
        <form method="POST">
            <label for="categoryName">Category Name:</label><br>
            <input type="text" id="categoryName" name="categoryName"><br>
            <button type="submit">Add Category</button>
        </form>
    </div>
    <script src="../JS/sideBar.js"></script>
</body>
</html>
