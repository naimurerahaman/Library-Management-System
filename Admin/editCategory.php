<?php
include "config.php";

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM category WHERE id=$id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = $_POST['categoryName'];
    $conn->query("UPDATE category SET name='$newName' WHERE id=$id");
    header("Location: manageCategory.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Category</title>
    <link rel="stylesheet" href="../CSS/sideBar.css">
    <link rel="stylesheet" href="../CSS/editCatAuth.css">
</head>

<body>
    <div class="logout">
        <a href="logout.php" class="btn-logout">
            <button>Log Out</button>
        </a>
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
            <a href="#" class="dropdown-btn">Categories & Authors</a>
            <div class="dropdown-content">
                <a href="addCategoryAuthor.php">Add</a>
                <a href="manageCategoryAuthor.php">Manage</a>
            </div>
        </div>
        <a href="adminIssueBook.php">Issue Books</a>
        <a href="viewStudentDetails.php">View Student Details</a>
        <a href="changePassAdmin.php">Change Password</a>
    </div>

    <div class="main-content">
    <h2>Edit Category</h2>
    <form method="POST">
        <label for="categoryName">Category Name:</label><br>
        <input type="text" id="categoryName" name="categoryName" value="<?php echo $row['categoryName']; ?>"><br>
        <button type="submit">Update Category</button>
    </form>
    </div>
</body>
<script src="../JS/sideBar.js"></script>
</html>