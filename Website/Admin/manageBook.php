<?php
include "config.php";

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM books WHERE id=$id");
    header("Location: manageBook.php");
    exit();
}

$result = $conn->query("SELECT * FROM books");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Manage Books</title>
    <link rel="stylesheet" href="../CSS/manageBook.css">
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
        <h2>Manage Books</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Book Name</th>
                <th>Author ID</th>
                <th>Category ID</th>
                <th>Book Number</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['author']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['isbn']; ?></td>

                    <td>
                        <a href="editBook.php?id=<?php echo $row['id']; ?>" class="btn edit">Edit</a> |
                        <a href="manageBook.php?delete=<?php echo $row['id']; ?>" class="btn delete">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <script src="../JS/sideBar.js"></script>
</body>

</html>