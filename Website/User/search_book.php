<?php
session_start();
include "config.php"; // your db connection
$user_id = $_SESSION['user_id']; // make sure login sets this

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$name = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
$success = ""; // Initialize the message variable
$error = "";

if (isset($_POST['borrow'])) {
    $book_id = $_POST['book_id'];
    $sql = "INSERT INTO borrow (user_id, book_id, status) VALUES ('$user_id', '$book_id', 'borrowed')";

    if ($conn->query($sql)) {
        // Assign success message to the variable
        $success = "<p style='color:green;'>Book borrowed successfully!</p>";
    } else {
        // Assign an error message if the query fails
        $error = "<p style='color:red;'>Error borrowing book: " . $conn->error . "</p>";
    }
}

$search = $_POST['search'] ?? '';
$sql = "SELECT * FROM books WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR category LIKE '%$search%'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Search Books</title>
  <link rel="stylesheet" href="../CSS/bar.css">
    <link rel="stylesheet" href="../CSS/searchbook.css">
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
      <a href="search_book.php" class="active">Search Book</a>
      <a href="view_borrowed.php">View Borrow Book</a>
      <a href="borrow_history.php">Borrow History</a>
      <a href="feedback.php">Feedback</a>
    </div>
    </div>
    <div class="main-content">
<h2>Search Books</h2>
<form method="post">
    <input type="text" name="search" placeholder="Search by title, author, category">
    <button type="submit">Search</button>
</form>
<table border="1" cellpadding="5">
<tr><th>Title</th><th>Author</th><th>Category</th><th>Action</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['title'] ?></td>
    <td><?= $row['author'] ?></td>
    <td><?= $row['category'] ?></td>
    <td>
        <form method="post">
            <input type="hidden" name="book_id" value="<?= $row['id'] ?>">
            <button type="submit" name="borrow">Borrow</button>
        </form>
    </td>
</tr>
<?php endwhile; ?>
</table>
<p class="success"><?php echo $success; ?></p>
        <p class="error"><?php echo $error; ?></p>
</div>
</body>
</html>
