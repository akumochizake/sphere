<?php
session_start();
require_once './db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

$conn = connect_db();

if (!$conn) {
    die('Ошибка подключения: ' . $conn->connect_error);
}

$sql = "SELECT *, DATE_FORMAT(available_from, '%d-%m-%Y') as available_from, DATE_FORMAT(available_to, '%d-%m-%Y') as available_to FROM spheres";
$result = $conn->query($sql);

$spheres = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $spheres[] = $row;
    }
} else {
    $spheres = null; 
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($spheres);
