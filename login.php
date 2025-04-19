<?php
require 'db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->execute([$_POST['username']]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($_POST['password'], $user['password'])) {
    $_SESSION['user'] = $user;
    header('Location: queues.php');
    exit;
  } else {
    $error = 'Неверный логин или пароль';
  }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Вход</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Вход</h2>
  <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
  <form method="post">
    <input name="username" placeholder="Логин" required><br>
    <input type="password" name="password" placeholder="Пароль" required><br>
    <button type="submit">Войти</button>
  </form>
</body>
</html>
