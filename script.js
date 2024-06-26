



// Данные о номерах
const roomsData = [
    { id: 1, name: 'Сфера 1', pricePerDay: 6200, available: true },
    { id: 2, name: 'Сфера 2', pricePerDay: 6500, available: true },
    { id: 3, name: 'Сфера 3', pricePerDay: 6500, available: true },
    { id: 4, name: 'Сфера 4', pricePerDay: 6500, available: true },
    { id: 5, name: 'Сфера 5', pricePerDay: 7000, available: true },
    // Добавьте другие номера
];

// Функция для обновления списка номеров
function updateRoomsList() {
    const checkinDate = new Date(document.getElementById('checkinDate').value);
    const checkoutDate = new Date(document.getElementById('checkoutDate').value);

    if (checkinDate >= checkoutDate) {
        alert('Дата заезда должна быть раньше даты выезда');
        return;
    }

    const currentDate = new Date();
    if (checkinDate < currentDate || checkoutDate < currentDate) {
        alert('Дата заезда и выезда должны быть не раньше текущей даты');
        return;
    }

    const roomsList = document.getElementById('roomsList');
    roomsList.innerHTML = '';

    roomsData.forEach(room => {
        const totalDays = (checkoutDate - checkinDate) / (1000 * 3600 * 24);
        const totalPrice = room.pricePerDay * totalDays;

        const roomCard = document.createElement('div');
        roomCard.classList.add('cardhouse');
        roomCard.id = `roomCard${room.id}`;
        roomCard.innerHTML = `
    <a href="${room.id}.html">
        <img class="cardhouse_img" src="./media/catalog/сфера №${room.id}/${room.id}.jpg" alt=" картинка сферы ${room.id}">
    </a>
    <p class="descript_house">${room.name}</p>
    <p>Цена за сутки: ${room.pricePerDay} рублей</p>
    <p>Общая стоимость: ${totalPrice} рублей</p>
    
    <button class="btn" onclick="bookRoom(${room.id})" ${room.available ? '' : 'disabled'}>
        ${room.available ? 'Бронировать' : 'Занято'}
    </button>
`;


        roomsList.appendChild(roomCard);
    });

    
}
// Функция для бронирования номера
function bookRoom(roomId) {
    const selectedRoom = roomsData.find(room => room.id === roomId);

    if (!selectedRoom.available) {
        alert('Извините, этот номер уже занят. Пожалуйста, выберите другой номер.');
        return;
    }

    selectedRoom.available = false;
    updateRoomsList();

    // Находим кнопку по roomId и меняем текст на "Занято"
    const button = document.querySelector(`#roomCard${roomId} button`);
    if (button) {
        button.textContent = 'Занято';
        button.disabled = true;
    }

    alert(`Номер ${roomId} успешно забронирован!`);
}

// Обработчик кнопки "Проверить наличие"
document.getElementById('checkAvailabilityBtn').addEventListener('click', updateRoomsList);

// Инициализация списка номеров при загрузке страницы
updateRoomsList();

// Обработчик события изменения даты заезда
document.getElementById('checkinDate').addEventListener('change', function() {
    document.getElementById('checkAvailabilityBtn').style.display = 'block';
});

// Обработчик события изменения даты выезда
document.getElementById('checkoutDate').addEventListener('change', function() {
    document.getElementById('checkAvailabilityBtn').style.display = 'block';
});
document.addEventListener('DOMContentLoaded', function() {
    const checkInDate = document.getElementById('checkinDate');
    const checkOutDate = document.getElementById('checkoutDate');
    const checkAvailabilityBtn = document.getElementById('checkAvailabilityBtn');
    const bookingButtons = document.querySelectorAll('.btn');

    // Изначально кнопки бронирования неактивны
    bookingButtons.forEach(button => button.disabled = true);

    // Обработчик нажатия на кнопку "Check Availability"
    checkAvailabilityBtn.addEventListener('click', function() {
        if (checkInDate.value && checkOutDate.value) {
            bookingButtons.forEach(button => {
                // Активируем кнопки только если даты введены
                button.disabled = false;

                // Вешаем обработчики на кнопки бронирования
                button.addEventListener('click', function() {
                    this.textContent = 'Занято';
                    this.disabled = true;
                });
            });
        } else {
            alert('Пожалуйста, выберите даты заезда и выезда.');
        }
    });

    // Скрываем кнопку проверки доступности после первого использования
    checkAvailabilityBtn.addEventListener('click', function() {
        this.style.display = 'none';
    });

    // При изменении дат, кнопка проверки доступности снова появляется
    checkInDate.addEventListener('change', function() {
        checkAvailabilityBtn.style.display = 'block';
        bookingButtons.forEach(button => button.disabled = true);
    });
    checkOutDate.addEventListener('change', function() {
        checkAvailabilityBtn.style.display = 'block';
        bookingButtons.forEach(button => button.disabled = true);
    });
});

document.getElementById('checkinDate').addEventListener('change', function() {
    const checkInDate = new Date(this.value);
    checkInDate.setDate(checkInDate.getDate() + 1); // Добавляем один день
    const checkOutDate = document.getElementById('checkoutDate');
    checkOutDate.valueAsDate = checkInDate; // Устанавливаем дату выезда
});

document.getElementById('checkAvailabilityBtn').addEventListener('click', function () {
    var checkinDate = document.getElementById('checkinDate').value;
    var checkoutDate = document.getElementById('checkoutDate').value;

    if (checkinDate && checkoutDate) {
        document.getElementById('roomsList').style.display = 'block';
    } else {
        alert('Пожалуйста, введите даты заезда и выезда.');
    }
})
document.addEventListener('DOMContentLoaded', function() {
    // Скрываем карточки изначально
    const cardBlock1 = document.querySelector('.card_block_1');
    const cardBlock2 = document.querySelector('.card_block_2');
    cardBlock1.style.display = 'none';
    cardBlock2.style.display = 'none';

    // Обработчик кнопки "Проверить наличие"
    document.getElementById('checkAvailabilityBtn').addEventListener('click', function() {
        // Показываем карточки при нажатии на кнопку
        cardBlock1.style.display = 'flex';
        cardBlock2.style.display = 'flex';

        // Вызываем функцию обновления списка номеров
        updateRoomsList();

        // Скрываем кнопку "Проверить наличие"
        this.style.display = 'none';
    });

    // Функция для обновления списка номеров
    function updateRoomsList() {
        // Ваш код обновления списка номеров здесь
    }
});




document.addEventListener("DOMContentLoaded", function() {
    const images = ["./media/images/6.jpg", "./media/images/7.jpg", "./media/images/8.jpg"];
    const descriptions = [
        "Выбирайте любые удобные для вас даты с 12 по 30 января — и получите ещё один день полноценного отдыха в подарок!",
        "Получите скидку 20% на все процедуры при бронировании до конца месяца!",
        "Специальное предложение для семей — дети до 12 лет бесплатно!"
    ];
    let currentIndex = 0;

    const promoImg = document.querySelector(".promo_img");
    const description = document.querySelector(".p_descript");
    const leftArrow = document.querySelector(".arrow.left img");
    const rightArrow = document.querySelector(".arrow.right img");

    function updateSlider() {
        promoImg.src = images[currentIndex];
        description.textContent = descriptions[currentIndex];
    }

    leftArrow.addEventListener("click", function(event) {
        event.preventDefault();
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1;
        updateSlider();
    });

    rightArrow.addEventListener("click", function(event) {
        event.preventDefault();
        currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0;
        updateSlider();
    });

    updateSlider();  // Initialize the first image and description
});
