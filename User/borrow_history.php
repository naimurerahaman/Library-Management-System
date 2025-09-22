<?php
session_start();
include "config.php";
$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit();
}

$name = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

$sql = "SELECT bk.title, bk.author, bk.category, br.borrow_date, br.return_date 
        FROM borrow br 
        JOIN books bk ON br.book_id = bk.id 
        WHERE br.user_id='$user_id' AND br.status='returned'";
$result = $conn->query($sql);



?>
<!DOCTYPE html>
<html>

<head>
  <title>Borrow History</title>
  <link rel="stylesheet" href="../CSS/bar.css">
  <link rel="stylesheet" href="../CSS/viewborrowbook.css">
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
      <a href="userdashboard.php">Dashboard</a>
      <a href="editprofile.php">Edit Profile</a>
      <a href="search_book.php">Search Book</a>
      <a href="view_borrowed.php">View Borrow Book</a>
      <a href="borrow_history.php" class="active">Borrow History</a>
      <a href="feedback.php">Feedback</a>
    </div>
  </div>
  <div class="main-content">
    <h2>Borrow History</h2>
    <table border="1" cellpadding="5">
      <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Category</th>
        <th>Borrowed On</th>
        <th>Returned On</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['title'] ?></td>
          <td><?= $row['author'] ?></td>
          <td><?= $row['category'] ?></td>
          <td><?= $row['borrow_date'] ?></td>
          <td><?= $row['return_date'] ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>
</body>

</html>