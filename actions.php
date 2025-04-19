<?php
require 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
  header('Location: login.php'); exit;
}

$action = $_POST['action'];

if ($action === 'add') {
  $name = $_POST['name'];
  $colors = ['#5e81ac', '#88c0d0', '#b48ead', '#d08770', '#a3be8c', '#81a1c1'];
  $color = $colors[array_rand($colors)];
  $db->prepare("INSERT INTO cards (name, color, queue) VALUES (?, ?, 1)")->execute([$name, $color]);
}
elseif ($action === 'move') {
  $id = $_POST['id'];
  $card = $db->prepare("SELECT * FROM cards WHERE id = ?");
  $card->execute([$id]);
  $card = $card->fetch();
  $newQueue = $card['queue'] == 1 ? 2 : 1;
  $db->prepare("UPDATE cards SET queue = ? WHERE id = ?")->execute([$newQueue, $id]);
}
elseif ($action === 'delete') {
  $id = $_POST['id'];
  $db->prepare("DELETE FROM cards WHERE id = ?")->execute([$id]);
}

header('Location: queues.php');
exit;
