<?php
require_once("./backend/functions.php");
require_once("./backend/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $login_error = '';

    if (login_user($username, $password)) {
        header("Location: index.php");
        exit();
    } else {
        $login_error = "Неправильный логин или пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <title>Авторизация</title>
</head>
<body>
    <div class="container">
        <?php require_once 'header.php'; ?>

        <div class="cont_form" id="auth">
            <div class="block_title_auth">
                <p id="auth">Авторизация</p>
            </div>
            <div class="forma">
                <form action="" method="post">
                    <input class="password_auth" type="text" placeholder="Логин" name="username" required>
                    <input class="password_auth" type="password" placeholder="Пароль" name="password" required>
                    <input class="password_auth" type="submit" name="login" value="Войти">
                    <?php if (isset($login_error)) echo "<p class='error'>$login_error</p>"; ?>
                </form>
            </div>
        </div>

        <?php require_once 'footer.php'; ?>
    </div>
</body>
</html>
