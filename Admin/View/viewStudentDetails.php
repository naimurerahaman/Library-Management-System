<?php
include "config.php"; 
session_start();

// Fetch all students
$students = $conn->query("SELECT id, fullname, email FROM register");

// ✅ Handle Mark as Returned
if (isset($_POST['mark_returned'])) {
    $issue_id = $_POST['issue_id'];
    $today = date("Y-m-d");

    $conn->query("UPDATE issued_books SET status='returned', return_date='$today' WHERE id='$issue_id'");
}

// ✅ Handle Mark as Not Returned
if (isset($_POST['mark_not_returned'])) {
    $issue_id = $_POST['issue_id'];

    $conn->query("UPDATE issued_books SET status='borrowed', return_date=NULL WHERE id='$issue_id'");
}

// Check if a student is selected
$studentData = null;
$issuedBooks = null;
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    $studentData = $conn->query("SELECT * FROM register WHERE id='$student_id'")->fetch_assoc();

    $issuedBooks = $conn->query("
        SELECT ib.id, b.bookName, ib.issue_date, ib.return_date, ib.status 
        FROM issued_books ib
        JOIN book b ON ib.book_id = b.id
        WHERE ib.student_id = '$student_id'
    ");
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>View Student Details</title>
    <link rel="stylesheet" href="../CSS/sideBar.css">
    <link rel="stylesheet" href="../CSS/viewStudentDetails.css">
</head>
<body>
    <div class="logout">
        <a href="login.php" class="btn-logout"><button>Log Out</button></a>
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
            <a href="#" class="dropdown-btn">Categories</a>
            <div class="dropdown-content">
                <a href="addCategory.php">Add Category</a>
                <a href="manageCategory.php">Manage Category</a>
            </div>
        </div>
        <a href="adminIssueBook.php">Issue Books</a>
        <a href="viewStudentDetails.php">View Student Details</a>
        <a href="changePassAdmin.php">Change Password</a>
    </div>

    <div class="content">
        <h2>View Student Details</h2>

        <!-- Student selection dropdown -->
        <form method="GET">
            <label for="student">Select Student:</label>
            <select name="student_id" required>
                <option value="">-- Select Student --</option>
                <?php while ($row = $students->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>" 
                        <?php if (isset($student_id) && $student_id == $row['id']) echo "selected"; ?>>
                        <?php echo $row['fullname'] . " (" . $row['email'] . ")"; ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit">View</button>
        </form>

        <?php if ($studentData) { ?>
            <h3>Student Information</h3>
            <p><b>Name:</b> <?php echo $studentData['fullname']; ?></p>
            <p><b>Email:</b> <?php echo $studentData['email']; ?></p>

            <h3>Issued Books</h3>
            <table border="1" cellpadding="8" cellspacing="0">
                <tr>
                    <th>Book Name</th>
                    <th>Issue Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $issuedBooks->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['bookName']; ?></td>
                        <td><?php echo $row['issue_date']; ?></td>
                        <td><?php echo $row['return_date'] ? $row['return_date'] : "-"; ?></td>
                        <td>
                            <?php 
                                if ($row['status'] == "borrowed") {
                                    echo "<span style='color:red;'>Borrowed</span>";
                                } else {
                                    echo "<span style='color:green;'>Returned</span>";
                                }
                            ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == "borrowed") { ?>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="issue_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="mark_returned" style="background:green;color:white;">Mark as Returned</button>
                                </form>
                            <?php } 
                            else { ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="issue_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="mark_not_returned" style="background:orange;color:white;">Mark as Not Returned</button>
                                    </form>
                            <?php } ?>
                        </td>
                        
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    </div>
    <script src="../JS/sideBar.js"></script>
</body>
</html>
