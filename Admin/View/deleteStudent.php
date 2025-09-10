<?php
include "config.php"; 
session_start();

// ✅ Check if student_id is provided in URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Delete student from register table
    $sql = "DELETE FROM register WHERE id='$student_id'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['msg'] = "Student deleted successfully!";
    } else {
        $_SESSION['msg'] = "Error deleting student: " . $conn->error;
    }

    // Redirect back to viewStudentDetails.php
    header("Location: viewStudentDetails.php");
    exit();
} else {
    $_SESSION['msg'] = "No student selected for deletion!";
    header("Location: viewStudentDetails.php");
    exit();
}
?>
