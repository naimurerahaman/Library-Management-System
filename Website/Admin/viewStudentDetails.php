<?php
include "config.php"; 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$students = $conn->query("SELECT id, fullname, email FROM register ORDER BY fullname ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['issue_id'])) {
    $issue_id = $_POST['issue_id'];
    $new_status = "";
    $return_date = null;

    if (isset($_POST['mark_returned'])) {
        $new_status = 'returned';
        $return_date = date("Y-m-d");
    } elseif (isset($_POST['mark_not_returned'])) {
        $new_status = 'borrowed';
        $return_date = NULL;
    }
    
    $stmt = $conn->prepare("UPDATE issued_books SET status = ?, return_date = ? WHERE id = ?");
    $stmt->bind_param("ssi", $new_status, $return_date, $issue_id);
    $stmt->execute();
    $stmt->close();
    
    header("Location: viewStudentDetails.php?student_id=" . $_POST['student_id']);
    exit();
}

$studentData = null;
$issuedBooks = null;
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    $stmt_student = $conn->prepare("SELECT * FROM register WHERE id = ?");
    $stmt_student->bind_param("i", $student_id);
    $stmt_student->execute();
    $studentData = $stmt_student->get_result()->fetch_assoc();
    $stmt_student->close();

    $sql_issued = "SELECT ib.id, b.bookName, ib.issue_date, ib.return_date, ib.status 
                   FROM issued_books ib
                   JOIN book b ON ib.book_id = b.id
                   WHERE ib.student_id = ?";
    $stmt_issued = $conn->prepare($sql_issued);
    $stmt_issued->bind_param("i", $student_id);
    $stmt_issued->execute();
    $issuedBooks = $stmt_issued->get_result();
    $stmt_issued->close();
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
        <a href="viewStudentDetails.php" class="active">View Student Details</a>
        <a href="changePassAdmin.php">Change Password</a>
    </div>

    <div class="content">
        <h2>View Student Details</h2>

        <form method="GET">
            <label for="student">Select Student:</label>
            <select name="student_id" required onchange="this.form.submit()">
                <option value="">-- Select Student --</option>
                <?php while ($row = $students->fetch_assoc()) { ?>
                    <option value="<?php echo htmlspecialchars($row['id']); ?>" 
                        <?php if (isset($_GET['student_id']) && $_GET['student_id'] == $row['id']) echo "selected"; ?>>
                        <?php echo htmlspecialchars($row['fullname']) . " (" . htmlspecialchars($row['email']) . ")"; ?>
                    </option>
                <?php } ?>
            </select>
        </form>

        <?php if ($studentData) { ?>
            <h3>Student Information</h3>
            <p><b>Name:</b> <?php echo htmlspecialchars($studentData['fullname']); ?></p>
            <p><b>Email:</b> <?php echo htmlspecialchars($studentData['email']); ?></p>

            <h3>Issued Books</h3>
            <table border="1" cellpadding="8" cellspacing="0">
                <thead>
                    <tr>
                        <th>Book Name</th>
                        <th>Issue Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($issuedBooks->num_rows > 0) {
                        while ($row = $issuedBooks->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['bookName']); ?></td>
                                <td><?php echo htmlspecialchars($row['issue_date']); ?></td>
                                <td><?php echo $row['return_date'] ? htmlspecialchars($row['return_date']) : "-"; ?></td>
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
                                            <input type="hidden" name="issue_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">
                                            <button type="submit" name="mark_returned" style="background:green;color:white;">Mark as Returned</button>
                                        </form>
                                    <?php } else { ?>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="issue_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">
                                            <button type="submit" name="mark_not_returned" style="background:orange;color:white;">Mark as Not Returned</button>
                                        </form>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo "<tr><td colspan='5'>No issued books found for this student.</td></tr>";
                    } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
    <script src="../JS/sideBar.js"></script>
</body>
</html>