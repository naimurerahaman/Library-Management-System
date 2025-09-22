<?php
include "config.php";

if (!isset($_GET['id'])) {
    header("Location: manageBook.php");
    exit();
}

$id = $_GET['id'];


$result = $conn->query("SELECT * FROM books WHERE id=$id");
if ($result->num_rows == 0) {
    echo "Book not found!";
    exit();
}
$row = $result->fetch_assoc();


$authors = $conn->query("SELECT * FROM author");
$categories = $conn->query("SELECT * FROM category");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $isbn = $_POST['isbn'];

    $stmt = $conn->prepare("UPDATE books SET title=?, author=?, category=?, isbn=? WHERE id=?");
    $stmt->bind_param("sissi", $title, $author, $category, $isbn, $id);

    if ($stmt->execute()) {
        header("Location: manageBook.php");
        exit();
    } else {
        echo "Error updating book: " . $stmt->error;
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
                <a href="addCategoryAuthor.php">Add</a>
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
            <label for="title">Book Title:</label><br>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required><br><br>

            <label for="author">Author:</label><br>
            <select id="author" name="author" required>
                <?php while ($a = $authors->fetch_assoc()) { ?>
                    <option value="<?php echo $a['id']; ?>"
                        <?php if ($a['id'] == $row['author']) echo "selected"; ?>>
                        <?php echo htmlspecialchars($a['authorName']); ?>
                    </option>
                <?php } ?>
            </select><br><br>

            <label for="category">Category:</label><br>
            <select id="category" name="category" required>
                <?php while ($c = $categories->fetch_assoc()) { ?>
                    <option value="<?php echo $c['id']; ?>"
                        <?php if ($c['id'] == $row['category']) echo "selected"; ?>>
                        <?php echo htmlspecialchars($c['categoryName']); ?>
                    </option>
                <?php } ?>
            </select><br><br>

            <label for="isbn">Book Number (ISBN):</label><br>
            <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($row['isbn']); ?>" required><br><br>

            <button type="submit">Update Book</button>
        </form>
    </div>
</body>
<script src="../JS/sideBar.js"></script>

</html>