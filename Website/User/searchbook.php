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
    $book_title = $_POST["book_title"];
    $book_author = $_POST["book_author"];
    $book_category = $_POST["book_category"];
    $book_isbn = $_POST["book_isbn"];
    if (empty($book_title) || empty($book_author) || empty($book_category) || empty($book_isbn)) {
        $error = "Book details are missing.";
    } else {
        $stmt = $conn->prepare("INSERT INTO borrow (title, author, category, isbn) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $book_title, $book_author, $book_category, $book_isbn);

        if ($stmt->execute()) {
            $success = "✅ Book Borrow Request Sent Successfully.";
        } else {
            $error = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
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
                $sql_books = "SELECT * FROM book ORDER BY bookName ASC";
                $result_books = $conn->query($sql_books);
                
                if ($result_books->num_rows > 0) {
                    while ($row = $result_books->fetch_assoc()) {
                        // Fetch the author's name using authorId
                        $author_query = $conn->prepare("SELECT authorName FROM author WHERE id = ?");
                        $author_query->bind_param("i", $row['authorId']);
                        $author_query->execute();
                        $author_result = $author_query->get_result();
                        $author_name = $author_result->fetch_assoc()['authorName'] ?? 'Unknown Author';
                        $author_query->close();
                        
                        // Fetch the category name using categoryId
                        $category_query = $conn->prepare("SELECT categoryName FROM category WHERE id = ?");
                        $category_query->bind_param("i", $row['categoryId']);
                        $category_query->execute();
                        $category_result = $category_query->get_result();
                        $category_name = $category_result->fetch_assoc()['categoryName'] ?? 'Unknown Category';
                        $category_query->close();

                        echo '<div class="book">';
                        echo '<div class="title">' . htmlspecialchars($row['bookName']) . '</div>';
                        echo '<div class="author">' . htmlspecialchars($author_name) . '</div>';
                        echo '<div class="category">' . htmlspecialchars($category_name) . '</div>';
                        echo '<div class="isbn">' . htmlspecialchars($row['bookNumber']) . '</div>';
                        echo '<form method="post" action="">';
                        echo '<input type="hidden" name="book_title" value="' . htmlspecialchars($row['bookName']) . '">';
                        echo '<input type="hidden" name="book_author" value="' . htmlspecialchars($author_name) . '">';
                        echo '<input type="hidden" name="book_category" value="' . htmlspecialchars($category_name) . '">';
                        echo '<input type="hidden" name="book_isbn" value="' . htmlspecialchars($row['bookNumber']) . '">';
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