<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Profile</title>

  <link rel=" stylesheet" href="../CSS/viewprofile.css" />
</head>

<body>
  <div class="navbar">
    <h2>WELCOME ! User Dashboard</h2>
    <div class="user-info">
      <span>Username</span>
      <button class="logout-btn">Logout</button>
    </div>
  </div>

  <div class="container-sidebar">
    <div class="sidebar">
      <a href="profile.php" class="active">View Profile</a>
      <a href="searchbook.php">Search Book</a>
      <a href="borrow.php">Borrow Book Request</a>
      <a href="returnbook.php">Return Book</a>
      <a href="feedback.php">Feedback</a>
    </div>

    <div class="profile-card">
      <h2>User Profile</h2>

      <div class="profile-field">
        <label>Name</label>
        <input type="text" id="name" value="Student Name" />
      </div>

      <div class="profile-field">
        <label>Email</label>
        <input type="email" id="email" value="student@example.com" />
      </div>

      <div class="profile-field">
        <label>User ID</label>
        <input type="text" id="id" value="S-1001" />
      </div>

      <div class="profile-field">
        <label>Phone</label>
        <input type="text" id="phone" value="01XXXXXXXXX" />
      </div>

      <div class="profile-field">
        <label>Gender</label>
        <select id="gender">
          <option value="male" selected>Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>
      </div>

      <div class="profile-field">
        <label>Age</label>
        <input type="number" id="age" value="20" />
      </div>

      <button class="btn">Save Changes</button>
    </div>
  </div>
</body>

</html>