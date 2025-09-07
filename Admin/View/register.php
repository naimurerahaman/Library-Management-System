<?php
include "config.php";

$success = $error = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = $_POST["username"] ?? '';
    $fullname = $_POST["fullname"] ?? '';
    $password = $_POST["password"] ?? '';
    $email    = $_POST["email"] ?? '';

    if ($username==='' || $fullname==='' || $password==='' || $email==='') {
        $error = "All fields are required!";
    }
    elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    }
    elseif ($username !== strtolower($username)) {
        $error = "Username must be in lowercase.";
    }
    elseif (strpos($email, '@') === false || strpos($email, '.') === false) {
        $error = "Invalid email format.";
    }
    else {
        $checkEmail = "SELECT id FROM register WHERE email='$email' LIMIT 1";  
        $res = $conn->query($checkEmail);
        if ($res && $res->num_rows > 0) {
            $error = "Email already exists!";
        } else {
            $sql = "INSERT INTO register (username, fullname, password, email) 
                    VALUES ('$username', '$fullname', '$password', '$email')";
            if ($conn->query($sql) === TRUE) {
                $success = "Registration Successful! Now you can login.";
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" href="../CSS/register.css">
</head>
<body>
  <nav class="navbar">
    <a href="home.php">Home</a>
    <a href="book.php">Books</a>
    <a href="category.php">Category</a>
    <a href="request.php">Request Book</a>
  </nav>

  <div class="register-container">
    <h1>Register</h1>
    <p class="subtitle">Get access to unlimited download of free ebook</p>

    <form action="register.php" method="POST" class="register-form">
      <label>Username*</label>
      <input type="text" name="username" placeholder="lowercase only" value="<?php echo isset($username)?htmlspecialchars($username):''; ?>">

      <label>Full Name*</label>
      <input type="text" name="fullname" placeholder="enter your full name" value="<?php echo isset($fullname)?htmlspecialchars($fullname):''; ?>">

      <label>Password*</label>
      <input type="password" name="password" placeholder="at least 6 characters">

      <label>Email*</label>
      <input type="email" name="email" placeholder="example: xyz@gmail.com" value="<?php echo isset($email)?htmlspecialchars($email):''; ?>">

      <input type="submit" value="Register" class="register-btn" name="signUp">
    </form>

    <p class="login-text">
      Have an account? <a href="login.php">Login</a>
    </p>

    <p class="success"><?php echo $success; ?></p>
    <p class="error"><?php echo $error; ?></p>
  </div>
</body>
</html>
