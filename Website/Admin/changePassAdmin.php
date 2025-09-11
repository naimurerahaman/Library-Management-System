<?php
session_start();
include "config.php";  

$message = "";

$adminEmail = "admin@example.com";

// ✅ Check if admin exists in DB
$sql = "SELECT * FROM adminpass WHERE email='$adminEmail' LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $adminData = $result->fetch_assoc();
    $oldPassword = $adminData['password'];
} else {
    $oldPassword = null; // if no row found
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current = $_POST["current_password"];
    $new = $_POST["new_password"];
    $confirm = $_POST["confirm_password"];

    if ($oldPassword === null) {
        $_SESSION['msg'] = "Admin account not found in database!";
    } elseif ($current !== $oldPassword) {
        $_SESSION['msg'] = "Current password is wrong!";
    } elseif ($new !== $confirm) {
        $_SESSION['msg'] = "New password and Confirm password do not match!";
    } elseif (empty($new)) {
        $_SESSION['msg'] = "New password cannot be empty!";
    } else {
        $update = "UPDATE adminpass SET password='$new' WHERE email='$adminEmail'";
        if ($conn->query($update) === TRUE) {
            $_SESSION['msg'] = "Password changed successfully!";
        } else {
            $_SESSION['msg'] = "Error updating password: " . $conn->error;
        }
    }

    header("Location: changePassAdmin.php");
    exit();
}

if (isset($_SESSION['msg'])) {
    $message = $_SESSION['msg'];
    unset($_SESSION['msg']); 
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Change Password</title>
  <link rel="stylesheet" href="../CSS/adminChangePass.css">
  <link rel="stylesheet" href="../CSS/sideBar.css">
</head>
<body>  
    </div>    
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
  
  <div class="container">
    <h2>Change Password</h2>
    <form method="post">
      <label>Current Password</label>
      <input type="password" name="current_password">

      <label>New Password</label>
      <input type="password" name="new_password">

      <label>Confirm Password</label>
      <input type="password" name="confirm_password">

      <input type="submit" value="Change Password">
    </form>
    <div class="msg"><?php echo $message; ?></div>
  </div>
  <script src="../JS/sideBar.js"></script>
</body>
</html>
