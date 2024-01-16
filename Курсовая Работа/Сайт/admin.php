<?php
session_start();
include('server.php');

function displayServices($db) {
    $query = "SELECT services.*, users.id as user_id, users.username FROM services JOIN users ON services.user_id = users.id";
    $result = mysqli_query($db, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='service-card'>";
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<p><strong>ID услуги:</strong> " . $row['id'] . "</p>";
        echo "<p><strong>Описание:</strong> " . $row['description'] . "</p>";
        echo "<p><strong>Цена:</strong> $" . $row['price'] . "</p>";
        echo "<p><strong>Пользователь:</strong> " . $row['username'] . " (ID: " . $row['user_id'] . ")</p>";
        echo "<p><strong>Связаться:</strong> <a href='" . $row['contacts'] . "' target='_blank'>Ссылка</a></p>";
        echo "</div>";
    }
}

function displayAllUsers($db) {
    $query = "SELECT * FROM users";
    $result = mysqli_query($db, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='service-card'>";
        echo "<p><strong>ID пользователя:</strong> " . $row['id'] . "</p>";
        echo "<p><strong>Имя пользователя:</strong> " . $row['username'] . "</p>";
        echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
        echo "</div>";
    }
}

if (isset($_POST['add_service'])) {
    if (isset($_SESSION['user_id'])) {
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $description = mysqli_real_escape_string($db, $_POST['description']);
        $price = mysqli_real_escape_string($db, $_POST['price']);
        $contacts = mysqli_real_escape_string($db, $_POST['contacts']);

        $user_id = $_SESSION['user_id'];

        if (empty($title) || empty($description) || empty($price) || empty($contacts)) {
            echo "Пожалуйста, заполните все поля.";
        } else {
            $query = "INSERT INTO services (title, description, price, contacts, user_id) 
                      VALUES ('$title', '$description', '$price', '$contacts', '$user_id')";
            $result = mysqli_query($db, $query);

        }
    }
}

if (isset($_POST['add_user'])) {
    $login = mysqli_real_escape_string($db, $_POST['login']);
    $email = mysqli_real_escape_string($db, $_POST['mail']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($login) || empty($email) || empty($password)) {
        echo "Пожалуйста, заполните все поля.";
    } else {
        $query = "INSERT INTO users (username, email, password) 
                  VALUES ('$login', '$email', '$password')";
        $result = mysqli_query($db, $query);
    }
}

if (isset($_POST['delete_service'])) {
    $serviceNumber = mysqli_real_escape_string($db, $_POST['number']);

    if (empty($serviceNumber)) {
        echo "Пожалуйста, введите номер услуги.";
    } else {
        $query = "DELETE FROM services WHERE id = '$serviceNumber'";
        $result = mysqli_query($db, $query);
    }
}

if (isset($_POST['delete_user'])) {
    $userNumber = mysqli_real_escape_string($db, $_POST['number']);

    if (empty($userNumber)) {
        echo "Пожалуйста, введите номер пользователя.";
    } else {
        $query = "DELETE FROM users WHERE id = '$userNumber'";
        $result = mysqli_query($db, $query);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список услуг</title>
    <link rel="stylesheet" type="text/css" href="styles\style_admin.css">

</head>
<header>
    <h1>Панель администратора</h1>
    <nav>
        <ul>
        <li><a href="index.html">Главная</a></li>
            <li><a href="uslugi.php">Услуги</a></li>
            <li><a href="profile.php">Личный кабинет</a></li>
            
        </ul>
    </nav>
</header>
<form action="" method="post">
        <label for="filter">
            <input type="radio" name="filter" value="all" <?php if (!isset($_POST['filter']) || $_POST['filter'] === 'all') echo 'checked'; ?>>
            Услуги
        </label>

        <label for="filter">
            <input type="radio" name="filter" value="user" <?php if (isset($_POST['filter']) && $_POST['filter'] === 'user') echo 'checked'; ?>>
            Пользователи
        </label>

        <input type="submit" value="Применить">
    </form>

    <?php
    if (isset($_POST['filter'])) {
        $filter = $_POST['filter'];
        if ($filter === 'user') {
            ?>
            <div>    
                <button onclick="openModaluser()">Добавить</button>
                <button onclick="openModaldeleteuser()">Удалить</button>
            </div>
            
            <?php
        } else {
            ?>
            <div>    
                <button onclick="openModaluslugi()">Добавить</button>
                <button onclick="openModaldeleteuslugi()">Удалить</button>
            </div>
            <?php
        }
    }
    ?>
<?php
if (isset($_POST['filter'])) {
    $filter = $_POST['filter'];
    if ($filter === 'user') {
        displayAllUsers($db);
    } else {
        displayServices($db);
    }
} 
?>

<div class="modal" id="uslugi">
        <h2>Добавить услугу</h2>
        <form action="" method="post">
            <label for="title">Название:</label>
            <input type="text" name="title" required><br>

            <label for="description">Описание:</label>
            <textarea name="description" rows="4" required></textarea><br>

            <label for="price">Цена:</label>
            <input type="number" name="price" step="0.01" required><br>

            <label for="contacts">Контакты:</label>
            <input type="text" name="contacts" required><br>
            <input type="submit" name="add_service" value="Добавить">
        </form>
        <div>
            <button onclick="closeModaluslugi()">Закрыть</button>
        </div>
        
    </div>
    <div class="modal" id="user">
        <h2>Добавить пользователя</h2>
        <form action="" method="post">
            <label for="login">Логин:</label>
            <input type="text" name="login" required><br>

            <label for="mail">Почта:</label>
            <textarea name="mail" rows="1" required></textarea><br>  

            <label for="password">Пароль:</label>
            <textarea name="password" rows="1" required></textarea><br>
            <input type="submit" name="add_user" value="Добавить">
        </form>
        <div>
            <button onclick="closeModaluser()">Закрыть</button>
        </div>
        
    </div>

    <div class="modal" id="deleteuslugi">
        <h2>Удалить услугу</h2>
        <form action="" method="post">
            <label for="number">ID Услуги:</label>
            <input type="text" name="number" required><br>

            <input type="submit" name="delete_service" value="Удалить">
        </form>
        <div>
            <button onclick="closeModaldeleteuslugi()">Закрыть</button>
        </div>
        
    </div>
    <div class="modal" id="deleteuser">
        <h2>Удалить пользователя</h2>
        <form action="" method="post">
            <label for="number">ID Пользователя:</label>
            <input type="text" name="number" required><br>

            <input type="submit" name="delete_user" value="Удалить">
        </form>
        <div>
            <button onclick="closeModaldeleteuser()">Закрыть</button>
        </div>
        
    </div>

    <div class="modal-overlay" id="overlay" onclick="closeModaluslugi()"></div>
    <div class="modal-overlay" id="overlay" onclick="closeModaluser()"></div>
    <div class="modal-overlay" id="overlay" onclick="closeModaldeleteuslugi()"></div>
    <div class="modal-overlay" id="overlay" onclick="closeModaldeleteuser()"></div>

    <script src="scripts\admin.js"></script>

</body>
</html>
