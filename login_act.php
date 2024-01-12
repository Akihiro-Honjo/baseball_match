<?php
// データ受け取り
// var_dump($_POST);
// exit();
session_start();
include('functions.php');

$name = $_POST['name'];
$address = $_POST['address'];
$password = $_POST['password'];
// DB接続
$pdo = connect_to_db();

// SQL実行
// username，password，deleted_atの3項目全ての条件満たすデータを抽出する．
$sql = 'SELECT * FROM login_table WHERE name=:name AND address=:address AND password=:password AND deleted_at IS NULL';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':address', $address, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// ユーザ有無で条件分岐
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
  echo "<p>ログイン情報に誤りがあります</p>";
  echo "<a href=todo_login.php>ログイン</a>";
  exit();
} else {
  $_SESSION = array();
  $_SESSION['session_id'] = session_id();
  $_SESSION['is_admin'] = $user['is_admin'];
  $_SESSION['username'] = $user['username'];
  header("Location:profile.php");
  exit();
}
