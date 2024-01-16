<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$username = "";
$email = "";
$errors = array();

$db = mysqli_connect('localhost', 'root', 'root', 'uslugi_db', '8889');

if (isset($_POST['reg_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    if (empty($username)) {
        array_push($errors, "Вы не указали имя");
    }
    if (empty($email)) {
        array_push($errors, "Вы не указали почту");
    }
    if (empty($password_1)) {
        array_push($errors, "Вы не указали пароль");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "Пароли не совпадают");
    }

    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['username'] === $username) {
            array_push($errors, "Пользователь с таким именем уже существует");
        }

        if ($user['email'] === $email) {
            array_push($errors, "Пользователь с такой почтой уже существует");
        }
    }

    if (count($errors) == 0) {
        $password = password_hash($password_1, PASSWORD_DEFAULT);
    
        $query = "INSERT INTO users (username, email, password) 
                          VALUES('$username', '$email', '$password')";
        mysqli_query($db, $query);
    
        $user_query = "SELECT id FROM users WHERE username='$username'";
        $user_result = mysqli_query($db, $user_query);
        $user_row = mysqli_fetch_assoc($user_result);
    
        $_SESSION['user_id'] = $user_row['id'];
        $_SESSION['success'] = "You are now logged in";
        header('location: index.html');
    }
}

if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "Вы не указали имя");
    }
    if (empty($password)) {
        array_push($errors, "Вы не указали пароль");
    }

    if (count($errors) == 0) {
        $query = "SELECT * FROM users WHERE username='$username'";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) {
            $user = mysqli_fetch_assoc($results);

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id']; 
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "Вход успешно выполнен";
                header('location: index.html');
            } else {
                array_push($errors, "Неправильный логин/пароль");
            }
        } else {
            array_push($errors, "Неправильный логин/пароль");
        }
    }
}
?>
