<?php
// var_dump($_POST);
// exit();
include('functions.php');

$pdo = connect_to_db();


$sql = 'SELECT * FROM  login_table';

$stmt = $pdo->prepare($sql);

try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }
  
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>登録選手一覧画面</title>
  <link rel="stylesheet" href="style.css">
</head>
<style>
  .post {
    border: 1.5px solid #000;
    padding: 20px;
    margin-bottom: 10px;
    border-radius: 10px;
    width: auto;
}
</style>
<body>

    <legend>登録選手一覧画面</legend>
    <div class="post">
        <?= $output ?>
    </div>

<script>
   
    let postList = <?= json_encode($result) ?>;

        function renderPosts(posts) {
        return posts.map(function(post) {
            return `
                <div class='post'>
                    <p>選手名：${post.name}</p>
                    <button><a href='#?'>スカウト</a></button>
                    <button><a href='#?'>プロテクト</a></button>
                </div>
            `;
        }).join('');
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('.post').innerHTML = renderPosts(postList);
    });
</script>


</body>

</html>