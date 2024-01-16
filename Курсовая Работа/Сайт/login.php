<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Вход</title>
  <link rel="stylesheet" type="text/css" href="styles\style_reg_log.css">
</head>
<body>
  <div class="header">
        <h2>Вход</h2>
  </div>
         
  <form method="post" action="login.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
                <label>Имя</label>
                <input type="text" name="username" >
        </div>
        <div class="input-group">
                <label>Пароль</label>
                <input type="password" name="password">
        </div>
        <div class="input-group">
                <button type="submit" class="btn" name="login_user">Вход</button>
        </div>
        <p>
                Еще нет аккаунта? <a href="register.php">Зарегистрироваться</a>
        </p>
  </form>
</body>
</html>