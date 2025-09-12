<?php
include "config.php";
session_start();

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $book_id = $_POST['book_id'];
    $sql = "INSERT INTO borrow (user_id, book_id, status) VALUES ('$student_id', '$book_id', 'borrowed')";
    if ($conn->query($sql) === TRUE) {
        $message = "Book issued successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
$students = $conn->query("SELECT id, fullname FROM register");
$books = $conn->query("SELECT id, title FROM books");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Issue Book</title>
    <link rel="stylesheet" href="../CSS/sideBar.css">
    <link rel="stylesheet" href="../CSS/adminIssueBook.css">
</head>

<body>
    <div class="logout">
        <a href="logout.php" class="btn-logout"><button>Log Out</button></a>
    </div>

    <div class="sidebar">
        <a href="adminHome.php">Dashboard</a>
        <div class="dropdown">
            <a href="#" class="dropdown-btn">Books</a>
            <div class="dropdown-content">
                <a href="addBook.php">Add Book</a>
                <a href="manageBook.php">Manage Book</a>
            </div>
        </div>
        <div class="dropdown">
            <a href="#" class="dropdown-btn">Categories & Authors</a>
            <div class="dropdown-content">
                <a href="addCategoryAuthor.php">Add</a>
                <a href="manageCategoryAuthor.php">Manage</a>
            </div>
        </div>
        <a href="adminIssueBook.php">Issue Books</a>
        <a href="viewStudentDetails.php">View Student Details</a>
        <a href="changePassAdmin.php">Change Password</a>
    </div>

    <div class="content">
        <h2>Issue a Book</h2>
        <form method="POST">
            <label for="student">Select Student:</label>
            <select name="student_id" required>
                <option value="">-- Select Student --</option>
                <?php while ($row = $students->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['fullname']; ?></option>
                <?php } ?>
            </select>

            <label for="book">Select Book:</label>
            <select name="book_id" required>
                <option value="">-- Select Book --</option>
                <?php while ($row = $books->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                <?php } ?>
            </select>

            <button type="submit">Issue Book</button>
        </form>

        <p style="color: green;"><?php echo $message; ?></p>
    </div>
    <script src="../JS/sideBar.js"></script>
</body>

</html>