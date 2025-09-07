<?php
include "config.php";
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ✅ Check if login is admin
    $adminCheck = "SELECT * FROM adminpass WHERE email='$email' AND password='$password'";
    $adminResult = $conn->query($adminCheck);

    if ($adminResult->num_rows > 0) {
        // ✅ Admin login success
        header("Location: adminHome.php");
        exit();
    } else {
        // ✅ Otherwise check normal users
        $userCheck = "SELECT * FROM register WHERE email='$email' AND password='$password'";
        $userResult = $conn->query($userCheck);

        if ($userResult->num_rows > 0) {
            $row = $userResult->fetch_assoc();
            $_SESSION['email'] = $row['email'];
            header("Location: userHome.php");
            exit();
        } else {
            $error = "Invalid email or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Library Login</title>
  <link rel="stylesheet" href="../CSS/login.css">
</head>
<body>
  <nav class="navbar">
    <a href="home.php">Home</a>
    <a href="book.php">Books</a>
    <a href="category.php">Category</a>
    <a href="request.php">Request Book</a>
  </nav>  

  <div class="login-container">
    <h2>Login</h2>

    <form action="login.php" method="post">
      <label for="email">Email*</label>
      <input type="email" id="email" name="email" placeholder="Enter your email">

      <label for="password">Password*</label>
      <input type="password" id="password" name="password" placeholder="Enter your password">

      <input type="submit" value="Login" class="btn" name="signIn">

      <p class="error"><?php echo $error; ?></p>

      <div class="extra-links">
        <a href="#">Forgot password?</a><br>
        <span>Don't have an account? <a href="register.php">Register</a></span>
      </div>
    </form>
  </div>
</body>
</html>
