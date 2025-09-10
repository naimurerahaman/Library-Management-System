<?php
include "config.php";

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['borrow_btn'])) {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $isbn = trim($_POST['isbn']);
    $duration = trim($_POST['duration']);

    if (empty($title) || empty($author) || empty($isbn) || empty($duration)) {
      $error = "Fill all fields";
    } elseif (!is_numeric($duration) || $duration <= 0) {
      $error = "Duration must be a positive number";
    } else {
      $sql = "INSERT INTO borrow_requests (title, author, isbn, duration) VALUES ('$title','$author','$isbn','$duration')";
      if ($conn->query($sql) === TRUE) {
        $success = "Borrow request submitted";
      } else {
        $error = "Error: " . $conn->error;
      }
    }
  }

  if (isset($_POST['delete_btn'])) {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM borrow_requests WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
      $success = "Request deleted";
    } else {
      $error = "Error: " . $conn->error;
    }
  }
}

$result = $conn->query("SELECT * FROM borrow_requests ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Borrow Book</title>
  <link rel="stylesheet" href="../CSS/borrow.css" />
</head>

<body>
  <div class="navbar">
    <h2>WELCOME ! User Dashboard</h2>
    <div class="user-info">
      <span>👤 Username</span>
      <button class="logout-btn">Logout</button>
    </div>
  </div>
  <div class="container">
    <div class="sidebar">
      <a href="viewprofile.php">View Profile</a>
      <a href="searchbook.php">Search Book</a>
      <a href="borrow.php">Borrow Book Request</a>
      <a href="returnbook.php">Return Book</a>
      <a href="feedback.php">Feedback</a>
    </div>
    <div class="main-content">
      <div class="borrow-card">
        <h1>Borrow Books Request</h1>
        <form method="POST">
          <div class="form-field">
            <label>Borrow Book Title</label>
            <input type="text" name="title" placeholder="Enter Book Title" />
          </div>
          <div class="form-field">
            <label>Borrow Book Author</label>
            <input type="text" name="author" placeholder="Enter Book Author" />
          </div>
          <div class="form-field">
            <label>Borrow Book ISBN</label>
            <input type="text" name="isbn" placeholder="Enter Book ISBN" />
          </div>
          <div class="form-field">
            <label>Borrow Book Duration</label>
            <input type="number" name="duration" placeholder="Enter Duration Days" />
          </div>
          <button type="submit" name="borrow_btn">Borrow Request</button>
        </form>
        <p class="success"><?php echo $success; ?></p>
        <p class="error"><?php echo $error; ?></p>
        <table class="table" border="1" cellpadding="5" cellspacing="0">
          <thead>
            <tr>
              <th>Title</th>
              <th>Author</th>
              <th>ISBN</th>
              <th>Duration (Days)</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['title']}</td>
                        <td>{$row['author']}</td>
                        <td>{$row['isbn']}</td>
                        <td>{$row['duration']}</td>
                        <td>{$row['request_date']}</td>
                        <td>
                          <form method='POST' style='display:inline;'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <button type='submit' name='delete_btn' onclick=\"return confirm('Are you sure you want to delete this request?');\">Delete</button>
                          </form>
                        </td>
                      </tr>";
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>