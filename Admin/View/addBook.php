<?php
include "config.php";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookName = $_POST['bookName'];
    $authorId = $_POST['authorId'];
    $categoryId = $_POST['categoryId'];
    $bookNumber = $_POST['bookNumber'];
    $bookPrice = $_POST['bookPrice'];

    if (!empty($bookName) && !empty($authorId) && !empty($categoryId) && !empty($bookNumber) && !empty($bookPrice)) {
        $sql = "INSERT INTO book (bookName, authorId, categoryId, bookNumber, bookPrice)
                VALUES ('$bookName', '$authorId', '$categoryId', '$bookNumber', '$bookPrice')";
        if ($conn->query($sql) === TRUE) {
            $message = "Book added successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
    } else {
        $message = "All fields are required!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <link rel="stylesheet" href="../CSS/addBook.css">
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
        <h2>Add a new book</h2>
        <form method="POST">
            <label>Book Name:</label>
            <input type="text" name="bookName">

            <label>Author ID:</label>
            <input type="text" name="authorId">

            <label>Category ID:</label>
            <input type="text" name="categoryId">

            <label>Book Number:</label>
            <input type="text" name="bookNumber">

            <label>Book Price:</label>
            <input type="text" name="bookPrice">

            <button type="submit">Add Book</button>
        </form>
        <p><?php echo $message; ?></p>
    </div>
    <script src="../JS/sideBar.js"></script>
</body>
</html>
