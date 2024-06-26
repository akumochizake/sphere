<?php
require_once './db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    $conn = connect_db();

    if (!$conn) {
        die('Ошибка подключения: ' . $conn->connect_error);
    }

    $sql = "SELECT id, name, price, capacity, area, description, image, 
                   DATE_FORMAT(available_from, '%d-%m-%Y') AS available_from, 
                   DATE_FORMAT(available_to, '%d-%m-%Y') AS available_to
            FROM spheres
            WHERE available_from >= ? AND available_to <= ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $check_in, $check_out);
    $stmt->execute();
    $result = $stmt->get_result();

    $spheres = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $spheres[] = $row;
        }
    }

    $stmt->close();
    $conn->close();

    echo json_encode($spheres);
} else {
    echo json_encode([]);
}
?>
