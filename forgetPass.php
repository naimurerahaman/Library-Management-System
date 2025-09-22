<?php
session_start();
include "config.php";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['forgot_password'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $new_password = $_POST['new_password'];


    $stmt = $conn->prepare("SELECT id FROM register WHERE username = ? AND email = ? AND phone = ? AND age = ?");
    $stmt->bind_param("sssi", $username, $email, $phone, $age);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];


        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);


        $update_stmt = $conn->prepare("UPDATE register SET password = ? WHERE id = ?");
        $update_stmt->bind_param("si", $hashed_password, $user_id);

        if ($update_stmt->execute()) {
            $message = "<p style='color:green;'>Password has been reset successfully. You can now log in.</p>";
        } else {
            $message = "<p style='color:red;'>Error updating password.</p>";
        }
        $update_stmt->close();
    } else {
        $message = "<p style='color:red;'>The provided details do not match any user. Please try again.</p>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="CSS/home.css">
    <link rel="stylesheet" href="CSS/forget.css">

</head>

<body>
    <nav class="navbar">
        <a href="index.html">Home</a>
    </nav>

    <div class="container">
        <h2>Forgot Password</h2>
        <h3>You need to provide correct information to reset your password.</h3>
       
        <form method="post" action="forgetPass.php">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="Enter your username" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Enter your valid email" required>

            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" placeholder="Enter your valid phone number" required>

            <label for="age">Age:</label>
            <input type="number" name="age" id="age" placeholder="Enter your age" required>

            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" placeholder="Enter the new password" required>

            <button type="submit" name="forgot_password" class="submit-btn">Reset Password</button>
             <div class="message"><?php echo $message; ?></div>
        </form>
        <a class="link" href="login.php">Back to Login</a>
    </div>
</body>

</html>