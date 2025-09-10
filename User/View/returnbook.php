<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Return Book</title>
  <link rel="stylesheet" href="../CSS/returnbook.css" />
</head>

<body>
  <div class="navbar">
    <h2>WELCOME ! User Dashboard</h2>
    <div class="user-info">
      <span>Username</span>
      <button class="logout-btn">Logout</button>
    </div>
  </div>

  <div class="container">
    <div class="sidebar">
      <a href="viewprofile.php">View Profile</a>
      <a href="searchbook.php">Search Book</a>
      <a href="borrow.php">Borrow Book Request</a>
      <a href="returnbook.php">Return Book</a>
      <a href="feedback.php">Feedback</a>
    </div>

    <div class="main-content">
      <div class="return-card">
        <h2>Return Book</h2>
        <form>
          <div class="form-field">
            <label for="title">Book Title</label>
            <input type="text" id="title" placeholder="Enter book title" />
          </div>

          <div class="form-field">
            <label for="author">Author</label>
            <input type="text" id="author" placeholder="Enter author name" />
          </div>

          <div class="form-field">
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" placeholder="Enter book ISBN" />
          </div>

          <div class="form-field">
            <label for="date">Return Date</label>
            <input type="date" id="date" />
          </div>

          <button type="submit" class="btn">Return Book</button>
        </form>
      </div>
    </div>
  </div>
</body>

</html>