<?php
require_once 'db.php'; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['sphere_id'])) {
        $sphere_id = $_POST['sphere_id'];
        $user_id = 1; 

        $conn = connect_db();

        $query = "SELECT * FROM spheres WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $sphere_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $query = "INSERT INTO cart (sphere_id, user_id) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ii', $sphere_id, $user_id);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Сфера успешно добавлена в корзину.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Ошибка добавления в корзину.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Сфера не найдена.']);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Не указан идентификатор сферы.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Некорректный метод запроса.']);
}
?>
