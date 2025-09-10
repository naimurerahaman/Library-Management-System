<?php
include "config.php";
$message = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM book WHERE id=$id");
    $book = $result->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bookName = $_POST['bookName'];
        $authorId = $_POST['authorId'];
        $categoryId = $_POST['categoryId'];
        $bookNumber = $_POST['bookNumber'];
        $bookPrice = $_POST['bookPrice'];

        
        $coverPhoto = $book['coverPhoto']; 
        if (!empty($_FILES['coverPhoto']['name'])) {
            $targetDir = "../uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $coverPhoto = $targetDir . basename($_FILES["coverPhoto"]["name"]);
            move_uploaded_file($_FILES["coverPhoto"]["tmp_name"], $coverPhoto);
        }

        $sql = "UPDATE book SET bookName='$bookName', authorId='$authorId', categoryId='$categoryId',
                bookNumber='$bookNumber', bookPrice='$bookPrice', coverPhoto='$coverPhoto' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            header("Location: manageBook.php");
            exit();
        } else {
            $message = " Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link rel="stylesheet" href="../CSS/editBook.css">
    <link rel="stylesheet" href="../CSS/sideBar.css">
</head>
<body>
    <div class="logout"><a href="login.php" class="btn-logout"><button>Log Out</button></a></div>
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
        <h2>Edit Book</h2>
        <form method="POST" enctype="multipart/form-data"> 
            <label>Book Name:</label>
            <input type="text" name="bookName" value="<?php echo $book['bookName']; ?>"><br>

            <label>Author ID:</label>
            <input type="text" name="authorId" value="<?php echo $book['authorId']; ?>"><br>

            <label>Category ID:</label>
            <input type="text" name="categoryId" value="<?php echo $book['categoryId']; ?>"><br>

            <label>Book Number:</label>
            <input type="text" name="bookNumber" value="<?php echo $book['bookNumber']; ?>"><br>

            <label>Book Price:</label>
            <input type="text" name="bookPrice" value="<?php echo $book['bookPrice']; ?>"><br>

            <label>Cover Photo:</label>
            <input type="file" name="coverPhoto">
            <?php if (!empty($book['coverPhoto'])): ?>
                <img class="coverPhoto" src="<?php echo $book['coverPhoto']; ?>" width="150">
            <?php endif; ?>

            <button type="submit">Update Book</button>
        </form>
        <p><?php echo $message; ?></p>
    </div>
        <script src="../JS/sideBar.js"></script>

</body>
</html>
