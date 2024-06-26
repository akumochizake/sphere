<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Аренда сферы</title>
</head>
<body>
    <div class="container">
        <?php require_once './header.php'; ?>
        <section>
            <h1>Аренда сферы</h1>
            <form id="rent-form" onsubmit="event.preventDefault(); checkAvailability();">
                <label for="checkinDate">Дата заезда:</label>
                <input type="date" id="checkinDate" name="check_in" required>
                <label for="checkoutDate">Дата выезда:</label>
                <input type="date" id="checkoutDate" name="check_out" required>
                <button type="submit" id="checkAvailabilityBtn">Проверить наличие</button>
            </form>
            
            <div id="roomsList"></div>
        </section>
        <?php require_once './footer.php'; ?>
    </div>
    <script src="script.js"></script>
    <script>
        window.onload = function() {
            loadAllSpheres();
        };

        function loadAllSpheres() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "./backend/get_all_spheres.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        var spheres = JSON.parse(xhr.responseText);
                        displayAvailableSpheres(spheres);
                    } else {
                        alert("Ошибка загрузки списка сфер. Пожалуйста, попробуйте позже.");
                    }
                }
            };
            xhr.send();
        }

        function checkAvailability() {
            var checkIn = document.getElementById('checkinDate').value;
            var checkOut = document.getElementById('checkoutDate').value;

            if (!checkIn || !checkOut) {
                alert("Пожалуйста, выберите даты заезда и выезда.");
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "./backend/check_availability.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        var spheres = JSON.parse(xhr.responseText);
                        displayAvailableSpheres(spheres);
                    } else {
                        alert("Ошибка проверки доступности сфер. Пожалуйста, попробуйте позже.");
                    }
                }
            };
            xhr.send("check_in=" + encodeURIComponent(checkIn) + "&check_out=" + encodeURIComponent(checkOut));
        }

        function displayAvailableSpheres(spheres) {
            var spheresList = document.getElementById('roomsList');
            spheresList.innerHTML = '';

            if (spheres.length === 0) {
                spheresList.innerHTML = 'Нет доступных сфер';
            } else {
                for (var i = 0; i < spheres.length; i++) {
                    var sphere = spheres[i];
                    var sphereItem = document.createElement('div');
                    sphereItem.innerHTML = '<h3>' + sphere.name + '</h3>' +
                                           '<p>Цена: ' + sphere.price + ' рублей/сутки</p>' +
                                           '<p>Вместимость: ' + sphere.capacity + ' человек</p>' +
                                           '<p>Площадь: ' + sphere.area + ' кв. м</p>' +
                                           '<p>Описание: ' + sphere.description + '</p>' +
                                           '<p>Доступность: с ' + sphere.available_from + ' до ' + sphere.available_to + '</p>' +
                                           '<img src="./media/images/' + sphere.photo_url + '" alt="' + sphere.name + '" class="sphere-img">';
                    var addButton = document.createElement('button');
                    addButton.textContent = 'Заказать сферу';
                    addButton.onclick = (function(id) {
                        return function() {
                            addToCart(id);
                        };
                    })(sphere.id);
                    sphereItem.appendChild(addButton);
                    sphereItem.appendChild(document.createElement('hr'));
                    spheresList.appendChild(sphereItem);
                }
            }
        }

        function addToCart(sphereId) {
            console.log("Attempting to add sphere with ID:", sphereId); // Debugging line
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "./backend/add_to_cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    console.log("Server responded with status:", xhr.status); // Debugging line
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        console.log("Response from server:", response); // Debugging line
                        if (response.success) {
                            alert("Сфера успешно добавлена в корзину.");
                        } else {
                            alert("Ошибка: " + response.message);
                        }
                    } else {
                        alert("Ошибка добавления в корзину. Пожалуйста, попробуйте позже.");
                    }
                }
            };
            xhr.send("sphere_id=" + sphereId);
        }
    </script>
</body>
</html>
