<?php
include "config.php";
$message = "";

$authors_result = $conn->query("SELECT id, authorName FROM author ORDER BY authorName ASC");
$categories_result = $conn->query("SELECT id, categoryName FROM category ORDER BY categoryName ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $authorId = $_POST['authorId'] ?? '';
    $categoryId = $_POST['categoryId'] ?? '';
    $isbn = $_POST['isbn'] ?? '';

    if (!empty($title) && !empty($authorId) && !empty($categoryId) && !empty($isbn)) {
        $stmt = $conn->prepare("INSERT INTO books (title, author, category, isbn) 
                                VALUES (?, 
                                        (SELECT authorName FROM author WHERE id=?), 
                                        (SELECT categoryName FROM category WHERE id=?), 
                                        ?)");
        $stmt->bind_param("siis", $title, $authorId, $categoryId, $isbn);

        if ($stmt->execute()) {
            $message = "Book added successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
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
        <a href="logout.php" class="btn-logout"><button>Log Out</button></a>
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
                <a href="addCategoryAuthor.php" >Add</a>
                <a href="manageCategoryAuthor.php">Manage</a>
            </div>
        </div>
        <a href="adminIssueBook.php">Issue Books</a>
        <a href="viewStudentDetails.php">View Student Details</a>
        <a href="changePassAdmin.php">Change Password</a>     
    </div>

    <div class="content">
        <h2>Add a new book</h2>
        <form method="POST">
            <label>Book Title:</label>
            <input type="text" name="title" required>

            <label>Author:</label>
            <select name="authorId" required>
                <option value="">Select Author</option>
                <?php
                if ($authors_result->num_rows > 0) {
                    while($row = $authors_result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['authorName']) . '</option>';
                    }
                }
                ?>
            </select>

            <label>Category:</label>
            <select name="categoryId" required>
                <option value="">Select Category</option>
                <?php
                if ($categories_result->num_rows > 0) {
                    while($row = $categories_result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['categoryName']) . '</option>';
                    }
                }
                ?>
            </select>

            <label>ISBN:</label>
            <input type="text" name="isbn" required>

            <button type="submit">Add Book</button>
        </form>
        <p><?php echo $message; ?></p>
    </div>
    <script src="../JS/sideBar.js"></script>
</body>
</html>
