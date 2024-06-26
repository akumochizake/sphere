<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        echo "Пожалуйста, авторизуйтесь, чтобы добавить товар в корзину.";
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $sphere_id = $_POST['sphere_id'];

    $conn = connect_db();
    
    $stmt = $conn->prepare("SELECT id FROM orders WHERE user_id = ? AND sphere_id = ?");
    $stmt->bind_param("ii", $user_id, $sphere_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Эта сфера уже добавлена в вашу корзину.";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO orders (user_id, sphere_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $sphere_id);
    if ($stmt->execute()) {
        echo "Сфера успешно добавлена в корзину.";
    } else {
        echo "Ошибка при добавлении сферы в корзину.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Недопустимый метод запроса.";
}
?>
