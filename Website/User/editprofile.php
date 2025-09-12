<?php
include "../config.php";
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = trim($_POST["fullname"]);
  $phone = trim($_POST["phone"]);
  $gender = trim($_POST["gender"]);
  $age = trim($_POST["age"]);

  if ($fullname === '' || $phone === '' || $age === '') {
    $error = "All fields are required!";
  } elseif (!preg_match("/^[0-9]{11}$/", $phone)) {
    $error = "Phone must be 11 digits.";
  } elseif (!is_numeric($age) || $age < 1 || $age > 120) {
    $error = "Invalid age.";
  } else {
    $sql = "UPDATE register 
                SET fullname='$fullname', phone='$phone', gender='$gender', age='$age'
                WHERE id='$user_id'";
    if ($conn->query($sql) === TRUE) {
      $success = "Profile updated successfully!";
    } else {
      $error = "Database error: " . $conn->error;
    }
  }
}

// Load existing user data
$result = $conn->query("SELECT * FROM register WHERE id='$user_id' LIMIT 1");
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>

<head>
  <title>Edit Profile</title>
  <link rel="stylesheet" href="../CSS/bar.css">
  <link rel="stylesheet" href="../CSS/editprofile.css">
</head>

<body>
  <div class="navbar">
    <h2>WELCOME <span><?php echo htmlspecialchars($_SESSION['username']); ?></span> !</h2>
    <div class="user-info">
      <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
      <a href="logout.php" class="btn-logout"><button>Log Out</button></a>
    </div>
  </div>
  <div class="container-sidebar">
    <div class="sidebar">
      <a href="userdashboard.php">Dashboard</a>
      <a href="editprofile.php" class="active">Edit Profile</a>
      <a href="search_book.php">Search Book</a>
      <a href="view_borrowed.php">View Borrow Book</a>
      <a href="borrow_history.php">Borrow History</a>
      <a href="feedback.php">Feedback</a>
    </div>

    <div class="profile-card">
      <h2>Edit Profile</h2>
      <form method="post">
        <label>Full Name</label>
        <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>">

        <label>Phone</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">

        <label>Gender</label>
        <select name="gender">
          <option value="male" <?php if ($user['gender'] == 'male')
            echo "selected"; ?>>Male</option>
          <option value="female" <?php if ($user['gender'] == 'female')
            echo "selected"; ?>>Female</option>
          <option value="other" <?php if ($user['gender'] == 'other')
            echo "selected"; ?>>Other</option>
        </select>

        <label>Age</label>
        <input type="number" name="age" value="<?php echo htmlspecialchars($user['age'] ?? ''); ?>">

        <button type="submit">Save Changes</button>
      </form>
      <p style="color:green"><?php echo $success; ?></p>
      <p style="color:red"><?php echo $error; ?></p>
    </div>
  </div>
</body>

</html>