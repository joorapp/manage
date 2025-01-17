<?php
session_start();

$servername = "localhost";
$username = "epe_ebacpro_2023";
$password = "epe_ebacpro_2023";
$dbname = "epe_ebacpro_2023";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$tableName = $_POST['table_name'];
$nextRen = $_POST['next_ren'];

// Sanitize and validate input
if (!is_numeric($id) || empty($tableName) || empty($nextRen)) {
    echo json_encode(['error' => 'Invalid input.']);
    exit();
}

// Validate and format date
$date = DateTime::createFromFormat('d-m-Y', $nextRen);
if ($date && $date->format('d-m-Y') === $nextRen) {
    $nextRenFormatted = $date->format('Y-m-d');
} else {
    echo json_encode(['error' => 'Invalid date format. Please use d-m-Y.']);
    exit();
}

// Update the database
$sql = "UPDATE $tableName SET next_ren = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['error' => 'Error preparing statement: ' . $conn->error]);
    exit();
}
$stmt->bind_param('si', $nextRenFormatted, $id);
if ($stmt->execute()) {
    // Calculate days_left after updating
    $daysLeftQuery = "SELECT DATEDIFF(next_ren, CURDATE()) AS days_left FROM $tableName WHERE id = ?";
    $stmt = $conn->prepare($daysLeftQuery);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $daysLeft = $row['days_left'];

    echo json_encode(['success' => true, 'days_left' => $daysLeft]);
} else {
    echo json_encode(['error' => 'Error executing statement: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>