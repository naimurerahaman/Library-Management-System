<?php
include "config.php";

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM category WHERE id=$id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = $_POST['categoryName'];
    $conn->query("UPDATE category SET name='$newName' WHERE id=$id");
    header("Location: manageCategory.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
</head>
<body>
    <h2>Edit Category</h2>
    <form method="POST">
        <label for="categoryName">Category Name:</label><br>
        <input type="text" id="categoryName" name="categoryName" value="<?php echo $row['name']; ?>"><br>
        <button type="submit">Update Category</button>
    </form>
</body>
</html>
