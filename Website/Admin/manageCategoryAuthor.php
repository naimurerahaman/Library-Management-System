<?php
include "config.php";
session_start();

$message = "";

if (isset($_POST['delete_id']) && isset($_POST['type'])) {
    $id = $_POST['delete_id'];
    $type = $_POST['type'];

    if ($type === 'author') {
        $stmt = $conn->prepare("DELETE FROM author WHERE id = ?");
    } elseif ($type === 'category') {
        $stmt = $conn->prepare("DELETE FROM category WHERE id = ?");
    }

    if (isset($stmt)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = " " . ucfirst($type) . " deleted successfully!";
        } else {
            $message = " Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

$authors_result = $conn->query("SELECT * FROM author ORDER BY authorName ASC");
$categories_result = $conn->query("SELECT * FROM category ORDER BY categoryName ASC");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Manage Categories/Authors</title>
    <link rel="stylesheet" href="../CSS/manageBook.css">
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
                <a href="manageCategoryAuthor.php" class="active">Manage</a>
            </div>
        </div>
        <a href="adminIssueBook.php">Issue Books</a>
        <a href="viewStudentDetails.php">View Student Details</a>
        <a href="changePassAdmin.php">Change Password</a>
    </div>

    <div class="content">
        <h2>Manage Authors</h2>
       
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Author Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
if ($authors_result->num_rows > 0) {
    while ($row = $authors_result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['authorName']) . "</td>";
        echo "<td>";
        echo "<a href='editAuthor.php?id=" . $row['id'] . "' class='btn-edit'>Edit</a> ";
        echo "<form method='POST' style='display:inline;'>";
        echo "<input type='hidden' name='delete_id' value='" . $row['id'] . "'>";
        echo "<input type='hidden' name='type' value='author'>";
        echo "<button type='submit' class='btn-delete' onclick=\"return confirm('Are you sure you want to delete this author?');\">Delete</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No authors found.</td></tr>";
}
?>

            </tbody>
        </table>

        <h2 style="margin-top: 40px;">Manage Categories</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
if ($categories_result->num_rows > 0) {
    while ($row = $categories_result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['categoryName']) . "</td>";
        echo "<td>";
        echo "<a href='editCategory.php?id=" . $row['id'] . "' class='btn-edit'>Edit</a> ";
        echo "<form method='POST' style='display:inline;'>";
        echo "<input type='hidden' name='delete_id' value='" . $row['id'] . "'>";
        echo "<input type='hidden' name='type' value='category'>";
        echo "<button type='submit' class='btn-delete' onclick=\"return confirm('Are you sure you want to delete this category?');\">Delete</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No categories found.</td></tr>";
}
?>

            </tbody>
        </table>
    </div>
    <script src="../JS/sideBar.js"></script>
</body>

</html>