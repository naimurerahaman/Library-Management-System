<?php
include "config.php";
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entryType = $_POST['entry_type'];
    $entryName = $_POST['entry_name'];

    if (empty($entryType) || empty($entryName)) {
        $message = " Please select a type and enter a name.";
    } else {
        if ($entryType === 'author') {
            $stmt = $conn->prepare("INSERT INTO author (authorName) VALUES (?)");
        } elseif ($entryType === 'category') {
            $stmt = $conn->prepare("INSERT INTO category (categoryName) VALUES (?)");
        }

        if (isset($stmt)) {
            $stmt->bind_param("s", $entryName);
            if ($stmt->execute()) {
                $message = " " . ucfirst($entryType) . " added successfully!";
            } else {
                $message = " Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Category/Author</title>
    <link rel="stylesheet" href="../CSS/addCategory.css">
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
                <a href="addCategoryAuthor.php">Add</a>
                <a href="manageCategoryAuthor.php">Manage</a>
            </div>
        </div>
        <a href="adminIssueBook.php">Issue Books</a>
        <a href="viewStudentDetails.php">View Student Details</a>
        <a href="changePassAdmin.php">Change Password</a>
    </div>

    <div class="content">
        <h2>Add a New Category or Author</h2>
        <form method="POST">
            <label for="entry_type">Select Type:</label>
            <select name="entry_type" id="entry_type" required>
                <option value="">-- Select --</option>
                <option value="category">Category</option>
                <option value="author">Author</option>
            </select><br>

            <label for="entry_name">Name:</label>
            <input type="text" name="entry_name" id="entry_name" required><br>

            <button type="submit">Add</button>
        </form>
        <p><?php echo htmlspecialchars($message); ?></p>
    </div>
    <script src="../JS/sideBar.js"></script>
</body>

</html>