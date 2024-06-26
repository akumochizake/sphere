<?php
require_once 'backend/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $password_repeat = trim($_POST['password_repeat']);

    if (!is_unique_user($username)) {
        $register_error = "Пользователь с таким логином уже существует.";
    } elseif ($password != $password_repeat) {
        $register_error = "Пароли не совпадают.";
    } else {
        if (register_user($username, $password)) {
            header("Location: index.php");
            exit();
        } else {
            $register_error = "Ошибка при регистрации. Пожалуйста, попробуйте еще раз.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <title>Регистрация</title>
</head>
<body>
    <div class="container">
        <?php require_once 'header.php'; ?>

        <div class="cont_form" id="reg">
            <div class="block_title_auth">
                <p id="auth">Регистрация</p>
            </div>
            <div class="forma">
                <form action="" method="post">
                    <input class="password_auth" type="text" placeholder="Имя" name="username" required>
                    <input class="password_auth" type="text" placeholder="Фамилия" name="username" required>
                    <input class="password_auth" type="text" placeholder="Отчество" name="username" required>
                    <input class="password_auth" type="email" placeholder="email" name="username" required>
                    <input class="password_auth" type="text" placeholder="Логин" name="username" required>
                    <input class="password_auth" type="password" placeholder="Пароль" name="password" required>
                    <input class="password_auth" type="password" placeholder="Повторите пароль" name="password_repeat" required>
                    <input class="password_auth" type="submit" name="register" value="Зарегистрироваться">
                    <?php if (isset($register_error)) echo "<p class='error'>$register_error</p>"; ?>
                </form>
            </div>
        </div>

        <?php require_once 'footer.php'; ?>
    </div>
</body>
</html>
