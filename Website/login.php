<?php
include "config.php";
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // ✅ Admin login (plain text)
    $adminCheck = "SELECT * FROM adminpass WHERE email='$email' AND password='$password' LIMIT 1";
    $adminResult = $conn->query($adminCheck);

    if ($adminResult && $adminResult->num_rows > 0) {
        $_SESSION['admin_email'] = $email;
        header("Location: Admin/adminHome.php");
        exit();
    }

    // ✅ Normal user login
    $userCheck = "SELECT * FROM register WHERE email='$email' LIMIT 1";
    $userResult = $conn->query($userCheck);

    if ($userResult && $userResult->num_rows > 0) {
        $row = $userResult->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email']   = $row['email'];
            $_SESSION['username'] = $row['username'];

            header("Location: User/userdashboard.php");
            exit();
        } else {
            $error = "Invalid email or password!";
        }
    } else {
        $error = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="CSS/login.css">
</head>
<body>
  <nav class="navbar">
    <a href="index.php">Home</a>
    <a href="book.php">Books</a>
    <a href="category.php">Category</a>
    <a href="request.php">Request Book</a>
  </nav>  

  <div class="login-container">
    <h2>Login</h2>

    <form method="post">
      <label>Email*</label>
      <input type="email" name="email" placeholder="Enter your email" required>

      <label>Password*</label>
      <input type="password" name="password" placeholder="Enter your password" required>

      <input type="submit" value="Login" class="btn">

      <p class="error"><?php echo $error; ?></p>

      <div class="extra-links">
        <a href="#">Forgot password?</a><br>
        <span>Don't have an account? <a href="register.php">Register</a></span>
      </div>
    </form>
  </div>
</body>
</html>
