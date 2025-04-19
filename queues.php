<?php
require 'db.php';
if (!isset($_SESSION['user'])) header('Location: login.php');

$cards = $db->query("SELECT * FROM cards ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
$queue1 = array_filter($cards, function($c) { return $c['queue'] == 1; });
$queue2 = array_filter($cards, function($c) { return $c['queue'] == 2; });

?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Очереди</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <div>
      Привет, <b><?= $_SESSION['user']['username'] ?></b> (<?= $_SESSION['user']['role'] ?>)
    </div>
    <div>
      <a href="logout.php">Выйти</a>
    </div>
  </header>

  <main>
    <?php if ($_SESSION['user']['role'] == 'admin'): ?>
      <form action="actions.php" method="POST">
        <input name="name" placeholder="Имя" required>
        <button name="action" value="add">Добавить карточку</button>
      </form>
    <?php endif; ?>

    <div class="queues">
      <div class="column">
        <h3>В очереди</h3>
        <?php foreach ($queue1 as $card): ?>
          <div class="card" style="background: <?= $card['color'] ?>;">
            <?= htmlspecialchars($card['name']) ?>
            <?php if ($_SESSION['user']['role'] == 'admin'): ?>
              <form method="POST" action="actions.php">
                <input type="hidden" name="id" value="<?= $card['id'] ?>">
                <button name="action" value="move">→</button>
                <button name="action" value="delete">✖</button>
              </form>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="column">
        <h3>В пути</h3>
        <?php foreach ($queue2 as $card): ?>
          <div class="card" style="background: <?= $card['color'] ?>;">
            <?= htmlspecialchars($card['name']) ?>
            <?php if ($_SESSION['user']['role'] == 'admin'): ?>
              <form method="POST" action="actions.php">
                <input type="hidden" name="id" value="<?= $card['id'] ?>">
                <button name="action" value="move">←</button>
                <button name="action" value="delete">✖</button>
              </form>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </main>
</body>

</html>
