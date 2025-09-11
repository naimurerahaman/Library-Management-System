<?php
include "config.php";

if (!isset($_GET['id'])) {
    die("Student ID not provided.");
}

$student_id = $_GET['id'];

// Fetch student info
$student_sql = "SELECT * FROM register WHERE id='$student_id'";
$student_result = $conn->query($student_sql);
$student = $student_result->fetch_assoc();

// Update student info
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $status = $_POST['status'];

    // Update register table
    $update_sql = "UPDATE register SET fullname='$fullname', email='$email' WHERE id='$student_id'";
    $conn->query($update_sql);

    // Update borrow_requests status
    $update_status_sql = "UPDATE borrow_requests SET status='$status' WHERE student_id='$student_id'";
    $conn->query($update_status_sql);

    header("Location: viewStudentDetails.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="../CSS/editStudent.css">
</head>
<body>
<div class="container">
    <h2>Edit Student</h2>
    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="fullname" value="<?php echo $student['fullname']; ?>">

        <label>Email</label>
        <input type="email" name="email" value="<?php echo $student['email']; ?>">

        <label>Status</label>
        <select name="status">
            <option value="borrowed">Borrowed</option>
            <option value="returned">Returned</option>
        </select>

        <button type="submit">Update</button>
    </form>
</div>
</body>
</html>
