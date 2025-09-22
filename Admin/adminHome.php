<?php
include "config.php";
$bookCount = $conn->query("SELECT COUNT(*) AS total FROM books")->fetch_assoc()['total'];
$notReturnedCount = $conn->query("SELECT COUNT(*) AS total FROM borrow WHERE status='borrowed'")->fetch_assoc()['total'];
$userCount = $conn->query("SELECT COUNT(*) AS total FROM register")->fetch_assoc()['total'];
$categoryCount = $conn->query("SELECT COUNT(*) AS total FROM category")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../CSS/adminHome.css">
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
        <h2>Welcome to the Admin Panel Boss!</h2>
        <div class="students-section">

            <div class="section-header">

                <h3>Dashboard</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Book Listed</th>
                        <th>Book Not Returned Yet</th>
                        <th>Registered Users</th>
                        <th>Listed Categories</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $bookCount; ?></td>
                        <td><?php echo $notReturnedCount; ?></td>
                        <td><?php echo $userCount; ?></td>
                        <td><?php echo $categoryCount; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../JS/sideBar.js"></script>
</body>

</html>