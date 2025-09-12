<?php
include "config.php";
session_start();
$success = $error = "";
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
$name = $_SESSION['fullname'] ?? $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["borrow"])) {
    $book_id = $_POST["book_id"];
    $user_id = $_SESSION['user_id'];
    $issue_date = date("Y-m-d");

    if (empty($book_id)) {
        $error = "Book details are missing.";
    } else {
        $check_stmt = $conn->prepare("SELECT COUNT(*) FROM issued_books WHERE student_id = ? AND book_id = ? AND status = 'borrowed'");
        $check_stmt->bind_param("ii", $user_id, $book_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $is_borrowed = $check_result->fetch_row()[0] > 0;
        $check_stmt->close();

        if ($is_borrowed) {
            $error = "❌ You have already borrowed this book.";
        } else {
            $stmt = $conn->prepare("INSERT INTO issued_books (student_id, book_id, issue_date) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $user_id, $book_id, $issue_date);

            if ($stmt->execute()) {
                $success = "✅ Book Borrow Request Sent Successfully.";
            } else {
                $error = "❌ Error: " . $stmt->error;
            }
            $stmt->close();
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
        <h2>WELCOME <span><?php echo htmlspecialchars($name); ?></span> !</h2>
        <div class="user-info">
            <span><?php echo htmlspecialchars($name); ?></span>
            <a href="logout.php" class="btn-logout"><button>Log Out</button></a>
        </div>
    </div>
    <div class="container-sidebar">
        <div class="sidebar">
            <a href="userdashboard.php">Dashboard</a>
            <a href="editprofile.php">Edit Profile</a>
            <a href="searchbook.php" class="active">Search Book</a>
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
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <div class="book-list" id="bookList">
                <?php
                $sql_books = "SELECT b.id, b.bookName, b.bookNumber, a.authorName, c.categoryName 
                              FROM book b
                              JOIN author a ON b.authorId = a.id
                              JOIN category c ON b.categoryId = c.id
                              ORDER BY b.bookName ASC";
                $result_books = $conn->query($sql_books);
                
                if ($result_books->num_rows > 0) {
                    while ($row = $result_books->fetch_assoc()) {
                        echo '<div class="book">';
                        echo '<div class="title">' . htmlspecialchars($row['bookName']) . '</div>';
                        echo '<div class="author">' . htmlspecialchars($row['authorName']) . '</div>';
                        echo '<div class="category">' . htmlspecialchars($row['categoryName']) . '</div>';
                        echo '<div class="isbn">' . htmlspecialchars($row['bookNumber']) . '</div>';
                        echo '<form method="post" action="">';
                        echo '<input type="hidden" name="book_id" value="' . htmlspecialchars($row['id']) . '">';
                        echo '<button type="submit" name="borrow" class="borrow-btn">Borrow</button>';
                        echo '</form>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No books found in the library.</p>";
                }
                ?>
            </div>
        </div>
    </div>
    <script src="../Js/searchbook.js"></script>
</body>
</html>