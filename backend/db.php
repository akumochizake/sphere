<?php
function connect_db() {
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'glamping';

    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die('Ошибка подключения: ' . $conn->connect_error);
    }

    return $conn;
}
?>
