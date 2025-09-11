<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
$name = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Dashboard</title>
  <link rel="stylesheet" href="../CSS/userdashboard.css">
</head>
<body>
  <div class="navbar">
    <h2>WELCOME <span><?php echo htmlspecialchars($name); ?></span> !</h2>
    <div class="user-info">
      <span><?php echo htmlspecialchars($name); ?></span>
      <a href="logout.php" class="btn-logout"><button>Log Out</button></a>
    </div>
  </div>
  <div class="container-sidebar">
    <div class="sidebar">
      <a href="userdashboard.php" >Dashboard</a>
      <a href="editprofile.php" >Edit Profile</a>
      <a href="searchbook.php">Search Book</a>
      <a href="viewborrowbook.php">View Borrow Book</a>
      <a href="borrow.php">Borrow Book Request</a>
      <a href="returnbook.php">Return Book</a>
      <a href="feedback.php">Feedback</a>
    </div>

    <div class="main-content">
      <div class="dashboard-header">
        <h1>Welcome to Your Dashboard, <?php echo htmlspecialchars($name); ?>!</h1>
        <p>Explore all the features of the Library Management System.</p>
      </div>

      <div class="dashboard-grid">
        <div class="dashboard-card search-card">
          <h3>Search Books</h3>
          <p>Find your next read from our extensive collection.</p>
          <a href="searchbook.php" class="card-btn">Go to Search</a>
        </div>
        <div class="dashboard-card borrow-card">
          <h3>Borrow Books</h3>
          <p>Request to borrow a book with a few simple clicks.</p>
          <a href="borrow.php" class="card-btn">Borrow a Book</a>
        </div>
        <div class="dashboard-card return-card">
          <h3>Return Books</h3>
          <p>Process your book returns easily and quickly.</p>
          <a href="returnbook.php" class="card-btn">Return a Book</a>
        </div>
        <div class="dashboard-card view-card">
          <h3>My Books</h3>
          <p>View the list of all books you've borrowed.</p>
          <a href="viewborrowbook.php" class="card-btn">View My Books</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>