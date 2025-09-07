<?php
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentName = htmlspecialchars($_POST['studentName'] ?? '');
    $studentId   = htmlspecialchars($_POST['studentId'] ?? '');
    $bookTitle   = htmlspecialchars($_POST['bookTitle'] ?? '');

    if (empty($studentName) || empty($studentId) || empty($bookTitle)) {
        $_SESSION['issue_msg'] = "Please fill in all fields.";
        header("Location: adminIssueBook.php");
        exit();
    } else {
        $_SESSION['issue_status'] = "Book issued successfully";
        header("Location: adminManageIssuedBook.php");
        exit();
    }
}

if (isset($_SESSION['issue_msg'])) {
    $message = $_SESSION['issue_msg'];
    unset($_SESSION['issue_msg']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Issue a New Book</title>
    <link rel="stylesheet" href="../CSS/adminIssueBook.css">
    <link rel="stylesheet" href="../CSS/sideBar.css">
</head>
<body>
  <div class="logout">
        <a href="login.php" class="btn-logout"><button>Log Out</button></a>
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
            <a href="#" class="dropdown-btn">Categories</a> 
            <div class="dropdown-content">
                <a href="addCategory.php">Add Category</a>
                <a href="manageCategory.php">Manage Category</a>
            </div>
        </div>
        <a href="adminIssueBook.php">Issue Books</a>
        <a href="viewStudentDetails.php">View Student Details</a>
        <a href="changePassAdmin.php">Change Password</a>
    </div>

    <div class="container"> 
        <h2>Issue A New Book</h2>
        <form action="adminIssueBook.php" method="POST">
            <label>Student Name:</label>
            <input type="text" id="studentName" name="studentName">
            
            <label>Student ID</label>
            <input type="text" id="studentId" name="studentId">
            
            <label>Book Title:</label>
            <input type="text" id="bookTitle" name="bookTitle">
            
            <button type="submit" class="issue-btn">Issue Book</button>
        </form>

        <?php if (!empty($message)): ?>
            <p class="error-message"><?php echo $message; ?></p>
        <?php endif; ?>
    </div>

    <script src="../JS/sideBar.js"></script>
</body>
</html>
