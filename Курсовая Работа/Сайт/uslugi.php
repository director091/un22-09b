<?php
session_start();
include('server.php');

if (isset($_POST['add_service'])) {
    if (isset($_SESSION['user_id'])) {
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $description = mysqli_real_escape_string($db, $_POST['description']);
        $price = mysqli_real_escape_string($db, $_POST['price']);
        $contacts = mysqli_real_escape_string($db, $_POST['contacts']);

        $user_id = $_SESSION['user_id'];

        if (empty($title) || empty($description) || empty($price) || empty($contacts)) {
            echo "Please fill in all the fields.";
        } else {
            $query = "INSERT INTO services (title, description, price, contacts, user_id) 
                      VALUES ('$title', '$description', '$price', '$contacts', '$user_id')";
            $result = mysqli_query($db, $query);

            if (!$result) {
                die("Query failed: " . mysqli_error($db));
            }
        }
    } else {
        echo "User not logged in. Please log in and try again.";
    }
}

function displayUserServices($db, $user_id) {
    $query = "SELECT services.*, users.username FROM services JOIN users ON services.user_id = users.id WHERE user_id = '$user_id'";
    $result = mysqli_query($db, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='service-card'>";
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<p><strong>Описание:</strong> " . $row['description'] . "</p>";
        echo "<p><strong>Цена:</strong> $" . $row['price'] . "</p>";
        echo "<p><strong>Пользователь:</strong> " . $row['username'] . "</p>";
        echo "<p><strong>Связаться:</strong> <a href='" . $row['contacts'] . "' target='_blank'>Ссылка</a></p>";
        echo "</div>";
    }
}

function displayServices($db) {
    $query = "SELECT services.*, users.username FROM services JOIN users ON services.user_id = users.id";
    $result = mysqli_query($db, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='service-card'>";
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<p><strong>Описание:</strong> " . $row['description'] . "</p>";
        echo "<p><strong>Цена:</strong> $" . $row['price'] . "</p>";
        echo "<p><strong>Пользователь:</strong> " . $row['username'] . "</p>";
        echo "<p><strong>Связаться:</strong> <a href='" . $row['contacts'] . "' target='_blank'>Ссылка</a></p>";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles\style_index.css">
    <header>
    <h1>Услуги</h1>
    <nav>
        <ul>
            <li><a href="index.html">Главная</a></li>
            <li><a href="uslugi.php">Услуги</a></li>
            <li><a href="profile.php">Личный кабинет</a></li>
        </ul>
    </nav>
</header>
    <title>Услуги</title>
    
</head>
<body>

   <form action="" method="post">
   <label for="filter">
    <input type="radio" name="filter" value="all" <?php if (!isset($_POST['filter']) || $_POST['filter'] === 'all') echo 'checked'; ?>>
    Все услуги
</label>

<label for="filter">
    <input type="radio" name="filter" value="user" <?php if (isset($_POST['filter']) && $_POST['filter'] === 'user') echo 'checked'; ?>>
    Мои услуги
</label>
        <input type="submit" value="Применить">
    </form>
   <div>
   <button onclick="openModal()">Добавить услугу</button> 
   </div>
   
   


    <?php
    if (isset($_POST['filter'])) {
        $filter = $_POST['filter'];
        if ($filter === 'user' && isset($_SESSION['user_id'])) {
            displayUserServices($db, $_SESSION['user_id']);
        } else {
            displayServices($db);
        }
    } else {
        displayServices($db);
    }
    ?>

    <div class="modal" id="myModal">
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

            <input type="submit" name="add_service" value="Добавить" class="button">
        </form>
        <div>
        <button onclick="closeModal()">Закрыть</button>
        </div>
        
    </div>

    <div class="modal-overlay" id="overlay" onclick="closeModal()"></div>

    <script src="scripts\script.js"></script>

</body>
</html>
