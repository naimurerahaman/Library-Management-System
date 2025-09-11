<?php
include "config.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
$name = $_SESSION['username'];

if (isset($_POST['return'])) {
  $book_id = $_POST['book_id'];

  // Get book details from borrow table
  $sql = "SELECT * FROM borrow WHERE id='$book_id'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $book = $result->fetch_assoc();

    // Insert into returnbooks
    $conn->query("INSERT INTO returnbooks (title, author, category, isbn) 
                      VALUES ('{$book['title']}', '{$book['author']}', '{$book['category']}', '{$book['isbn']}')");

    // Delete from borrow
    $conn->query("DELETE FROM borrow WHERE id='$book_id'");
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>View Borrowed Books</title>
  <link rel="stylesheet" href="../CSS/viewborrowbook.css" />
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
      <a href="borrow.php">Borrow Book Request</a>
      <a href="returnbook.php">Return Book</a>
      <a href="feedback.php">Feedback</a>
    </div>

    <div class="main-content">
      <h3>Borrowed Books</h3>
      <table>
        <thead>
          <tr>
            <th>Book Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>ISBN</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM borrow";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>
                          <td>{$row['title']}</td>
                          <td>{$row['author']}</td>
                          <td>{$row['category']}</td>
                          <td>{$row['isbn']}</td>
                          <td>
                            <form method='post'>
                              <input type='hidden' name='book_id' value='{$row['id']}'>
                              <button type='submit' name='return'>Return</button>
                            </form>
                          </td>
                        </tr>";
            }
          } else {
            echo "<tr><td colspan='5'>No borrowed books found.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>