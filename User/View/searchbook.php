<?php
include "config.php";
session_start();
$success = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["borrow"])) {
  $book_title = $_POST["book_title"];
  $book_author = $_POST["book_author"];
  $book_category = $_POST["book_category"];
  $book_isbn = $_POST["book_isbn"];
  if (empty($book_title) || empty($book_author) || empty($book_category) || empty($book_isbn)) {
    $error = "Book details are missing.";
  } else {
    $sql = "INSERT INTO borrow (title, author, category, isbn) 
                VALUES ('$book_title', '$book_author', '$book_category', '$book_isbn')";
    if ($conn->query($sql) === TRUE) {
      $success = "Book Borrow Request Sent Successfully.";
    } else {
      $error = "Error: " . $conn->error;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Search & Borrow</title>
  <link rel="stylesheet" href="../CSS/searchbook.css" />
</head>

<body>
  <div class="navbar">
    <h2>WELCOME ! User Dashboard</h2>
    <div class="user-info">
      <span>👤 Username</span>
      <button class="logout-btn">Logout</button>
    </div>
  </div>
  <div class="container">
    <div class="sidebar">
      <a href="viewprofile.php">View Profile</a>
      <a href="searchbook.php">Search Book</a>
      <a href="viewborrowbook.php">View Borrow Book</a>
      <a href="borrow.php">Borrow Book Request</a>
      <a href="returnbook.php">Return Book</a>
      <a href="feedback.php">Feedback</a>
    </div>
    <div class="main-content">
      <h1>Search & Borrow Books</h1>
      <div class="search-box">
        <input type="text" id="searchInput" placeholder="Search books..." />
        <button class="search-btn" id="searchBtn">Search</button>
      </div>
      <p class="success"><?php echo $success; ?></p>
      <p class="error"><?php echo $error; ?></p>
      <div class="book-list" id="bookList">
        <div class="book">
          <img src="https://covers.openlibrary.org/b/id/8231996-L.jpg" alt="Introduction to Algorithms" />
          <div class="title">Introduction to Algorithms</div>
          <div class="author">Thomas H. Cormen</div>
          <div class="category">CSE</div>
          <div class="isbn">9780262033848</div>
          <form method="post" action="">
            <input type="hidden" name="book_title" value="Introduction to Algorithms">
            <input type="hidden" name="book_author" value="Thomas H. Cormen">
            <input type="hidden" name="book_category" value="CSE">
            <input type="hidden" name="book_isbn" value="9780262033848">
            <button type="submit" name="borrow" class="borrow-btn">Borrow</button>
          </form>
        </div>
        <div class="book">
          <img src="https://covers.openlibrary.org/b/id/8108695-L.jpg" alt="Computer Networks" />
          <div class="title">Computer Networks</div>
          <div class="author">Andrew S. Tanenbaum</div>
          <div class="category">CSE</div>
          <div class="isbn">9780132126953</div>
          <form method="post" action="">
            <input type="hidden" name="book_title" value="Computer Networks">
            <input type="hidden" name="book_author" value="Andrew S. Tanenbaum">
            <input type="hidden" name="book_category" value="CSE">
            <input type="hidden" name="book_isbn" value="9780132126953">
            <button type="submit" name="borrow" class="borrow-btn">Borrow</button>
          </form>
        </div>
        <div class="book">
          <img src="https://covers.openlibrary.org/b/id/8234152-L.jpg" alt="Artificial Intelligence" />
          <div class="title">Artificial Intelligence</div>
          <div class="author">Stuart Russell</div>
          <div class="category">CSE</div>
          <div class="isbn">9780136042594</div>
          <form method="post" action="">
            <input type="hidden" name="book_title" value="Artificial Intelligence">
            <input type="hidden" name="book_author" value="Stuart Russell">
            <input type="hidden" name="book_category" value="CSE">
            <input type="hidden" name="book_isbn" value="9780136042594">
            <button type="submit" name="borrow" class="borrow-btn">Borrow</button>
          </form>
        </div>
        <div class="book">
          <img src="https://covers.openlibrary.org/b/id/8108701-L.jpg" alt="Database System Concepts" />
          <div class="title">Database System Concepts</div>
          <div class="author">Abraham Silberschatz</div>
          <div class="category">CSE</div>
          <div class="isbn">9780073523323</div>
          <form method="post" action="">
            <input type="hidden" name="book_title" value="Database System Concepts">
            <input type="hidden" name="book_author" value="Abraham Silberschatz">
            <input type="hidden" name="book_category" value="CSE">
            <input type="hidden" name="book_isbn" value="9780073523323">
            <button type="submit" name="borrow" class="borrow-btn">Borrow</button>
          </form>
        </div>
        <div class="book">
          <img src="https://covers.openlibrary.org/b/id/8226191-L.jpg" alt="Operating System Concepts" />
          <div class="title">Operating System Concepts</div>
          <div class="author">Silberschatz, Galvin, Gagne</div>
          <div class="category">CSE</div>
          <div class="isbn">9781118063330</div>
          <form method="post" action="">
            <input type="hidden" name="book_title" value="Operating System Concepts">
            <input type="hidden" name="book_author" value="Silberschatz, Galvin, Gagne">
            <input type="hidden" name="book_category" value="CSE">
            <input type="hidden" name="book_isbn" value="9781118063330">
            <button type="submit" name="borrow" class="borrow-btn">Borrow</button>
          </form>
        </div>
        <div class="book">
          <img src="https://covers.openlibrary.org/b/id/8312020-L.jpg" alt="Computer Organization and Design" />
          <div class="title">Computer Organization and Design</div>
          <div class="author">David A. Patterson</div>
          <div class="category">CSE</div>
          <div class="isbn">9780124077263</div>
          <form method="post" action="">
            <input type="hidden" name="book_title" value="Computer Organization and Design">
            <input type="hidden" name="book_author" value="David A. Patterson">
            <input type="hidden" name="book_category" value="CSE">
            <input type="hidden" name="book_isbn" value="9780124077263">
            <button type="submit" name="borrow" class="borrow-btn">Borrow</button>
          </form>
        </div>
        <div class="book">
          <img src="https://covers.openlibrary.org/b/id/8281991-L.jpg" alt="Clean Code" />
          <div class="title">Clean Code</div>
          <div class="author">Robert C. Martin</div>
          <div class="category">Programming</div>
          <div class="isbn">9780132350884</div>
          <form method="post" action="">
            <input type="hidden" name="book_title" value="Clean Code">
            <input type="hidden" name="book_author" value="Robert C. Martin">
            <input type="hidden" name="book_category" value="Programming">
            <input type="hidden" name="book_isbn" value="9780132350884">
            <button type="submit" name="borrow" class="borrow-btn">Borrow</button>
          </form>
        </div>
        <div class="book">
          <img src="https://covers.openlibrary.org/b/id/8312055-L.jpg" alt="Design Patterns" />
          <div class="title">Design Patterns</div>
          <div class="author">Erich Gamma</div>
          <div class="category">Programming</div>
          <div class="isbn">9780201633610</div>
          <form method="post" action="">
            <input type="hidden" name="book_title" value="Design Patterns">
            <input type="hidden" name="book_author" value="Erich Gamma">
            <input type="hidden" name="book_category" value="Programming">
            <input type="hidden" name="book_isbn" value="9780201633610">
            <button type="submit" name="borrow" class="borrow-btn">Borrow</button>
          </form>
        </div>
        <div class="book">
          <img src="https://covers.openlibrary.org/b/id/8235111-L.jpg" alt="The Pragmatic Programmer" />
          <div class="title">The Pragmatic Programmer</div>
          <div class="author">Andrew Hunt</div>
          <div class="category">Programming</div>
          <div class="isbn">9780201616224</div>
          <form method="post" action="">
            <input type="hidden" name="book_title" value="The Pragmatic Programmer">
            <input type="hidden" name="book_author" value="Andrew Hunt">
            <input type="hidden" name="book_category" value="Programming">
            <input type="hidden" name="book_isbn" value="9780201616224">
            <button type="submit" name="borrow" class="borrow-btn">Borrow</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="../Js/searchbook.js"></script>
</body>

</html>