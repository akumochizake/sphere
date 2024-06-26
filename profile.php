<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Профиль пользователя</title>
</head>
<body>
    <div class="container">
        <?php require_once './header.php'; ?>
        <section>
            <h1>Профиль пользователя</h1>
            <h2>Корзина забронированных сфер</h2>
            <div id="cart-list">
            </div>
        </section>
        <?php require_once './footer.php'; ?>
    </div>
    <script src="script.js"></script>
    <script>
        window.onload = function() {
            loadCart();
        };

        function loadCart() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "./backend/get_cart.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var cartItems = JSON.parse(xhr.responseText);
                    displayCartItems(cartItems);
                }
            };
            xhr.send();
        }

        function displayCartItems(cartItems) {
            var cartList = document.getElementById('cart-list');
            cartList.innerHTML = '';

            if (cartItems.length === 0) {
                cartList.innerHTML = 'Корзина пуста';
            } else {
                for (var i = 0; i < cartItems.length; i++) {
                    var cartItem = cartItems[i];
                    var cartItemDiv = document.createElement('div');
                    cartItemDiv.innerHTML = '<p><strong>Сфера:</strong> ' + cartItem.name + '</p>' +
                                            '<p><strong>Цена за сутки:</strong> ' + cartItem.price + ' рублей</p>' +
                                            '<button onclick="removeFromCart(' + cartItem.id + ')">Удалить из корзины</button>';
                    cartList.appendChild(cartItemDiv);
                }
            }
        }

        function removeFromCart(sphereId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "./backend/cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert("Сфера удалена из корзины.");
                        loadCart();
                    } else {
                        alert("Ошибка: " + response.message);
                    }
                }
            };
            xhr.send("action=remove&sphere_id=" + sphereId);
        }
    </script>
</body>
</html>
