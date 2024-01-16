<?php
session_start();

$errors = array();

$db = mysqli_connect('localhost', 'root', 'root', 'uslugi_db', '8889');

if (isset($_GET['logout'])) {
    session_destroy();

    header('location: login.php'); 
    exit();
}

if (!$db) {
    die("Соединение прервано: " . mysqli_connect_error());
}

if (!isset($_SESSION['username'])) {
    header('location: login.php'); 
}

$username = $_SESSION['username'];
$is_admin = ($username === 'admin');

if (isset($_POST['change_data'])) {
    $new_username = mysqli_real_escape_string($db, $_POST['new_username']);
    $new_email = mysqli_real_escape_string($db, $_POST['new_email']);
    $new_password = mysqli_real_escape_string($db, $_POST['new_password']);

    if (count($errors) == 0) {
        if (!empty($new_username)) {
            $update_query = "UPDATE users SET username='$new_username' WHERE username='$username'";
            mysqli_query($db, $update_query);
            $_SESSION['username'] = $new_username; 
        }

        if (!empty($new_email)) {
            $update_query = "UPDATE users SET email='$new_email' WHERE username='$username'";
            mysqli_query($db, $update_query);
        }

        if (!empty($new_password)) {
            $new_password = md5($new_password);
            $update_query = "UPDATE users SET password='$new_password' WHERE username='$username'";
            mysqli_query($db, $update_query);
        }

        $_SESSION['success'] = "Данные успешно обновлены";
        header('location: profile.php'); 
        exit();
    }
}

if (isset($_POST['goto_admin_panel'])) {
    header('location: admin.php');
    exit();
}

$user_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
$result = mysqli_query($db, $user_query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles\style_profile.css">
    <title>Личный кабинет</title>
</head>

<body>
<header class="header2">
<h1>Личный кабинет</h1>
    <nav>
    
        <ul>
            <li><a href="index.html">Главная</a></li>
            <li><a href="uslugi.php">Услуги</a></li>
            <li><a href="login.php?logout=true">Выйти</a></li>
        </ul>
    </nav>
</header>
    <div class="header1">
        <h2>Мои данные</h2>
    </div>
    
    
        <form method="post" action="profile.php">
            <div class="input-group">
                <label for="login">Логин:</label>
                <input type="text" id="login" name="new_username" value="<?php echo $user['username']; ?>">
            </div>

            <div class="input-group">
                <label for="email">Почта:</label>
                <input type="text" id="email" name="new_email" value="<?php echo $user['email']; ?>">
            </div>

            <div class="input-group">
                <label for="password">Новый пароль:</label>
                <input type="password" id="password" name="new_password" value="">
            </div>

            <button type="submit" class="btn" name="change_data">Подтвердить изменения</button>
            
            <input type="hidden" name="goto_admin_panel" value="1">

            <?php
            if ($is_admin) {
                echo '<button type="submit" class="btn" name="goto_admin_panel">Перейти в админ панель</button>';
            }
            ?>
        </form>
    
</body>

</html>