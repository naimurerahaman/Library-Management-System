<?php
session_start();
include "config.php";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['forgot_password'])) {
    $email = $_POST['email'];

    
    $stmt = $conn->prepare("SELECT id FROM register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];

        
        $token = bin2hex(random_bytes(32)); 
        $expires_at = date("Y-m-d H:i:s", strtotime('+1 hour')); 

        
        
        $insert_stmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
        $insert_stmt->bind_param("iss", $user_id, $token, $expires_at);
        $insert_stmt->execute();

        
        $reset_link = "http://localhost/Library-Management-System/Website/User/resetPassword.php?token=" . $token;

        
        
        $message = "<p style='color:green;'>Password reset link has been sent to your email. (For this example, the link is: <a href='$reset_link'>$reset_link</a>)</p>";
        
        $insert_stmt->close();

    } else {
        $message = "<p style='color:red;'>Email not found.</p>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../CSS/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Forgot Password</h2>
        <p>Enter your email to receive a password reset link.</p>
        <div class="message"><?php echo $message; ?></div>
        <form method="post" action="forgetPass.php">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <button type="submit" name="forgot_password">Send Reset Link</button>
        </form>
        <a href="../login.php">Back to Login</a>
    </div>
</body>
</html>