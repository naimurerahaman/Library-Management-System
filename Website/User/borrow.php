<?php
include "config.php";
session_start();

$success = $error = "";

// ✅ Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$name = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// ✅ Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ✅ Borrow Request
    if (isset($_POST['borrow_btn'])) {
        $title = trim($_POST['title']);
        $author = trim($_POST['author']);
        $isbn = trim($_POST['isbn']);
        $duration = trim($_POST['duration']);

        if (empty($title) || empty($author) || empty($isbn) || empty($duration)) {
            $error = "⚠️ Fill all fields.";
        } elseif (!is_numeric($duration) || $duration <= 0) {
            $error = "⚠️ Duration must be a positive number.";
        } else {
            $sql = "INSERT INTO borrow_requests (user_id, title, author, isbn, duration) 
                    VALUES ('$user_id', '$title', '$author', '$isbn', '$duration')";
            if ($conn->query($sql) === TRUE) {
                $success = "✅ Borrow request submitted.";
            } else {
                $error = "❌ Error: " . $conn->error;
            }
        }
    }

    // ✅ Delete Request
    if (isset($_POST['delete_btn'])) {
        $id = intval($_POST['id']);
        $sql = "DELETE FROM borrow_requests WHERE id=$id AND user_id=$user_id";
        if ($conn->query($sql) === TRUE) {
            $success = "✅ Request deleted.";
        } else {
            $error = "❌ Error: " . $conn->error;
        }
    }
}

// ✅ Fetch All Requests (only for this user)
$result = $conn->query("SELECT * FROM borrow_requests WHERE user_id=$user_id ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Borrow Book</title>
  <link rel="stylesheet" href="../CSS/borrow.css" />
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
      <a href="searchbook.php">Search Book</a>
      <a href="viewborrowbook.php">View Borrow Book</a>
      <a href="borrow.php" class="active">Borrow Book Request</a>
      <a href="returnbook.php">Return Book</a>
      <a href="feedback.php">Feedback</a>
    </div>

    <div class="main-content">
      <div class="borrow-card">
        <h1>Borrow Books Request</h1>

        <!-- ✅ Borrow Form -->
        <form method="POST">
          <div class="form-field">
            <label>Borrow Book Title</label>
            <input type="text" name="title" placeholder="Enter Book Title" required />
          </div>
          <div class="form-field">
            <label>Borrow Book Author</label>
            <input type="text" name="author" placeholder="Enter Book Author" required />
          </div>
          <div class="form-field">
            <label>Borrow Book ISBN</label>
            <input type="text" name="isbn" placeholder="Enter Book ISBN" required />
          </div>
          <div class="form-field">
            <label>Borrow Book Duration</label>
            <input type="number" name="duration" placeholder="Enter Duration Days" required />
          </div>
          <button type="submit" name="borrow_btn">Borrow Request</button>
        </form>

        <!-- ✅ Messages -->
        <p class="success"><?php echo $success; ?></p>
        <p class="error"><?php echo $error; ?></p>

        <!-- ✅ Borrow Requests Table -->
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
                        <td>" . htmlspecialchars($row['title']) . "</td>
                        <td>" . htmlspecialchars($row['author']) . "</td>
                        <td>" . htmlspecialchars($row['isbn']) . "</td>
                        <td>" . htmlspecialchars($row['duration']) . "</td>
                        <td>" . htmlspecialchars($row['request_date']) . "</td>
                        <td>
                          <form method='POST' style='display:inline;'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <button type='submit' name='delete_btn' onclick=\"return confirm('Are you sure you want to delete this request?');\">Delete</button>
                          </form>
                        </td>
                      </tr>";
              }
            } else {
              echo "<tr><td colspan='6'>No borrow requests yet.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
