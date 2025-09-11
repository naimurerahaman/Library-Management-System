<?php
include "config.php";
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$message = "";
$book = null; // Initialize $book to avoid errors

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch current book details using a prepared statement
    $stmt = $conn->prepare("SELECT * FROM book WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
    $stmt->close();

    // If book is not found, redirect
    if (!$book) {
        header("Location: manageBook.php");
        exit();
    }
} else {
    // If no ID is provided, redirect
    header("Location: manageBook.php");
    exit();
}

// Fetch authors and categories for the dropdowns
$authors_result = $conn->query("SELECT id, authorName FROM author ORDER BY authorName ASC");
$categories_result = $conn->query("SELECT id, categoryName FROM category ORDER BY categoryName ASC");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookName = $_POST['bookName'];
    $authorId = $_POST['authorId'];
    $categoryId = $_POST['categoryId'];
    $bookNumber = $_POST['bookNumber'];
    $bookPrice = $_POST['bookPrice'];

    // Use a prepared statement for the update query
    $stmt = $conn->prepare("UPDATE book SET bookName = ?, authorId = ?, categoryId = ?, bookNumber = ?, bookPrice = ? WHERE id = ?");
    $stmt->bind_param("siidss", $bookName, $authorId, $categoryId, $bookNumber, $bookPrice, $id);

    if ($stmt->execute()) {
        header("Location: manageBook.php");
        exit();
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
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
                <a href="addCategoryAuthor.php" >Add</a>
                <a href="manageCategoryAuthor.php">Manage</a>
            </div>
        </div>
        <a href="adminIssueBook.php">Issue Books</a>
        <a href="viewStudentDetails.php">View Student Details</a>
        <a href="changePassAdmin.php">Change Password</a>
    </div>

    <div class="content">
        <h2>Edit Book</h2>
        <form method="POST">
            <label>Book Name:</label>
            <input type="text" name="bookName" value="<?php echo htmlspecialchars($book['bookName']); ?>" required><br>

            <label>Author:</label>
            <select name="authorId" required>
                <?php
                if ($authors_result->num_rows > 0) {
                    while($row = $authors_result->fetch_assoc()) {
                        $selected = ($row['id'] == $book['authorId']) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($row['id']) . '" ' . $selected . '>' . htmlspecialchars($row['authorName']) . '</option>';
                    }
                }
                ?>
            </select><br>

            <label>Category:</label>
            <select name="categoryId" required>
                <?php
                if ($categories_result->num_rows > 0) {
                    while($row = $categories_result->fetch_assoc()) {
                        $selected = ($row['id'] == $book['categoryId']) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($row['id']) . '" ' . $selected . '>' . htmlspecialchars($row['categoryName']) . '</option>';
                    }
                }
                ?>
            </select><br>

            <label>Book Number:</label>
            <input type="text" name="bookNumber" value="<?php echo htmlspecialchars($book['bookNumber']); ?>" required><br>

            <label>Book Price:</label>
            <input type="text" name="bookPrice" value="<?php echo htmlspecialchars($book['bookPrice']); ?>" required><br>
            
            <button type="submit">Update Book</button>
        </form>
        <p><?php echo htmlspecialchars($message); ?></p>
    </div>
    <script src="../JS/sideBar.js"></script>
</body>
</html>