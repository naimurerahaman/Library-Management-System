<?php
include "config.php";
$success = $error = "";
$name = $email = $id = $phone = $gender = $age = "";
$nameErr = $emailErr = $phoneErr = $ageErr = "";

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

  if (empty($_POST["phone"])) {
    $phoneErr = "Phone is required";
  } else {
    $phone = test_input($_POST["phone"]);
    if (!preg_match("/^[0-9]{11}$/", $phone)) {
      $phoneErr = "Phone must be 11 digits";
    }
  }

  if (empty($_POST["age"])) {
    $ageErr = "Age is required";
  } else {
    $age = test_input($_POST["age"]);
    if (!is_numeric($age) || $age < 1 || $age > 120) {
      $ageErr = "Enter a valid age (1–120)";
    }
  }

  $gender = !empty($_POST["gender"]) ? test_input($_POST["gender"]) : "";
  $id = $_POST["id"];

  if (empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($ageErr)) {
    $sql = "INSERT INTO users (user_id, name, email, phone, gender, age) VALUES ('$id','$name','$email','$phone','$gender','$age')
                ON DUPLICATE KEY UPDATE name='$name', email='$email', phone='$phone', gender='$gender', age='$age'";
    if ($conn->query($sql) === TRUE) {
      $success = "Profile updated successfully";
    } else {
      $error = "Error: " . $conn->error;
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
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Profile</title>
  <link rel="stylesheet" href="../CSS/viewprofile.css" />
</head>

<body>
  <div class="navbar">
    <h2>WELCOME ! User Dashboard</h2>
    <div class="user-info">
      <span><?php echo !empty($name) ? $name : "Username"; ?></span>
      <button class="logout-btn">Logout</button>
    </div>
  </div>

  <div class="container-sidebar">
    <div class="sidebar">
      <a href="profile.php" class="active">View Profile</a>
      <a href="searchbook.php">Search Book</a>
      <a href="viewborrowbook.php">View Borrow Book</a>
      <a href="borrow.php">Borrow Book Request</a>
      <a href="returnbook.php">Return Book</a>
      <a href="feedback.php">Feedback</a>
    </div>

    <div class="profile-card">
      <h2>User Profile</h2>
      <form method="post" action="">
        <div class="profile-field">
          <label>Name</label>
          <input type="text" name="name" value="<?php echo $name; ?>" />
          <span style="color:red"><?php echo $nameErr; ?></span>
        </div>

        <div class="profile-field">
          <label>Email</label>
          <input type="email" name="email" value="<?php echo $email; ?>" />
          <span style="color:red"><?php echo $emailErr; ?></span>
        </div>

        <div class="profile-field">
          <label>User ID</label>
          <input type="text" name="id" value="<?php echo !empty($id) ? $id : "S-1001"; ?>" readonly />
        </div>

        <div class="profile-field">
          <label>Phone</label>
          <input type="text" name="phone" value="<?php echo $phone; ?>" />
          <span style="color:red"><?php echo $phoneErr; ?></span>
        </div>

        <div class="profile-field">
          <label>Gender</label>
          <select name="gender">
            <option value="male" <?php if ($gender == "male")
              echo "selected"; ?>>Male</option>
            <option value="female" <?php if ($gender == "female")
              echo "selected"; ?>>Female</option>
            <option value="other" <?php if ($gender == "other")
              echo "selected"; ?>>Other</option>
          </select>
        </div>

        <div class="profile-field">
          <label>Age</label>
          <input type="number" name="age" value="<?php echo $age; ?>" />
          <span style="color:red"><?php echo $ageErr; ?></span>
        </div>

        <button class="btn" type="submit">Save Changes</button>
        <div style="color:green"><?php echo $success; ?></div>
        <div style="color:red"><?php echo $error; ?></div>
      </form>
    </div>
  </div>
</body>

</html>