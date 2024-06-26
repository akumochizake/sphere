<?php
require_once 'db.php';

function register_user($username, $password) {
    $conn = connect_db();
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if (!$stmt) {
        echo "Ошибка при подготовке запроса: " . $conn->error;
        return false;
    }
    $stmt->bind_param("ss", $username, $password_hash);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}

function is_unique_user($username) {
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    if (!$stmt) {
        echo "Ошибка при подготовке запроса: " . $conn->error;
        return false;
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;
    $stmt->close();
    $conn->close();
    return $count == 0;
}

function login_user($username, $password) {
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    if (!$stmt) {
        echo "Ошибка при подготовке запроса: " . $conn->error;
        return false;
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $stmt->close();
            $conn->close();
            return true;
        }
    }

    $stmt->close();
    $conn->close();
    return false;
}


?>
