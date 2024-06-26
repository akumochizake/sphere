<?php
session_start();
require_once './backend/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

$conn = connect_db();

if (!$conn) {
    die('Ошибка подключения: ' . $conn->connect_error);
}

$sql = "SELECT * FROM spheres";
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
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> 
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Атмосфера</title>
    <style>
        .carousel-item {
            text-align: center;
            padding: 20px;
        }
        .carousel-item img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .carousel-button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .carousel-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php require_once './header.php'; ?>
        <main>
            <div class="aboutUs">
                <div class="mini_p_block">
                    <p class="title">О нас</p>
                    <p class="description">Глэмпинг "Атмосфера" в Удмуртии – новый формат отдыха для этого региона. Это первый глэмпинг в Ижевске!</p>
                </div>
                <img class="picture_aboutUs" src="./media/images/h.jpg" alt="photo1">
            </div>
            <div class="promo">
                <p class="title">Акции</p>
                <div class="promo_cont">
                    <div class="slider">
                        <div class="card">
                            <a href="#" class="arrow left"><img class="cursor" src="./media/left-arrow_271220.png" alt="кнопка1"></a>
                            <img class="promo_img" src="./media/images/6.jpg" alt="акция">
                            <a href="#" class="arrow right"><img class="cursor" src="./media/right-arrow_271228.png" alt="кнопка2"></a>
                        </div>
                        <p class="p_descript">
                            Выбирайте любые удобные для вас даты с 12 по 30 января — и получите ещё один день полноценного отдыха в подарок!
                        </p>
                    </div>
                    <img class="promo_pict" src="./media/images/S.jpg" alt="">
                </div>
            </div>
            <h2>Наши сферы</h2>
            <div id="carouselSpheres" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php if ($spheres): ?>
                        <?php foreach ($spheres as $index => $sphere) : ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <h3><?php echo htmlspecialchars($sphere['name']); ?></h3>
                                <img src="./media/images/<?php echo htmlspecialchars($sphere['photo_url']); ?>" class="d-block w-100" alt="Фотография сферы">
                                <p>Цена: <?php echo htmlspecialchars($sphere['price']); ?> рублей / сутки</p>
                                <p>Вместимость: <?php echo htmlspecialchars($sphere['capacity']); ?> человек</p>
                                <p>Площадь: <?php echo htmlspecialchars($sphere['area']); ?> кв. м</p>
                                <p>Описание: <?php echo htmlspecialchars($sphere['description']); ?></p>
                                <form action="/backend/add_to_cart.php" method="POST">
                                    <input type="hidden" name="sphere_id" value="<?php echo $sphere['id']; ?>">
                                    <button type="submit" class="btn btn-primary mt-3">Заказать</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="carousel-item active">
                            <p>Нет доступных сфер в настоящее время.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselSpheres" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselSpheres" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </main>
        <?php require_once './footer.php'; ?>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
