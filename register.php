<?php
include "config.php";

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST["username"] ?? '');
  $fullname = trim($_POST["fullname"] ?? '');
  $password = $_POST["password"] ?? '';
  $email = trim($_POST["email"] ?? '');
  $phone = trim($_POST["phone"] ?? '');
  $gender = $_POST["gender"] ?? '';
  $age = $_POST["age"] ?? '';


  if ($username === '' || $fullname === '' || $password === '' || $email === '' || $phone === '' || $gender === '' || $age === '') {
    $error = "All fields are required!";
  } elseif (strlen($password) < 6) {
    $error = "Password must be at least 6 characters long.";
  } elseif ($username !== strtolower($username)) {
    $error = "Username must be in lowercase.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format.";
  } elseif (!preg_match("/^[0-9]{11}$/", $phone)) {
    $error = "Phone must be 11 digits.";
  } elseif (!is_numeric($age) || $age < 1 || $age > 120) {
    $error = "Enter a valid age (1–120).";
  } else {

    $checkEmail = "SELECT id FROM register WHERE email='$email' LIMIT 1";
    $res = $conn->query($checkEmail);
    if ($res && $res->num_rows > 0) {
      $error = "Email already exists!";
    } else {

      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      $sql = "INSERT INTO register (username, fullname, email, phone, gender, age, password) 
                    VALUES ('$username', '$fullname', '$email', '$phone', '$gender', '$age', '$hashedPassword')";
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
  <link rel="stylesheet" href="CSS/register.css">
</head>

<body>
  <nav class="navbar">
    <a href="index.html">Home</a>
  </nav>

  <div class="register-container">
    <h1>Register</h1>
    <form action="register.php" method="POST" class="register-form">
      <label>Username*</label>
      <input type="text" name="username" placeholder="lowercase only"
        value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">

      <label>Full Name*</label>
      <input type="text" name="fullname" value="<?php echo isset($fullname) ? htmlspecialchars($fullname) : ''; ?>">

      <label>Password*</label>
      <input type="password" name="password">

      <label>Email*</label>
      <input type="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">

      <label>Phone*</label>
      <input type="text" name="phone" placeholder="11 digit phone"
        value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>">

      <label>Gender*</label>
      <select name="gender">
        <option value="">Select</option>
        <option value="male" <?php if (isset($gender) && $gender == "male")
                                echo "selected"; ?>>Male</option>
        <option value="female" <?php if (isset($gender) && $gender == "female")
                                  echo "selected"; ?>>Female</option>
        <option value="other" <?php if (isset($gender) && $gender == "other")
                                echo "selected"; ?>>Other</option>
      </select>

      <label>Age*</label>
      <input type="number" name="age" value="<?php echo isset($age) ? htmlspecialchars($age) : ''; ?>">

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