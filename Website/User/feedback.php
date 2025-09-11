<?php
include "config.php";

$name = $email = $rating = $category = $message = "";
$nameErr = $emailErr = $ratingErr = $categoryErr = $messageErr = "";
$success = $error = "";

include "config.php";
session_start();
$success = $error = "";
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
$name = $_SESSION['username'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and spaces allowed";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["rating"])) {
        $ratingErr = "Rating is required";
    } else {
        $rating = test_input($_POST["rating"]);
    }

    if (empty($_POST["category"])) {
        $categoryErr = "Category is required";
    } else {
        $category = test_input($_POST["category"]);
    }

    if (empty($_POST["message"])) {
        $messageErr = "Message is required";
    } else {
        $message = test_input($_POST["message"]);
    }

    if (empty($nameErr) && empty($emailErr) && empty($ratingErr) && empty($categoryErr) && empty($messageErr)) {
        $sql = "INSERT INTO feedback (name, email, rating, category, message) 
                VALUES ('$name', '$email', '$rating', '$category', '$message')";

        if ($conn->query($sql) === TRUE) {
            $success = "✅ Feedback submitted successfully!";
            $name = $email = $rating = $category = $message = "";
        } else {
            $error = "❌ Error: " . $conn->error;
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>User Feedback</title>
    <link rel="stylesheet" href="../CSS/feedback.css">
</head>

<body>
    <div class="navbar">
  <h2>WELCOME <span><?php echo !empty($name) ? $name : "username"; ?></span> !</h2>
  <div class="user-info">
    <span><?php echo !empty($name) ? $name : "username"; ?></span>
    <a href="logout.php" class="btn-logout"><button>Log Out</button></a>
  </div>
</div>
  <div class="container-sidebar">
    <div class="sidebar">
      <a href="userdashboard.php" >Dashboard</a>
      <a href="editprofile.php" >Edit Profile</a>
      <a href="searchbook.php">Search Book</a>
      <a href="viewborrowbook.php">View Borrow Book</a>
      <a href="borrow.php">Borrow Book Request</a>
      <a href="returnbook.php">Return Book</a>
      <a href="feedback.php">Feedback</a>
    </div>

    <form method="post" action="">
        <h3>Please provide your feedback below:</h3>
        <div class="container">
            <label>Your Name</label><br>
            <input type="text" name="name" value="<?php echo $name; ?>">
            <span class="error">* <?php echo $nameErr; ?></span>
            <br><br>

            <label>Email</label><br>
            <input type="text" name="email" value="<?php echo $email; ?>">
            <span class="error">* <?php echo $emailErr; ?></span>
            <br><br>

            <label>Feedback Rating</label><br>
            <select name="rating">
                <option value="">Select a rating</option>
                <option value="excellent" <?php if ($rating == "excellent")
                    echo "selected"; ?>>Excellent</option>
                <option value="good" <?php if ($rating == "good")
                    echo "selected"; ?>>Good</option>
                <option value="average" <?php if ($rating == "average")
                    echo "selected"; ?>>Average</option>
                <option value="poor" <?php if ($rating == "poor")
                    echo "selected"; ?>>Poor</option>
            </select>
            <span class="error">* <?php echo $ratingErr; ?></span>
            <br><br>

            <label>Feedback Category</label><br>
            <select name="category">
                <option value="">Select a category</option>
                <option value="website" <?php if ($category == "website")
                    echo "selected"; ?>>Website</option>
                <option value="service" <?php if ($category == "service")
                    echo "selected"; ?>>Service</option>
                <option value="content" <?php if ($category == "content")
                    echo "selected"; ?>>Content</option>
                <option value="other" <?php if ($category == "other")
                    echo "selected"; ?>>Other</option>
            </select>
            <span class="error">* <?php echo $categoryErr; ?></span>
            <br><br>

            <label>Your Message</label><br>
            <textarea name="message" rows="5"><?php echo $message; ?></textarea>
            <span class="error">* <?php echo $messageErr; ?></span>
            <br><br>

            <button type="submit" class="btn">Submit Feedback</button>
        </div>
    </form>

    <p class="success"><?php echo $success; ?></p>
    <p class="error"><?php echo $error; ?></p>
</body>

</html>