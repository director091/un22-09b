document.getElementById('car-registration-form').addEventListener('submit', function(event) {
    event.preventDefault(); // предотвращаем отправку формы

    // Получаем данные из формы
    var make = document.getElementById('make').value;
    var model = document.getElementById('model').value;
    var year = document.getElementById('year').value;
    var price = document.getElementById('price').value;
    var mileage = document.getElementById('mileage').value;
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phone').value;

    // Проверяем обязательные поля
    if (!make  ||!model  ||!year  ||!price  ||!email ||!phone) {
        document.getElementById('message').innerHTML = 'Ошибка: заполните все обязательные поля!';
        return;
    }

    // Дополнительные проверки для определенных полей (например, год должен быть числом)
    if (isNaN(year)) {
        document.getElementById('message').innerHTML = 'Ошибка: год должен быть числом!';
        return;
    }

    // Отображаем данные
    document.getElementById('message').innerHTML = 'Данные успешно отправлены:<br>' +
        'Марка: ' + make + '<br>' +
        'Модель: ' + model + '<br>' +
        'Год выпуска: ' + year + '<br>' +
        'Цена: ' + price + '<br>' +
        'Пробег: ' + mileage + '<br>' +
        'Email: ' + email + '<br>' +
        'Телефон: ' + phone;

    // Очищаем поля формы после успешной отправки
    document.getElementById('car-registration-form').reset();
});