<?php
session_start();
include "config.php";
$message = "";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $conn->prepare("SELECT user_id FROM password_resets WHERE token = ? AND expires_at > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password'])) {
            $new_password = $_POST['new_password'];
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);


            $update_stmt = $conn->prepare("UPDATE register SET password = ? WHERE id = ?");
            $update_stmt->bind_param("si", $hashed_password, $user_id);
            if ($update_stmt->execute()) {

                $delete_stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
                $delete_stmt->bind_param("s", $token);
                $delete_stmt->execute();

                $message = "<p style='color:green;'>Password has been reset successfully. You can now login.</p>";
            } else {
                $message = "<p style='color:red;'>Error updating password.</p>";
            }
            $update_stmt->close();
            $delete_stmt->close();
        }
    } else {
        $message = "<p style='color:red;'>Invalid or expired token.</p>";
    }
    $stmt->close();
} else {
    $message = "<p style='color:red;'>No token provided.</p>";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="../CSS/login.css">
</head>

<body>
    <div class="login-container">
        <h2>Reset Password</h2>
        <div class="message"><?php echo $message; ?></div>
        <?php if (isset($_GET['token']) && $result->num_rows > 0): ?>
            <form method="post" action="resetPassword.php?token=<?php echo htmlspecialchars($token); ?>">
                <div class="input-group">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password" required>
                </div>
                <button type="submit" name="reset_password">Reset Password</button>
            </form>
        <?php endif; ?>
        <a href="../login.php">Back to Login</a>
    </div>
</body>

</html>