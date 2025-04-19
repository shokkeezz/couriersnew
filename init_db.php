<?php
$db = new PDO('sqlite:database.db');

// Создание таблиц
$db->exec("CREATE TABLE IF NOT EXISTS users (
  id INTEGER PRIMARY KEY,
  username TEXT UNIQUE,
  password TEXT,
  role TEXT
)");

$db->exec("CREATE TABLE IF NOT EXISTS cards (
  id INTEGER PRIMARY KEY,
  name TEXT,
  color TEXT,
  queue INTEGER
)");

// Добавление админа (логин: admin, пароль: admin)
$check = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
if ($check == 0) {
  $hash = password_hash('adm322', PASSWORD_DEFAULT);
  $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)")
     ->execute(['adm322', $hash, 'adm322']);
  echo "База данных и админ созданы.";
} else {
  echo "База уже инициализирована.";
}
