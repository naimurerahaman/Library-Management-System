<?php
include "config.php";

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM author WHERE id=$id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = $_POST['authorName'];
    $conn->query("UPDATE author SET authorName='$newName' WHERE id=$id");
    header("Location: manageAuthor.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Author</title>
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
    <h2>Edit Author</h2>
    <form method="POST">
        <label for="authorName">Author Name:</label><br>
        <input type="text" id="authorName" name="authorName" value="<?php echo $row['authorName']; ?>"><br>
        <button type="submit">Update Author</button>
    </form>
    </div>
</body>
<script src="../JS/sideBar.js"></script>
</html>
