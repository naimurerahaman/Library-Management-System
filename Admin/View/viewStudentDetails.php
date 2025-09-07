<?php
session_start();
include "config.php"; 


if (isset($_GET['delete'])) {
    $studentId = $_GET['delete'];
    $conn->query("DELETE FROM register WHERE id=$studentId");
    header("Location: viewStudentDetails.php");
    exit();
}


if (isset($_GET['action']) && isset($_GET['borrow_id'])) {
    $action = $_GET['action'];
    $borrowId = $_GET['borrow_id'];

    if ($action == "accept") {
        $conn->query("UPDATE borrow SET status='accepted' WHERE id=$borrowId");
    } elseif ($action == "reject") {
        $conn->query("UPDATE borrow SET status='rejected' WHERE id=$borrowId");
    } elseif ($action == "returned") {
        $conn->query("UPDATE borrow SET status='returned' WHERE id=$borrowId");
    }
    header("Location: viewStudentDetails.php");
    exit();
}

$students = $conn->query("SELECT * FROM register");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Details</title>
    <link rel="stylesheet" href="../CSS/viewStudentDetails.css">
    <link rel="stylesheet" href="../CSS/sideBar.css">
</head>
<body>
    </div>    
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
    <div class="main-content">
        <h2>Student Details</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Borrowed Books</th>
            <th>Borrow Requests</th>
            <th>Actions</th>
        </tr>

        <?php while ($student = $students->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $student['id']; ?></td>
                <td><?php echo $student['fullname']; ?></td>
                <td><?php echo $student['email']; ?></td>
                <td>
                    <?php
                   
                    $sid = $student['id'];
                    $borrowed = $conn->query("SELECT borrow.*, book.bookName FROM borrow 
                                               JOIN book ON borrow.book_id = book.id 
                                               WHERE borrow.student_id=$sid AND borrow.status IN ('accepted','returned')");
                    if ($borrowed->num_rows > 0) {
                        while ($b = $borrowed->fetch_assoc()) {
                            echo $b['bookName'] . " - " . $b['status'] . "<br>";
                        }
                    } else {
                        echo "No borrowed books";
                    }
                    ?>
                </td>
                <td>
                    <?php
                  
                    $pending = $conn->query("SELECT borrow.*, book.bookName FROM borrow 
                                              JOIN book ON borrow.book_id = book.id 
                                              WHERE borrow.student_id=$sid AND borrow.status='pending'");
                    if ($pending->num_rows > 0) {
                        while ($p = $pending->fetch_assoc()) {
                            echo $p['bookName'] . " 
                                <a href='viewStudentDetails.php?action=accept&borrow_id=" . $p['id'] . "'>Accept</a> | 
                                <a href='viewStudentDetails.php?action=reject&borrow_id=" . $p['id'] . "'>Reject</a><br>";
                        }
                    } else {
                        echo "No requests";
                    }
                    ?>
                </td>
                <td>
                    <a href="viewStudentDetails.php?delete=<?php echo $student['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    </div>
    <script src="../JS/sideBar.js"></script>
</body>
</html>