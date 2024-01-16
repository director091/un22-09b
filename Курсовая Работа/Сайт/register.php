<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Регистрация</title>
  <link rel="stylesheet" type="text/css" href="styles\style_reg_log.css">
</head>
<body>
  <div class="header">
        <h2>Регистрация</h2>
  </div>
        
  <form method="post" action="register.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
          <label>Имя</label>
          <input type="text" name="username" value="<?php echo $username; ?>">
        </div>
        <div class="input-group">
          <label>Почта</label>
          <input type="email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="input-group">
          <label>Пароль</label>
          <input type="password" name="password_1">
        </div>
        <div class="input-group">
          <label>Подтвердите пароль</label>
          <input type="password" name="password_2">
        </div>
        <div class="input-group">
          <button type="submit" class="btn" name="reg_user">Регистрация</button>
        </div>
        <p>
                Уже есть аккаунт? <a href="login.php">Войти</a>
        </p>
  </form>
</body>
</html>