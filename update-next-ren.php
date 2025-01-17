<?php
$servername = "localhost";
$username = "ebac_pro_2023";
$password = "ebac_pro_2023";
$dbname = "ebac_pro_2023";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$tableName = $_POST['table_name'];
$nextRen = $_POST['next_ren'];

// Sanitize and validate input
if (!is_numeric($id) || empty($tableName) || empty($nextRen)) {
    echo "Invalid input.";
    exit();
}

$sql = "UPDATE $tableName SET next_ren = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo "Error preparing statement: " . $conn->error;
    exit();
}

$stmt->bind_param('si', $nextRen, $id);

if ($stmt->execute()) {
    echo "Success";
} else {
    echo "Error executing statement: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>