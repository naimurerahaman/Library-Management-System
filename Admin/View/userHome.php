<?php
session_start();
include("config.php");

// CHANGED: redirect if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email']; // CHANGED: use session email
$fullname = "";

// CHANGED: get fullname from DB (simple)
$q = mysqli_query($conn, "SELECT fullname FROM register WHERE email='$email' LIMIT 1");
if ($q && mysqli_num_rows($q) === 1) {
    $row = mysqli_fetch_assoc($q);
    $fullname = $row['fullname'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Home - Library Management System</title>
</head>
<body>
    <div style="text-align: center;">
        <p>
            <!-- CHANGED: show both email and full name -->
            Hello, <?php echo htmlspecialchars($fullname !== "" ? $fullname : $email); ?>
        </p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
