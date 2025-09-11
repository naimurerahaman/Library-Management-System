<?php
include "config.php";
$message = "";

// Fetch authors and categories from the database for the dropdowns
$authors_result = $conn->query("SELECT id, authorName FROM author ORDER BY authorName ASC");
$categories_result = $conn->query("SELECT id, categoryName FROM category ORDER BY categoryName ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookName = $_POST['bookName'];
    $authorId = $_POST['authorId'];
    $categoryId = $_POST['categoryId'];
    $bookNumber = $_POST['bookNumber'];
    $bookPrice = $_POST['bookPrice'];
    
    if (!empty($bookName) && !empty($authorId) && !empty($categoryId) && !empty($bookNumber) && !empty($bookPrice)) {
        $stmt = $conn->prepare("INSERT INTO book (bookName, authorId, categoryId, bookNumber, bookPrice) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siids", $bookName, $authorId, $categoryId, $bookNumber, $bookPrice);

        if ($stmt->execute()) {
            $message = "✅ Book added successfully!";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "⚠️ All fields are required!";
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
            <label>Book Name:</label>
            <input type="text" name="bookName" required>

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

            <label>Book Number:</label>
            <input type="text" name="bookNumber" required>

            <label>Book Price:</label>
            <input type="text" name="bookPrice" required>

            <button type="submit">Add Book</button>
        </form>
        <p><?php echo $message; ?></p>
    </div>
    <script src="../JS/sideBar.js"></script>
</body>
</html>