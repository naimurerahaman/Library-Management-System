<?php
session_start(); 
$message = "";


   if (isset($_SESSION['issue_status'])) {
   $message = $_SESSION['issue_status'];
   unset($_SESSION['issue_status']); 
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Issued Books</title>
    <link rel="stylesheet" href="../CSS/adminManageBook.css">
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
    <div class="main-content">
        <h2>MANAGE ISSUED BOOKS</h2>

        <?php if (!empty($message)): ?>
            <div class="success-message-container">
                <p>Success : <?php echo $message; ?></p>
            </div>
        <?php endif; ?>

        </div>
<script src="../JS/sideBar.js"></script>
</body>
</html>