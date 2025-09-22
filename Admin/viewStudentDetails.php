<?php
include "config.php";

$sql = "SELECT r.id, r.fullname, r.email, br.status, bk.title
        FROM register r
        LEFT JOIN borrow br ON r.id = br.user_id
        LEFT JOIN books bk ON br.book_id = bk.id
        ORDER BY r.id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Student Details</title>
    <link rel="stylesheet" href="../CSS/viewStudentDetails.css" />
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
    <div class="main-content">
        <h2>All Students & Borrow Details</h2>
        <table border="1" cellpadding="5">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Book</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['fullname'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['title'] ?? '-' ?></td>
                    <td><?= $row['status'] ?? '-' ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <script src="../JS/sideBar.js"></script>
</body>

</html>