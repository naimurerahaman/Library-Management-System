<?php
session_start();
include "config.php";
$message = "";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$name = $_SESSION['fullname'] ?? $_SESSION['username'];
$user_id = $_SESSION['user_id'];


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['return'])) {
    $borrow_id = $_POST['borrow_id'];
    $return_date = date("Y-m-d");


    $stmt = $conn->prepare("UPDATE borrow 
                            SET status = 'returned', return_date = ? 
                            WHERE id = ? AND user_id = ? AND status = 'borrowed'");
    $stmt->bind_param("sii", $return_date, $borrow_id, $user_id);

    if ($stmt->execute()) {
        $message = "✅ Book has been successfully returned!";
    } else {
        $message = "❌ Error returning book: " . $stmt->error;
    }
    $stmt->close();
}


$sql = "SELECT br.id, br.borrow_date, b.title, b.isbn, b.author, b.category
        FROM borrow br
        JOIN books b ON br.book_id = b.id
        WHERE br.user_id = ? AND br.status = 'borrowed'
        ORDER BY br.borrow_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Borrowed Books</title>
    <link rel="stylesheet" href="../CSS/bar.css">
    <link rel="stylesheet" href="../CSS/viewborrowbook.css">
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
            <a href="search_book.php">Search Book</a>
            <a href="view_borrowed.php" class="active">View Borrow Book</a>
            <a href="borrow_history.php">Borrow History</a>
            <a href="feedback.php">Feedback</a>
        </div>
        <div class="main-content">
            <h2>My Borrowed Books</h2>

            <table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>ISBN</th>
                        <th>Borrow Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= htmlspecialchars($row['author']) ?></td>
                                <td><?= htmlspecialchars($row['category']) ?></td>
                                <td><?= htmlspecialchars($row['isbn']) ?></td>
                                <td><?= htmlspecialchars($row['borrow_date']) ?></td>


                                <td>
                                    <form method="post">
                                        <input type="hidden" name="borrow_id" value="<?= htmlspecialchars($row['id']) ?>">
                                        <button type="submit" name="return">Return</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">You have no borrowed books.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php if (!empty($message)): ?>
                <p class="message"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
        </div>

    </div>
</body>

</html>