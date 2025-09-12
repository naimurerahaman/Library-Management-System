<?php
include "config.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
$name = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
$message = "";

if (isset($_POST['return'])) {
    $issue_id = $_POST['issue_id'];
    $return_date = date("Y-m-d");

    $stmt = $conn->prepare("UPDATE issued_books SET status = 'returned', return_date = ? WHERE id = ? AND student_id = ?");
    $stmt->bind_param("sii", $return_date, $issue_id, $user_id);
    if ($stmt->execute()) {
        $message = "✅ Book returned successfully.";
    } else {
        $message = "❌ Error returning book: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Borrowed Books</title>
    <link rel="stylesheet" href="../CSS/viewborrowbook.css" />
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
            <a href="searchbook.php">Search Book</a>
            <a href="viewborrowbook.php" class="active">View Borrow Book</a>
            <a href="borrow.php">Borrow Book Request</a>
            <a href="returnbook.php">Return Book</a>
            <a href="feedback.php">Feedback</a>
        </div>
        <div class="main-content">
            <h3>Borrowed Books</h3>
            <p><?php echo htmlspecialchars($message); ?></p>
            <table>
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>ISBN</th>
                        <th>Issue Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT ib.id, b.bookName, b.bookNumber, ib.issue_date, a.authorName, c.categoryName
                            FROM issued_books ib
                            JOIN book b ON ib.book_id = b.id
                            JOIN author a ON b.authorId = a.id
                            JOIN category c ON b.categoryId = c.id
                            WHERE ib.student_id = ? AND ib.status = 'borrowed'";
                    
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['bookName']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['authorName']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['categoryName']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['bookNumber']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['issue_date']) . "</td>";
                            echo "<td>";
                            echo "<form method='post' onsubmit='return confirm(\"Are you sure you want to return this book?\");'>";
                            echo "<input type='hidden' name='issue_id' value='" . $row['id'] . "'>";
                            echo "<button type='submit' name='return'>Return</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No borrowed books found.</td></tr>";
                    }
                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>