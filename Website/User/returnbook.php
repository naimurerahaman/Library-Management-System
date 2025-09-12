<?php
include "config.php";
session_start();
$success = $error = "";
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
$name = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Return Book</title>
  <link rel="stylesheet" href="../CSS/returnbook.css" />
</head>

<body>
<div class="navbar">
  <h2>WELCOME <span><?php echo !empty($name) ? $name : "username"; ?></span> !</h2>
  <div class="user-info">
    <span><?php echo !empty($name) ? $name : "username"; ?></span>
    <a href="logout.php" class="btn-logout"><button>Log Out</button></a>
  </div>
</div>
  <div class="container-sidebar">
    <div class="sidebar">
      <a href="userdashboard.php" >Dashboard</a>
      <a href="editprofile.php" >Edit Profile</a>
      <a href="searchbook.php">Search Book</a>
      <a href="viewborrowbook.php">View Borrow Book</a>
      <a href="returnbook.php" class="active">Return Book</a>
      <a href="feedback.php">Feedback</a>
    </div>
    <div class="main-content">
      <div class="return-card">
        <h2>Return Book</h2>
        <form>
          <div class="form-field">
            <label for="title">Book Title</label>
            <input type="text" id="title" placeholder="Enter book title" />
          </div>

          <div class="form-field">
            <label for="author">Author</label>
            <input type="text" id="author" placeholder="Enter author name" />
          </div>

          <div class="form-field">
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" placeholder="Enter book ISBN" />
          </div>

          <div class="form-field">
            <label for="date">Return Date</label>
            <input type="date" id="date" />
          </div>

          <button type="submit" class="btn">Return Book</button>
        </form>
      </div>
    </div>
  </div>
</body>

</html>